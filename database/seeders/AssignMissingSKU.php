<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class AssignMissingSKU extends Seeder
{
    public function run(): void
    {
        // Get all products without SKU
        $productsWithoutSKU = Product::whereNull('sku')
            ->orWhere('sku', '')
            ->get();

        $count = 0;
        $skuCounters = [
            1 => 1,  // Royal
            2 => 1,  // Viglacera
            3 => 1,  // TOTO
            4 => 1,  // Fuji
        ];

        foreach ($productsWithoutSKU as $product) {
            $brandPrefix = $this->getBrandPrefix($product->brand_id);
            
            // Generate SKU based on product attributes
            $sku = $this->generateSKU($product, $brandPrefix, $skuCounters[$product->brand_id]);
            
            // Ensure uniqueness
            while (Product::where('sku', $sku)->exists()) {
                $skuCounters[$product->brand_id]++;
                $sku = $this->generateSKU($product, $brandPrefix, $skuCounters[$product->brand_id]);
            }

            $product->update(['sku' => $sku]);
            $skuCounters[$product->brand_id]++;
            $count++;

            $this->command->line("✓ Product ID: {$product->id} → SKU: {$sku}");
        }

        $this->command->info("✓ Assigned SKU to {$count} products!");
    }

    private function getBrandPrefix($brandId): string
    {
        return match($brandId) {
            1 => 'ROYAL',
            2 => 'VIG',
            3 => 'TOTO',
            4 => 'FUJI',
            default => 'PROD',
        };
    }

    private function generateSKU(Product $product, string $prefix, int $counter): string
    {
        // Extract size from product if available
        $sizeCode = '';
        if ($product->size) {
            // Try to extract dimensions like "30×60" or "600x400"
            preg_match('/(\d+)[×x](\d+)/', $product->size, $matches);
            if ($matches) {
                $sizeCode = "{$matches[1]}X{$matches[2]}";
            }
        }

        // Extract material code from name (e.g., tile material type)
        $materialCode = '';
        if ($product->material) {
            $materialCode = strtoupper(substr(str_replace(' ', '', $product->material), 0, 3));
        }

        // Surface type code
        $surfaceCode = '';
        if ($product->surface_type) {
            if (strpos(strtolower($product->surface_type), 'gloss') !== false) {
                $surfaceCode = 'GL';
            } elseif (strpos(strtolower($product->surface_type), 'matte') !== false) {
                $surfaceCode = 'MT';
            } elseif (strpos(strtolower($product->surface_type), 'rough') !== false) {
                $surfaceCode = 'RG';
            }
        }

        // Build SKU
        $components = [$prefix];
        
        if ($sizeCode) {
            $components[] = $sizeCode;
        }
        
        if ($surfaceCode) {
            $components[] = $surfaceCode;
        }
        
        $components[] = str_pad($counter, 4, '0', STR_PAD_LEFT);

        return implode('-', $components);
    }
}
