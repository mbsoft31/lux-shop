<?php

namespace Core\Sales\Providers;

use App\Models\InventoryItem;
use App\Models\Sale;
use App\Models\SaleItem;
use Core\Customer\Models\CustomerData;
use Core\Customer\Providers\CustomerService;
use Core\Product\Providers\ProductService;
use Core\Sales\Enums\PaymentMethod;
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
     * @param array $items
     * @return void
     * @throws ModelNotFoundException
     */
    public function addSaleItems(int $saleId, array $items): void
    {
        $sale = Sale::findOrFail($saleId);
        for ($j = 0; $j < count($items); $j++) {
            $item = $items[$j];

            $this->addSaleItem(
                saleId: $sale->id,
                inventoryItemId: $item['inventory_item_id'],
                quantity: $item['quantity'],
                price: $item['price'],
                discount_amount: $item['discount_amount'],
                total_amount: $item['total_amount']
            );
        }
        $sale->calculateTotalAmount();
    }

    /**
     * @param int $saleId
     * @param int $inventoryItemId
     * @param int $quantity
     * @param float $price
     * @param float $discount_amount
     * @param float $total_amount
     * @return SaleItem|Model
     * @throws ModelNotFoundException<InventoryItem>
     */
    public function addSaleItem(int $saleId, int $inventoryItemId, int $quantity, float $price, float $discount_amount = 0, float $total_amount = 0): Model|SaleItem
    {
        $sale = Sale::findOrFail($saleId);
        $inventoryItem = $this->productService->findInventoryItem($inventoryItemId);
        return $sale->items()->create([
            'inventory_item_id' => $inventoryItem->id,
            'quantity' => $quantity,
            'price' => $price,
            'discount_amount' => $discount_amount,
            'total_amount' => $total_amount
        ]);
    }

    private function getCustomer(?int $customerId): CustomerData
    {
        if ($customerId === null || $customerId <= 0) {
            return $this->customerService->createGuestCustomer();
        }
        return $this->customerService->find($customerId);
    }

    public function calculateTotalAmount(array $items)
    {
        return collect($items)->sum(fn($item) => $item['quantity'] * $item['price']);
    }
}
