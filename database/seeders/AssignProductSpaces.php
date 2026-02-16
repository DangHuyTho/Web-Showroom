<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class AssignProductSpaces extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();
        
        foreach ($products as $product) {
            $spaces = $this->determineSpaces($product);
            
            foreach ($spaces as $space) {
                DB::table('product_space')->updateOrInsert(
                    ['product_id' => $product->id, 'space_type' => $space],
                    ['created_at' => now(), 'updated_at' => now()]
                );
            }
        }
        
        echo "Product spaces assigned successfully.\n";
    }

    /**
     * Determine spaces for a product based on brand and characteristics
     */
    private function determineSpaces($product): array
    {
        $spaces = [];
        $brandId = $product->brand_id;
        $name = strtolower($product->name);
        $size = $product->size;

        // TOTO (brand_id = 3) - Bathroom fixtures
        if ($brandId === 3) {
            $spaces[] = 'bathroom';
            return $spaces;
        }

        // Fuji (brand_id = 4) - Outdoor tiles
        if ($brandId === 4) {
            $spaces[] = 'outdoor';
            return $spaces;
        }

        // Royal and Viglacera - Tiles (can be used in multiple spaces)
        if ($brandId === 1 || $brandId === 2) {
            // Small tiles (≤30cm) - Primarily bathroom
            if ($size && $this->parseSize($size) <= 30) {
                $spaces[] = 'bathroom';
                // But can also be used in kitchen
                if (rand(0, 1) === 1) {
                    $spaces[] = 'kitchen';
                }
            }
            // Medium tiles (50x50) - Living room or kitchen
            elseif ($size && in_array($size, ['50x50', '50x100', '40x80'])) {
                $spaces[] = 'kitchen';
                if (rand(0, 1) === 1) {
                    $spaces[] = 'living_room';
                }
            }
            // Large tiles (≥60cm) - Living room or outdoor
            elseif ($size && $this->parseSize($size) >= 60) {
                $spaces[] = 'living_room';
                if (rand(0, 1) === 1) {
                    $spaces[] = 'outdoor';
                }
            }
            // Default - Living room
            else {
                $spaces[] = 'living_room';
            }
        }

        // If no spaces determined, default to living_room
        if (empty($spaces)) {
            $spaces[] = 'living_room';
        }

        return array_unique($spaces);
    }

    /**
     * Parse size string to get max dimension (e.g., "30x60" returns 60)
     */
    private function parseSize($size): int
    {
        if (!$size) return 0;
        
        $parts = explode('x', str_replace('X', 'x', $size));
        return max(array_map(function($p) {
            return (int) filter_var($p, FILTER_SANITIZE_NUMBER_INT);
        }, $parts));
    }
}
