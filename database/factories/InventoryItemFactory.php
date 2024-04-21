<?php

namespace Database\Factories;

use App\Models\Inventory;
use App\Models\Product;
use Core\Product\Enums\InventoryItemStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InventoryItem>
 */
class InventoryItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $price = $this->faker->randomFloat(2, 10, 200);
        return [
            'product_id' => Product::factory(),
            'inventory_id' => Inventory::factory(),
            'purchase_price' => $price,
            'sell_price' => $price + $this->faker->randomFloat(2, 10, 100),
            'quantity' => $this->faker->numberBetween(0, 100),
            'size' => $this->faker->randomElement(['S', 'M', 'L', 'XL']),
            'color' => $this->faker->randomElement(['Red', 'Green', 'Blue']),
            'material' => $this->faker->randomElement(['Cotton', 'Polyester', 'Wool']),
            'style' => $this->faker->randomElement(['Casual', 'Formal', 'Sport']),
            'status' => $this->faker->randomElement(array_map(fn($item) => $item->value, InventoryItemStatus::cases()))->value,
            'image' => $this->faker->imageUrl(),
            'barcode' => $this->faker->ean13(),
            'sku' => $this->faker->uuid(),
            'meta' => [
                'key' => 'value',
            ],
        ];
    }
}
