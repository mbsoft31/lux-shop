<?php

namespace Database\Seeders;

use App\Models\Inventory;
use App\Models\InventoryItem;
use App\Models\User;
use Core\Auth\Enums\UserRole;
use Core\Auth\Providers\AuthFacade;
use Core\Product\Enums\InventoryItemStatus;
use Core\Product\Providers\ProductFacade;
use Core\Sales\Enums\PaymentMethod;
use Core\Sales\Providers\SalesFacade;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Random\RandomException;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * @throws Exception
     */
    public function run(): void
    {
        $this->seedUsers();
        $this->seedProducts();
        $this->seedSales();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function seedProducts(): void
    {
        // Seed products
        $products = [
            [
                'name' => 'Lacoste Polo Shirt',
                'description' => 'Classic Lacoste polo shirt',
                'quantity' => 30,
                'variants' => [
                    [
                        'purchase_price' => 49.99,
                        'sell_price' => 89.99,
                        'brand' => 'Lacoste',
                        'color' => 'White',
                        'size' => 'M',
                        'quantity' => 20,
                        'material' => 'Cotton',
                        'style' => 'Casual',
                        'image' => 'lacoste-polo-shirt.jpg',
                        'barcode' => '1234567890',
                        'sku' => 'LACOSTE-123',
                        'status' => InventoryItemStatus::InStock->value,
                        'meta' => [
                            'is_best_seller' => true,
                            'is_new' => false,
                            'is_featured' => true,
                        ],
                    ],
                    [
                        'purchase_price' => 52.99,
                        'sell_price' => 99.99,
                        'brand' => 'Lacoste',
                        'color' => 'black',
                        'size' => 'M',
                        'quantity' => 10,
                        'material' => 'Cotton',
                        'style' => 'Casual',
                        'image' => 'lacoste-polo-shirt.jpg',
                        'barcode' => '1234567890',
                        'sku' => 'LACOSTE-123',
                        'status' => InventoryItemStatus::InStock->value,
                        'meta' => [
                            'is_best_seller' => true,
                            'is_new' => false,
                            'is_featured' => true,
                        ],
                    ]
                ]
            ],
            [
                'name' => 'Nike Air Max 90',
                'description' => 'Iconic Nike Air Max 90 sneakers',
                'quantity' => 30, // Fill in the missing attribute
                'variants' => [
                    ['price' => 119.99,
                        'purchase_price' => 89.99, // Fill in the missing attribute
                        'sell_price' => 119.99, // Fill in the missing attribute
                        'brand' => 'Nike',
                        'color' => 'Black',
                        'size' => 'US 10',
                        'quantity' => 30, // Fill in the missing attribute
                        'material' => 'Synthetic', // Fill in the missing attribute
                        'style' => 'Sport', // Fill in the missing attribute
                        'image' => 'nike-air-max-90.jpg', // Fill in the missing attribute
                        'barcode' => '0987654321', // Fill in the missing attribute
                        'sku' => 'NIKE-456', // Fill in the missing attribute
                        'status' => InventoryItemStatus::InStock->value,
                        'meta' => [
                            'is_best_seller' => true,
                            'is_new' => false,
                            'is_featured' => true,
                        ],]
                ]
            ],
            [
                'name' => 'Adidas Originals Superstar',
                'description' => 'Classic Adidas Originals Superstar sneakers',
                'quantity' => 25, // Fill in the missing attribute
                'variants' => [
                    ['price' => 79.99,
                        'purchase_price' => 59.99, // Fill in the missing attribute
                        'sell_price' => 79.99, // Fill in the missing attribute
                        'brand' => 'Adidas',
                        'color' => 'White',
                        'size' => 'US 9',
                        'quantity' => 25, // Fill in the missing attribute
                        'material' => 'Leather', // Fill in the missing attribute
                        'style' => 'Casual', // Fill in the missing attribute
                        'image' => 'adidas-superstar.jpg', // Fill in the missing attribute
                        'barcode' => '1357924680', // Fill in the missing attribute
                        'sku' => 'ADIDAS-789', // Fill in the missing attribute
                        'status' => InventoryItemStatus::InStock->value,
                        'meta' => [
                            'is_best_seller' => true,
                            'is_new' => false,
                            'is_featured' => true,
                        ],]
                ]
            ],
            [
                'name' => 'Ralph Lauren Polo Shirt',
                'description' => 'Signature Ralph Lauren polo shirt',
                'quantity' => 15, // Fill in the missing attribute
                'variants' => [
                    ['price' => 99.99,
                        'purchase_price' => 69.99, // Fill in the missing attribute
                        'sell_price' => 99.99, // Fill in the missing attribute
                        'brand' => 'Ralph Lauren',
                        'color' => 'Blue',
                        'size' => 'L',
                        'quantity' => 15, // Fill in the missing attribute
                        'material' => 'Cotton', // Fill in the missing attribute
                        'style' => 'Casual', // Fill in the missing attribute
                        'image' => 'ralph-lauren-polo-shirt.jpg', // Fill in the missing attribute
                        'barcode' => '2468013579', // Fill in the missing attribute
                        'sku' => 'RALPH-101', // Fill in the missing attribute
                        'status' => InventoryItemStatus::InStock->value,
                        'meta' => [
                            'is_best_seller' => true,
                            'is_new' => false,
                            'is_featured' => true,
                        ],]
                ],
            ],
            [
                'name' => 'Converse Chuck Taylor All Star',
                'description' => 'Iconic Converse Chuck Taylor All Star sneakers',
                'quantity' => 35, // Fill in the missing attribute
                'variants' => [
                    [
                        'purchase_price' => 39.99, // Fill in the missing attribute
                        'sell_price' => 59.99, // Fill in the missing attribute
                        'brand' => 'Converse',
                        'color' => 'Red',
                        'size' => 'US 8',
                        'quantity' => 35, // Fill in the missing attribute
                        'material' => 'Canvas', // Fill in the missing attribute
                        'style' => 'Casual', // Fill in the missing attribute
                        'image' => 'converse-chuck-taylor.jpg', // Fill in the missing attribute
                        'barcode' => '9876543210', // Fill in the missing attribute
                        'sku' => 'CONVERSE-202', // Fill in the missing attribute
                        'status' => InventoryItemStatus::InStock->value,
                        'meta' => [
                            'is_best_seller' => true,
                            'is_new' => false,
                            'is_featured' => true,
                        ],
                    ],
                ],

            ],
            [
                'name' => 'Tommy Hilfiger Crewneck Sweater',
                'description' => 'Classic Tommy Hilfiger crewneck sweater',
                'quantity' => 10, // Fill in the missing attribute
                'variants' => [
                    ['purchase_price' => 99.99, // Fill in the missing attribute
                        'sell_price' => 129.99, // Fill in the missing attribute
                        'brand' => 'Tommy Hilfiger',
                        'color' => 'Navy',
                        'size' => 'M',
                        'quantity' => 10, // Fill in the missing attribute
                        'material' => 'Wool', // Fill in the missing attribute
                        'style' => 'Casual', // Fill in the missing attribute
                        'image' => 'tommy-hilfiger-sweater.jpg', // Fill in the missing attribute
                        'barcode' => '0123456789', // Fill in the missing attribute
                        'sku' => 'TOMMY-303', // Fill in the missing attribute
                        'status' => InventoryItemStatus::InStock->value,
                        'meta' => [
                            'is_best_seller' => true,
                            'is_new' => false,
                            'is_featured' => true,
                        ],]
                ],
            ],
            [
                'name' => 'Puma Suede Classic Sneakers',
                'description' => 'Timeless Puma Suede Classic sneakers',
                'quantity' => 40, // Fill in the missing attribute
                'variants' => [
                    ['purchase_price' => 49.99, // Fill in the missing attribute
                        'sell_price' => 69.99, // Fill in the missing attribute
                        'brand' => 'Puma',
                        'color' => 'Black',
                        'size' => 'US 9',
                        'quantity' => 40, // Fill in the missing attribute
                        'material' => 'Suede', // Fill in the missing attribute
                        'style' => 'Casual', // Fill in the missing attribute
                        'image' => 'puma-suede-classic.jpg', // Fill in the missing attribute
                        'barcode' => '6789012345', // Fill in the missing attribute
                        'sku' => 'PUMA-404', // Fill in the missing attribute
                        'status' => InventoryItemStatus::InStock->value,
                        'meta' => [
                            'is_best_seller' => true,
                            'is_new' => false,
                            'is_featured' => true,
                        ],]
                ]
            ],
            [
                'name' => 'Levi\'s 501 Original Fit Jeans',
                'description' => 'Classic Levi\'s 501 Original Fit jeans',
                'quantity' => 20, // Fill in the missing attribute
                'variants' => [
                    ['purchase_price' => 59.99, // Fill in the missing attribute
                        'sell_price' => 89.99, // Fill in the missing attribute
                        'brand' => 'Levi\'s',
                        'color' => 'Denim Blue',
                        'size' => '32W 32L',
                        'quantity' => 20, // Fill in the missing attribute
                        'material' => 'Denim', // Fill in the missing attribute
                        'style' => 'Casual', // Fill in the missing attribute
                        'image' => 'levis-501-jeans.jpg', // Fill in the missing attribute
                        'barcode' => '3456789012', // Fill in the missing attribute
                        'sku' => 'LEVIS-505', // Fill in the missing attribute
                        'status' => InventoryItemStatus::InStock->value,
                        'meta' => [
                            'is_best_seller' => true,
                            'is_new' => false,
                            'is_featured' => true,
                        ],]
                ],
            ],
            [
                'name' => 'New Balance 574 Sneakers',
                'description' => 'Iconic New Balance 574 sneakers',
                'quantity' => 30, // Fill in the missing attribute
                'variants' => [
                    ['purchase_price' => 59.99, // Fill in the missing attribute
                        'sell_price' => 79.99, // Fill in the missing attribute
                        'brand' => 'New Balance',
                        'color' => 'Grey',
                        'size' => 'US 10',
                        'quantity' => 30, // Fill in the missing attribute
                        'material' => 'Suede', // Fill in the missing attribute
                        'style' => 'Casual', // Fill in the missing attribute
                        'image' => 'new-balance-574.jpg', // Fill in the missing attribute
                        'barcode' => '7890123456', // Fill in the missing attribute
                        'sku' => 'NEWBAL-606', // Fill in the missing attribute
                        'status' => InventoryItemStatus::InStock->value,
                        'meta' => [
                            'is_best_seller' => true,
                            'is_new' => false,
                            'is_featured' => true,
                        ],]
                ],
            ],
            [
                'name' => 'Calvin Klein Boxer Briefs (3-Pack)',
                'description' => 'Comfortable Calvin Klein boxer briefs in a pack of three',
                'quantity' => 50, // Fill in the missing attribute
                'variants' => [
                    ['purchase_price' => 29.99, // Fill in the missing attribute
                        'sell_price' => 39.99, // Fill in the missing attribute
                        'brand' => 'Calvin Klein',
                        'color' => 'Assorted',
                        'size' => 'L',
                        'quantity' => 50, // Fill in the missing attribute
                        'material' => 'Cotton', // Fill in the missing attribute
                        'style' => 'Casual', // Fill in the missing attribute
                        'image' => 'calvin-klein-boxer-briefs.jpg', // Fill in the missing attribute
                        'barcode' => '4567890123', // Fill in the missing attribute
                        'sku' => 'CALVIN-707', // Fill in the missing attribute
                        'status' => InventoryItemStatus::InStock->value,
                        'meta' => [
                            'is_best_seller' => true,
                            'is_new' => false,
                            'is_featured' => true,
                        ],]
                ],
            ],
            [
                'name' => 'Vans Old Skool Skate Shoes',
                'description' => 'Classic Vans Old Skool skate shoes',
                'quantity' => 25, // Fill in the missing attribute
                'variants' => [
                    [
                        'purchase_price' => 49.99, // Fill in the missing attribute
                        'sell_price' => 69.99, // Fill in the missing attribute
                        'brand' => 'Vans',
                        'color' => 'Black and White',
                        'size' => 'US 9',
                        'quantity' => 25, // Fill in the missing attribute
                        'material' => 'Canvas', // Fill in the missing attribute
                        'style' => 'Casual', // Fill in the missing attribute
                        'image' => 'vans-old-skool.jpg', // Fill in the missing attribute
                        'barcode' => '5678901234', // Fill in the missing attribute
                        'sku' => 'VANS-808', // Fill in the missing attribute
                        'status' => InventoryItemStatus::InStock->value,
                        'meta' => [
                            'is_best_seller' => true,
                            'is_new' => false,
                            'is_featured' => true,
                        ],
                    ]
                ],
            ],
            [
                'name' => 'Under Armour Tech Polo Shirt',
                'description' => 'Performance Under Armour polo shirt with moisture-wicking technology',
                'quantity' => 15, // Fill in the missing attribute
                'variants' => [
                    ['purchase_price' => 29.99, // Fill in the missing attribute
                        'sell_price' => 49.99, // Fill in the missing attribute
                        'brand' => 'Under Armour',
                        'color' => 'Grey',
                        'size' => 'XL',
                        'quantity' => 15, // Fill in the missing attribute
                        'material' => 'Polyester', // Fill in the missing attribute
                        'style' => 'Sport', // Fill in the missing attribute
                        'image' => 'under-armour-polo-shirt.jpg', // Fill in the missing attribute
                        'barcode' => '6789012345', // Fill in the missing attribute
                        'sku' => 'UNDER-909', // Fill in the missing attribute
                        'status' => InventoryItemStatus::InStock->value,
                        'meta' => [
                            'is_best_seller' => true,
                            'is_new' => false,
                            'is_featured' => true,
                        ],]
                ],
            ],
            [
                'name' => 'The North Face Resolve Waterproof Jacket',
                'description' => 'Durable and waterproof The North Face Resolve jacket',
                'quantity' => 10, // Fill in the missing attribute
                'variants' => [
                    ['purchase_price' => 99.99, // Fill in the missing attribute
                        'sell_price' => 149.99, // Fill in the missing attribute
                        'brand' => 'The North Face',
                        'color' => 'Black',
                        'size' => 'L',
                        'quantity' => 10, // Fill in the missing attribute
                        'material' => 'Nylon', // Fill in the missing attribute
                        'style' => 'Outdoor', // Fill in the missing attribute
                        'image' => 'north-face-waterproof-jacket.jpg', // Fill in the missing attribute
                        'barcode' => '7890123456', // Fill in the missing attribute
                        'sku' => 'NORTH-101', // Fill in the missing attribute
                        'status' => InventoryItemStatus::InStock->value,
                        'meta' => [
                            'is_best_seller' => true,
                            'is_new' => false,
                            'is_featured' => true,
                        ],]
                ],

            ],
        ];

        foreach ($products as $productData) {
            $data = array_merge($productData, []);
            $product = ProductFacade::create(data: $data);
            /*$inventory = ProductFacade::createInventory(productId: $product->id, data: $data);*/
            $inventory = Inventory::where('product_id', $product->id)->first();

            foreach ($productData['variants'] as $variant) {
                $variantData = array_merge($variant, []);
                ProductFacade::createInventoryItem(inventoryId: $inventory->id, data: $variantData);
            }
        }
    }

    /**
     * @return void
     */
    public function seedUsers(): void
    {
        $admin = AuthFacade::createUser(
            UserRole::ADMINISTRATOR,
            [
                'name' => 'Admin User',
                'email' => 'admin@mail.com',
            ]
        );

        $cashier = AuthFacade::createUser(UserRole::CASHIER, [
            'name' => 'Cashier User',
            'email' => 'cashier@mail.com',
        ]);

        $inventoryManager = AuthFacade::createUser(UserRole::INVENTORY_MANAGER, [
            'name' => 'Inventory Manager User',
            'email' => 'inventory@mail.com',
        ]);
    }

    /**
     * @return void
     * @throws RandomException
     */
    public function seedSales(): void
    {
        // Seed sales
        $productIds = InventoryItem::pluck('id')->toArray();

        // auth as cashier
        Auth::login(User::where('email', 'cashier@mail.com')->first());
        for ($i = 0; $i < 10; $i++) {

            $sale = SalesFacade::createSale(
                paymentMethod: Arr::random(PaymentMethod::cases())
            );

            $productCount = random_int(1, 5);
            $items = [];
            for ($k = 0; $k < $productCount; $k++) {
                $inventory_item_id = random_int(1, count($productIds));
                $items[] = [
                    'inventory_item_id' => ProductFacade::findInventoryItem($inventory_item_id)->id,
                    'quantity' => random_int(1, 5),
                    'price' => ProductFacade::findInventoryItem($inventory_item_id)->sell_price,
                ];
            }

            SalesFacade::addSaleItems($sale->id, $items);
        }
    }
}
