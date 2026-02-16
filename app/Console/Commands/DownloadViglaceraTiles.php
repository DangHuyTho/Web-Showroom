<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use GuzzleHttp\Client;
use DOMDocument;
use DOMXPath;

class DownloadViglaceraTiles extends Command
{
    protected $signature = 'viglacera:download-tiles {--limit=50} {--pages=2}';
    protected $description = 'Download Viglacera tiles products and images from gachviglacera.vn';

    public function handle()
    {
        $this->info('Starting Viglacera tiles download...');
        
        $client = new Client([
            'verify' => false,
            'timeout' => 10,
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
            ]
        ]);

        $baseUrl = 'https://gachviglacera.vn/gach-lat-nen';
        $limit = $this->option('limit') ?? 50;
        $maxPages = $this->option('pages') ?? 2;
        $productsAdded = 0;

        try {
            for ($page = 1; $page <= $maxPages && $productsAdded < $limit; $page++) {
                $pageUrl = $page === 1 ? $baseUrl : "$baseUrl/page/$page";
                $this->info("Fetching page $page: $pageUrl");

                try {
                    $response = $client->get($pageUrl);
                    $html = (string)$response->getBody();

                    // Parse HTML
                    $dom = new DOMDocument('1.0', 'UTF-8');
                    @$dom->loadHTML('<?xml encoding="UTF-8">' . $html);
                    $xpath = new DOMXPath($dom);

                    // Find all product links - looking for h3 tags with links
                    $productNodes = $xpath->query('//h3//a[@href]');
                    $this->line("Found " . $productNodes->length . " product links on page $page");

                    foreach ($productNodes as $node) {
                        if ($productsAdded >= $limit) {
                            break;
                        }

                        $productUrl = $node->getAttribute('href');
                        if (empty($productUrl) || strpos($productUrl, 'http') !== 0) {
                            // Make absolute URL
                            if (strpos($productUrl, '/') === 0) {
                                $productUrl = 'https://gachviglacera.vn' . $productUrl;
                            } else {
                                continue;
                            }
                        }

                        try {
                            $this->line("Processing: $productUrl");
                            
                            // Fetch product page
                            $productResponse = $client->get($productUrl);
                            $productHtml = (string)$productResponse->getBody();

                            // Parse product details
                            $productDom = new DOMDocument('1.0', 'UTF-8');
                            @$productDom->loadHTML('<?xml encoding="UTF-8">' . $productHtml);
                            $productXpath = new DOMXPath($productDom);

                            // Get product name
                            $nameNode = $productXpath->query('//h1 | //title')->item(0);
                            $productName = $nameNode ? trim($nameNode->textContent) : basename($productUrl);
                            // Clean name
                            $productName = preg_replace('/\s*-\s*.*$/', '', $productName);
                            $productName = strip_tags($productName);
                            $productName = trim($productName);

                            // Get price - look for various price selectors
                            $priceText = '250000'; // default price
                            $priceNodes = $productXpath->query('//*[contains(text(), "₫") or contains(text(), "đ")]');
                            foreach ($priceNodes as $priceNode) {
                                $text = trim($priceNode->textContent);
                                if (preg_match('/(\d+[\.,]\d+\s*₫|đ)/', $text)) {
                                    $priceText = $text;
                                    break;
                                }
                            }
                            // Extract numeric price
                            $price = (int)preg_replace('/[^0-9]/', '', $priceText) ?: 250000;

                            // Get product image
                            $imgNodes = $productXpath->query('//img[@src]');
                            $imageUrl = null;
                            
                            foreach ($imgNodes as $img) {
                                $src = $img->getAttribute('src');
                                if (strpos($src, 'placeholder') === false && !empty($src) && 
                                    (strpos($src, '.jpg') !== false || strpos($src, '.png') !== false)) {
                                    $imageUrl = $src;
                                    if (strpos($src, 'http') !== 0) {
                                        if (strpos($src, '/') === 0) {
                                            $imageUrl = 'https://gachviglacera.vn' . $src;
                                        } else {
                                            $imageUrl = 'https://gachviglacera.vn/' . $src;
                                        }
                                    }
                                    break;
                                }
                            }

                            if (!$imageUrl) {
                                $this->warn("No image found for: $productName");
                                continue;
                            }

                            // Create product in database
                            $slug = Str::slug($productName);
                            
                            $product = Product::firstOrCreate(
                                ['name' => $productName],
                                [
                                    'slug' => $slug,
                                    'description' => "Sản phẩm gạch lát nền Viglacera từ gachviglacera.vn",
                                    'brand_id' => 2, // Viglacera brand ID
                                    'category_id' => 1, // Default category
                                    'price' => $price,
                                    'unit' => 'm²',
                                    'is_active' => 1
                                ]
                            );

                            // Download and save image
                            $imageName = Str::slug($productName) . '_' . time() . '.jpg';
                            $imageDir = public_path('images/products/viglacera');
                            
                            if (!is_dir($imageDir)) {
                                mkdir($imageDir, 0755, true);
                            }

                            try {
                                $imageResponse = $client->get($imageUrl);
                                $imagePath = $imageDir . '/' . $imageName;
                                file_put_contents($imagePath, $imageResponse->getBody());

                                // Create product image record
                                ProductImage::firstOrCreate(
                                    ['product_id' => $product->id, 'image_path' => 'images/products/viglacera/' . $imageName],
                                    ['is_primary' => 1]
                                );

                                $this->info("✓ Saved: $productName ({$price}₫)");
                                $productsAdded++;

                            } catch (\Exception $e) {
                                $this->error("Failed to download image: " . $e->getMessage());
                            }

                        } catch (\Exception $e) {
                            $this->error("Error processing product: " . $e->getMessage());
                        }

                        usleep(300000); // 300ms delay between requests
                    }

                } catch (\Exception $e) {
                    $this->error("Error fetching page $page: " . $e->getMessage());
                }

                usleep(1000000); // 1 second delay between pages
            }

            $this->info("Total products added: $productsAdded");

        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
        }
    }
}
?>
