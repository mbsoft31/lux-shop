<?php

namespace Core\Product\Controllers\API;

use App\Models\Product;
use Core\Product\Models\ProductData;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController
{
    /**
     * Display a listing of the products.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $products = ProductData::collect(Product::all());
        return response()->json($products);
    }

    /**
     * Display the specified product.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $product = ProductData::fromModel(Product::findOrFail($id));
        return response()->json($product);
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
            'quantity' => 'required|integer|min:1',
        ]);

        // Find the product
        $product = Product::findOrFail($request->input('product_id'));

        // Calculate the item total before discount
        $itemTotal = $product->price * $request->input('quantity');

        // Check if there's a discount applicable for this product
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
        }

        // Reduce product quantity in inventory
        $product->decrement('quantity', $request->input('quantity'));

        // Return response with the processed sale information
        return response()->json([
            'message' => 'Sale processed successfully',
            'product' => $product,
            'quantity' => $request->input('quantity'),
            'item_total' => $itemTotal,
            'discount_amount' => $discountAmount
        ], 201);
    }
}
