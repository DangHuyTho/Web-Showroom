<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalculatorController extends Controller
{
    public function index()
    {
        return view('calculator.index');
    }

    public function calculate(Request $request)
    {
        $request->validate([
            'product_type' => 'required|in:tile,roof_tile',
            'area' => 'required|numeric|min:0.1',
            'size' => 'required|string',
        ]);

        $area = $request->area;
        $size = $request->size;
        $productType = $request->product_type;

        $result = [];

        if ($productType === 'tile') {
            // Parse size (e.g., "60x60" or "80x80")
            list($width, $height) = explode('x', $size);
            $tileArea = ($width / 100) * ($height / 100); // Convert cm to m²
            $tilesNeeded = ceil($area / $tileArea * 1.1); // Add 10% waste
            $boxesNeeded = ceil($tilesNeeded / 4); // Assuming 4 tiles per box

            $result = [
                'tiles_needed' => $tilesNeeded,
                'boxes_needed' => $boxesNeeded,
                'tile_area' => $tileArea,
            ];
        } elseif ($productType === 'roof_tile') {
            // For roof tiles, typically 10-12 tiles per m² depending on type
            $tilesPerSquareMeter = 11; // Average
            $tilesNeeded = ceil($area * $tilesPerSquareMeter * 1.1); // Add 10% waste

            $result = [
                'tiles_needed' => $tilesNeeded,
                'tiles_per_sqm' => $tilesPerSquareMeter,
            ];
        }

        return view('calculator.result', compact('result', 'area', 'size', 'productType'));
    }
}
