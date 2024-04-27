<?php

namespace Core\Product\Controllers\API;

use App\Models\Product;
use Core\Product\Models\ProductData;
use Core\Product\Providers\ProductFacade as ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController
{
    /**
     * Display a listing of the products.
     *
     * @return View
     */
    public function index(): View
    {
        $products = ProductData::collect(Product::all());
        return view('admin.product.index', [
            'products' => $products,
        ]);
    }

    /**
     * Display the specified product.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $product = ProductService::find($id);
        return response()->json($product);
    }

    /**
     * Store a newly created product in storage.
     *
     * @param ProductStoreRequest $request
     * @return RedirectResponse
     */
    public function store(ProductStoreRequest $request): RedirectResponse
    {
        // Create the product
        $product = ProductService::create($request->validated());

        // Return response with the created product information
        return back()->with('success', 'Product created successfully');
    }

    /**
     * Update the specified product in storage.
     *
     * @param ProductStoreRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): \Illuminate\Http\RedirectResponse
    {
        $inputs = $request->all();
        $inputs['id'] = $id;

        // upload image
        if ($request->hasFile('image')) {
            $inputs['image'] = $request->file('image')->store('public/products/'. $id);
            $inputs['image'] = Storage::url($inputs['image']);
        }
        // Update the product
        $product = ProductService::update($id, $inputs);

        // Return response with the updated product information
        return back()->with('success', 'Product updated successfully');
    }

    /**
     * Process sale for the product.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function processSale(Request $request): JsonResponse
    {
        // Validate request data
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'inventory_item_id' => 'required|exists:inventory_items,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Find the product
        $product = ProductService::find($request->input('product_id'));
        $inventoryItem = ProductService::findInventoryItem($request->input('inventory_item_id'));
        // Calculate the item total before discount
        $itemTotal = $inventoryItem->sell_price * $request->input('quantity');

        /*// Check if there's a discount applicable for this product
        $discount = Discount::where('product_id', $product->id)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();

        // Apply discount if available
        if ($discount) {
            // Calculate the discount amount
            $discountAmount = $itemTotal * ($discount->percentage / 100);
            $itemTotal -= $discountAmount;
        } else {
            $discountAmount = 0;
        }*/

        // Reduce product quantity in inventory
        $inventoryItem = ProductService::updateInventoryItemQuantity(
            $inventoryItem->id,
            $inventoryItem->quantity - $request->input('quantity')
        );
        // $inventoryItem->decrement('quantity', $request->input('quantity'));

        // Return response with the processed sale information
        return response()->json([
            'message' => 'Sale processed successfully',
            'product' => $product,
            'inventory_item' => $inventoryItem,
            'quantity' => $request->input('quantity'),
            'item_total' => $itemTotal,
            'discount_amount' => $discountAmount ?? 0,
        ], 201);
    }
}
