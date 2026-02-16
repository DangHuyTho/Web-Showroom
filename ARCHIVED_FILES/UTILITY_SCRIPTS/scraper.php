<?php
require 'vendor/autoload.php';

use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;

class TotoScraper
{
    private $baseUrl = 'https://www.tdm.vn/thiet-bi-ve-sinh-toto';
    private $products = [];

    public function scrape()
    {
        echo "🔍 Bắt đầu scrape sản phẩm TOTO từ tdm.vn...\n";
        
        // Scrape trang đầu tiên để lấy số lượng trang
        $page = 1;
        do {
            echo "\n📄 Đang scrape trang $page...\n";
            $url = $page === 1 ? $this->baseUrl : $this->baseUrl . "?page=$page";
            
            $products = $this->scrapePage($url);
            
            if (empty($products)) {
                echo "✅ Hoàn thành scrape!\n";
                break;
            }
            
            $this->products = array_merge($this->products, $products);
            $page++;
            
            // Để tránh bị block, sleep 1 giây giữa các request
            sleep(1);
            
        } while(true);

        echo "\n📊 Tổng sản phẩm scraped: " . count($this->products) . "\n";
        $this->saveToJson();
    }

    private function scrapePage($url)
    {
        $html = @file_get_contents($url);
        if (!$html) {
            echo "❌ Không thể fetch: $url\n";
            return [];
        }

        $dom = new \DOMDocument();
        @$dom->loadHTML($html);
        $xpath = new \DOMXPath($dom);

        $products = [];
        
        // Tìm tất cả product items
        $nodes = $xpath->query('//div[@class="product-item"]//h3[@class="product-name"]/a');
        
        if ($nodes->length === 0) {
            // Try alternative selector
            $nodes = $xpath->query('//a[@class="product_name"]');
        }

        foreach ($nodes as $idx => $node) {
            $title = trim($node->textContent);
            $link = $node->getAttribute('href');
            
            if (!$link) continue;
            
            // Lấy giá từ parent element
            $parentDiv = $node->parentNode->parentNode->parentNode;
            $priceNode = $xpath->query('.//span[@class="product-price"]', $parentDiv);
            
            $price = 0;
            if ($priceNode->length > 0) {
                $priceText = trim($priceNode->item(0)->textContent);
                $price = $this->parsePrice($priceText);
            }

            if ($title && $link) {
                $products[] = [
                    'name' => $title,
                    'url' => 'https://www.tdm.vn' . (strpos($link, '/') === 0 ? $link : '/' . $link),
                    'price' => $price,
                    'brand' => 'TOTO',
                    'category' => 'Thiết bị vệ sinh'
                ];
                
                echo "  ✓ $title - " . number_format($price, 0) . " đ\n";
            }
        }

        return $products;
    }

    private function parsePrice($text)
    {
        $text = preg_replace('/[^0-9]/', '', $text);
        return (int)$text;
    }

    private function saveToJson()
    {
        $json = json_encode($this->products, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        file_put_contents('toto_products.json', $json);
        echo "💾 Đã lưu vào toto_products.json\n";
    }
}

// Run scraper
$scraper = new TotoScraper();
$scraper->scrape();
