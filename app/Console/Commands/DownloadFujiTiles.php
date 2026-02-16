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

class DownloadFujiTiles extends Command
{
    protected $signature = 'fuji:download-tiles {--limit=50}';
    protected $description = 'Download Fuji tiles products and images from gachtot.vn';

    public function handle()
    {
        $this->info('Starting Fuji tiles download...');
        
        $client = new Client([
            'verify' => false,
            'timeout' => 10,
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
            ]
        ]);

        $baseUrl = 'https://gachtot.vn/ngoi-lop-nha/ngoi-mau-fuji/';
        $limit = $this->option('limit') ?? 50;
        $productsAdded = 0;

        try {
            // Fetch main category page
            $response = $client->get($baseUrl);
            $html = (string)$response->getBody();

            // Parse HTML
            $dom = new DOMDocument('1.0', 'UTF-8');
            @$dom->loadHTML('<?xml encoding="UTF-8">' . $html);
            $xpath = new DOMXPath($dom);

            // Find all product links
            $productLinks = [];
            foreach ($xpath->query('//a[@href]') as $link) {
                $href = $link->getAttribute('href');
                // Match product URLs like https://gachtot.vn/sp/...
                if (preg_match('~https://gachtot\.vn/sp/[^/]+/$~', $href) && !in_array($href, $productLinks)) {
                    $productLinks[] = $href;
                }
            }

            $this->info('Found ' . count($productLinks) . ' product links');

            foreach ($productLinks as $index => $productUrl) {
                if ($productsAdded >= $limit) {
                    break;
                }

                try {
                    $this->line("[$index] Processing: $productUrl");
                    
                    // Fetch product page
                    $productResponse = $client->get($productUrl);
                    $productHtml = (string)$productResponse->getBody();

                    // Parse product details
                    $productDom = new DOMDocument('1.0', 'UTF-8');
                    @$productDom->loadHTML('<?xml encoding="UTF-8">' . $productHtml);
                    $productXpath = new DOMXPath($productDom);

                    // Get product name
                    $nameNode = $productXpath->query('//h1[@class="product-name"] | //h1')->item(0);
                    $productName = $nameNode ? trim($nameNode->textContent) : basename(rtrim($productUrl, '/'));

                    // Get price
                    $priceNode = $productXpath->query('//*[@class="price"] | //*[contains(text(), "₫")]')->item(0);
                    $priceText = $priceNode ? trim($priceNode->textContent) : '100000';
                    $price = preg_replace('/[^0-9]/', '', $priceText) ?: 100000;

                    // Get product image
                    $imgNodes = $productXpath->query('//img[@src]');
                    $imageUrl = null;
                    
                    foreach ($imgNodes as $img) {
                        $src = $img->getAttribute('src');
                        if (strpos($src, 'placeholder') === false && !empty($src)) {
                            $imageUrl = $src;
                            if (strpos($src, 'http') !== 0) {
                                $imageUrl = 'https://gachtot.vn' . (strpos($src, '/') === 0 ? '' : '/') . $src;
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
                            'description' => "Sản phẩm ngói Fuji từ gachtot.vn",
                            'brand_id' => 4, // Fuji brand ID
                            'category_id' => 1, // Default category
                            'price' => $price,
                            'unit' => 'viên',
                            'is_active' => 1
                        ]
                    );

                    // Download and save image
                    $imageName = Str::slug($productName) . '_' . time() . '.jpg';
                    $imageDir = public_path('images/products/fuji');
                    
                    if (!is_dir($imageDir)) {
                        mkdir($imageDir, 0755, true);
                    }

                    try {
                        $imageResponse = $client->get($imageUrl);
                        $imagePath = $imageDir . '/' . $imageName;
                        file_put_contents($imagePath, $imageResponse->getBody());

                        // Create product image record
                        ProductImage::firstOrCreate(
                            ['product_id' => $product->id, 'image_path' => 'images/products/fuji/' . $imageName],
                            ['is_primary' => 1]
                        );

                        $this->info("✓ Saved: $productName with image $imageName");
                        $productsAdded++;

                    } catch (\Exception $e) {
                        $this->error("Failed to download image: " . $e->getMessage());
                    }

                } catch (\Exception $e) {
                    $this->error("Error processing product: " . $e->getMessage());
                }

                usleep(500000); // 500ms delay between requests
            }

            $this->info("Total products added: $productsAdded");

        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
        }
    }
}
?>
