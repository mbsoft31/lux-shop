<?php

namespace Core\Sales\Providers;

use App\Models\Sale;
use App\Models\SaleItem;
use Core\Customer\Models\CustomerData;
use Core\Customer\Providers\CustomerService;
use Core\Product\Providers\ProductFacade;
use Core\Product\Providers\ProductService;
use Core\Sales\Enums\PaymentMethod;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SalesService
{
    public function __construct(
        protected ProductService $productService,
        protected CustomerService $customerService,
    ){}

    public function createSale(
        ?int $customerId = 0,
        ?float $totalAmount = 0,
        PaymentMethod $paymentMethod = PaymentMethod::CASH
    ): Sale
    {
        $customer = $this->getCustomer($customerId);
        $sale = new Sale();
        $sale->fill([
            'user_id' => auth()->id(),
            'customer_id' => $customer->id,
            'total_amount' => $totalAmount,
            'payment_method' => $paymentMethod->value,
        ]);
        $sale->save();
        return $sale;
    }

    /**
     * @param int $saleId
     * @param int $inventoryItemId
     * @param int $quantity
     * @param float $price
     * @return SaleItem|Model
     * @throws ModelNotFoundException
     */
    public function addSaleItem(int $saleId, int $inventoryItemId, int $quantity, float $price,): Model|SaleItem
    {
        $sale = Sale::findOrFail($saleId);
        $inventoryItem = $this->productService->findInventoryItem($inventoryItemId);
        return $sale->items()->create([
            'inventory_item_id' => $inventoryItem->id,
            'quantity' => $quantity,
            'price' => $price,
        ]);
    }



    private function getCustomer(?int $customerId): CustomerData
    {
        if ($customerId === null || $customerId <= 0) {
            return $this->customerService->createGuestCustomer();
        }
        return $this->customerService->find($customerId);
    }

    /*private function calculateTotalAmount(array $items): float
    {
        $totalAmount = 0;
        foreach ($items as $item) {
            $product = $this->productService->find($item['product_id']);
            $totalAmount += $product->price * $item['quantity'];
        }
        return $totalAmount;
    }*/


}
