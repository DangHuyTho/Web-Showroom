<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\InventoryLog;

class InventoryController extends Controller
{
    /**
     * Show inventory list with filter and search
     */
    public function index(Request $request)
    {
        $query = Product::with(['brand', 'category']);

        // Filter by brand
        if ($request->has('brand_id') && $request->brand_id) {
            $query->where('brand_id', $request->brand_id);
        }

        // Filter by category
        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by stock status
        if ($request->has('stock_status') && $request->stock_status) {
            if ($request->stock_status === 'low') {
                $query->whereRaw('quantity > 0 AND quantity <= min_stock');
            } elseif ($request->stock_status === 'out') {
                $query->where('quantity', 0);
            } elseif ($request->stock_status === 'ok') {
                $query->whereRaw('quantity > min_stock');
            }
        }

        // Search by product name or SKU
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        // Sort
        $sort = $request->get('sort', 'name');
        $direction = $request->get('direction', 'asc');
        
        if ($sort === 'quantity') {
            $query->orderBy('quantity', $direction);
        } elseif ($sort === 'status') {
            $query->orderByRaw('IF(quantity <= min_stock, 1, 0) ' . strtoupper($direction));
        } else {
            $query->orderBy($sort, $direction);
        }

        $products = $query->paginate(20);
        $brands = Brand::active()->get();
        $categories = Category::active()->get();

        return view('staff.inventory.index', compact('products', 'brands', 'categories'));
    }

    /**
     * Show edit inventory form
     */
    public function edit($id)
    {
        $product = Product::with(['brand', 'category'])->findOrFail($id);
        return view('staff.inventory.edit', compact('product'));
    }

    /**
     * Update inventory quantity
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'shelf_location' => 'nullable|string|max:50',
            'notes' => 'nullable|string|max:500',
        ], [
            'quantity.required' => 'Vui lòng nhập số lượng',
            'quantity.integer' => 'Số lượng phải là số nguyên',
            'min_stock.required' => 'Vui lòng nhập số lượng tối thiểu',
        ]);

        $product = Product::findOrFail($id);
        
        // Store old quantity for reference
        $oldQuantity = $product->quantity;
        
        // Calculate quantity change
        $quantityChanged = intval($validated['quantity']) - $oldQuantity;
        
        // Update product
        $product->update([
            'quantity' => $validated['quantity'],
            'min_stock' => $validated['min_stock'],
            'shelf_location' => $validated['shelf_location'] ?? $product->shelf_location,
        ]);

        // Log the change if quantity changed
        if ($quantityChanged !== 0) {
            InventoryLog::logAction(
                $product->id,
                'adjustment',
                $quantityChanged,
                null,
                $validated['notes'] ?? null,
                auth()->id()
            );
        }

        return redirect()->route('staff.inventory.index')
            ->with('success', "Cập nhật tồn kho '{$product->name}' thành công!");
    }

    /**
     * Show inventory report/statistics
     */
    public function report()
    {
        // Low stock products (exclude out of stock)
        $lowStockProducts = Product::with('brand')
            ->whereRaw('quantity > 0 AND quantity <= min_stock')
            ->orderBy('quantity', 'asc')
            ->limit(20)
            ->get();

        // Out of stock products
        $outOfStockProducts = Product::with('brand')
            ->where('quantity', 0)
            ->orderBy('name', 'asc')
            ->limit(20)
            ->get();

        // Total inventory value
        $totalValue = Product::selectRaw('SUM(quantity * price) as total')
            ->first()
            ->total ?? 0;

        // Total products in stock
        $totalQuantity = Product::sum('quantity');

        // Products by brand
        $productsByBrand = Product::with('brand')
            ->selectRaw('brand_id, SUM(quantity) as total_quantity, COUNT(*) as product_count')
            ->groupBy('brand_id')
            ->orderBy('total_quantity', 'desc')
            ->get();

        return view('staff.inventory.report', compact(
            'lowStockProducts',
            'outOfStockProducts',
            'totalValue',
            'totalQuantity',
            'productsByBrand'
        ));
    }

    /**
     * Adjust inventory (add/remove)
     */
    public function adjust(Request $request, $id)
    {
        $validated = $request->validate([
            'adjustment' => 'required|integer',
            'reason' => 'required|in:receive,damage,return,other',
            'notes' => 'nullable|string|max:500',
        ], [
            'adjustment.required' => 'Vui lòng nhập số lượng điều chỉnh',
            'reason.required' => 'Vui lòng chọn lý do điều chỉnh',
        ]);

        $product = Product::findOrFail($id);
        $oldQuantity = $product->quantity;
        $adjustment = intval($validated['adjustment']);
        $newQuantity = max(0, $oldQuantity + $adjustment);

        $product->update(['quantity' => $newQuantity]);

        // Map reason to action type
        $actionTypeMap = [
            'receive' => 'stock_in',
            'damage' => 'damage',
            'return' => 'return',
            'other' => 'adjustment',
        ];

        // Log the adjustment
        InventoryLog::logAction(
            $product->id,
            $actionTypeMap[$validated['reason']] ?? 'adjustment',
            $adjustment,
            null,
            $validated['notes'] ?? null,
            auth()->id()
        );

        return redirect()->back()
            ->with('success', "Điều chỉnh tồn kho '{$product->name}' thành công!");
    }
}
