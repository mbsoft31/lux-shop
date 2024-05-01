<?php

namespace Database\Seeders;

use App\Models\Inventory;
use App\Models\InventoryItem;
use App\Models\User;
use Core\Auth\Enums\UserRole;
use Core\Auth\Providers\AuthFacade;
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
                'purchase_price' => 49.99,
                'sell_price' => 89.99,
                'image' => 'nike-air-max-90.jpg',
                'meta' => [
                    'brand' => 'Lacoste',
                    'material' => 'Cotton',
                    'style' => 'Casual',
                    'type' => 'clothing',
                    'size_type' => 'char',
                    'size_chart' => 'S, M, L, XL, XXL',
                    'is_best_seller' => true,
                    'is_new' => false,
                    'is_featured' => true,
                ],
                'variants' => [
                    [
                        'barcode' => '1234567890',
                        'sku' => 'LACOSTE-123',
                        'quantity' => 4,
                        'meta' => [
                            'size' => 'M',
                            'color' => '#ffffff',
                        ],
                    ],
                    [
                        'barcode' => '1234567890',
                        'sku' => 'LACOSTE-123',
                        'quantity' => 6,
                        'meta' => [
                            'size' => 'M',
                            'color' => '#000000',
                        ],
                    ],
                    [
                        'barcode' => '1234567890',
                        'sku' => 'LACOSTE-123',
                        'quantity' => 2,
                        'meta' => [
                            'size' => 'M',
                            'color' => '#0000ff',
                        ],
                    ],
                    [
                        'barcode' => '1234567890',
                        'sku' => 'LACOSTE-123',
                        'quantity' => 3,
                        'meta' => [
                            'size' => 'M',
                            'color' => '#ff0000',
                        ],
                    ],
                    [
                        'barcode' => '1234567890',
                        'sku' => 'LACOSTE-123',
                        'quantity' => 5,
                        'meta' => [
                            'size' => 'M',
                            'color' => '#00ff00',
                        ],
                    ],
                    [
                        'barcode' => '1234567890',
                        'sku' => 'LACOSTE-123',
                        'quantity' => 7,
                        'meta' => [
                            'size' => 'L',
                            'color' => '#ffffff',
                        ],
                    ],
                    [
                        'barcode' => '1234567890',
                        'quantity' => 3,
                        'meta' => [
                            'size' => 'L',
                            'color' => '#000000',
                        ],
                    ]
                ]
            ],
            [
                'name' => 'Nike Air Max 90',
                'description' => 'Iconic Nike Air Max 90 sneakers',
                'purchase_price' => 59.99,
                'sell_price' => 79.99,
                'image' => 'nike-air-max-90.jpg',
                'meta' => [
                    'brand' => 'Nike',
                    'material' => 'Synthetic',
                    'style' => 'Sport',
                    'type' => 'footwear',
                    'size_type' => 'numeric',
                    'size_chart' => '31-45',
                    'is_best_seller' => true,
                    'is_new' => false,
                    'is_featured' => true,
                    'colors' => [
                        '#000000' => 10,
                        '#ffffff' => 5,
                        '#ff0000' => 3,
                        '#0000ff' => 7,
                        '#00ff00' => 5,
                    ],
                ],
                'variants' => [
                    [
                        'barcode' => '0987654321',
                        'quantity' => 10,
                        'meta' => [
                            'size' => '39',
                            'color' => '#000000',
                        ],
                    ],
                    [
                        'barcode' => '0987654321',
                        'quantity' => 5,
                        'meta' => [
                            'size' => '39',
                            'color' => '#ffffff',
                        ],
                    ],
                    [
                        'barcode' => '0987654321',
                        'quantity' => 3,
                        'meta' => [
                            'size' => '39',
                            'color' => '#ff0000',
                        ],
                    ],
                    [
                        'barcode' => '0987654321',
                        'quantity' => 7,
                        'meta' => [
                            'size' => '39',
                            'color' => '#0000ff',
                        ],
                    ],
                    [
                        'barcode' => '0987654321',
                        'quantity' => 5,
                        'meta' => [
                            'size' => '39',
                            'color' => '#00ff00',
                        ],
                    ],
                ]
            ],
            [
                'name' => 'Adidas Originals Superstar',
                'description' => 'Classic Adidas Originals Superstar sneakers',
                'purchase_price' => 59.99,
                'sell_price' => 79.99,
                'image' => 'adidas-superstar.jpg',
                'meta' => [
                    'brand' => 'Adidas',
                    'material' => 'Leather',
                    'style' => 'Casual',
                    'type' => 'footwear',
                    'size_type' => 'numeric',
                    'size_chart' => '31-45',
                    'is_best_seller' => true,
                    'is_new' => false,
                    'is_featured' => true,
                ],
                'variants' => [
                    [
                        'barcode' => '1357924680',
                        'quantity' => 2,
                        'meta' => [
                            'size' => '39',
                            'color' => '#ffffff',
                        ],
                    ],
                    [
                        'barcode' => '1357924680',
                        'quantity' => 2,
                        'meta' => [
                            'size' => '39',
                            'color' => '#000000',
                        ],
                    ],
                    [
                        'barcode' => '1357924680',
                        'quantity' => 2,
                        'meta' => [
                            'size' => '40',
                            'color' => '#ffffff',
                        ],
                    ],
                    [
                        'barcode' => '1357924680',
                        'quantity' => 2,
                        'meta' => [
                            'size' => '40',
                            'color' => '#000000',
                        ],
                    ],
                    [
                        'barcode' => '1357924680',
                        'quantity' => 2,
                        'meta' => [
                            'size' => '41',
                            'color' => '#ffffff',
                        ],
                    ],
                    [
                        'barcode' => '1357924680',
                        'quantity' => 2,
                        'meta' => [
                            'size' => '41',
                            'color' => '#000000',
                        ],
                    ],
                ]
            ],
            [
                'name' => 'Ralph Lauren Polo Shirt',
                'description' => 'Signature Ralph Lauren polo shirt',
                'purchase_price' => 69.99,
                'sell_price' => 99.99,
                'image' => 'ralph-lauren-polo-shirt.jpg',
                'meta' => [
                    'brand' => 'Ralph Lauren',
                    'material' => 'Cotton',
                    'style' => 'Casual',
                    'type' => 'clothing',
                    'size_type' => 'char',
                    'size_chart' => 'S, M, L, XL, XXL',
                    'is_best_seller' => true,
                    'is_new' => false,
                    'is_featured' => true,
                ],
                'variants' => [
                    [
                        'barcode' => '2468013579',
                        'quantity' => 3,
                        'meta' => [
                            'size' => 'M',
                            'color' => '#003366',
                        ],
                    ],
                    [
                        'barcode' => '2468013579',
                        'quantity' => 3,
                        'meta' => [
                            'size' => 'M',
                            'color' => '#663300',
                        ],
                    ],
                    [
                        'barcode' => '2468013579',
                        'quantity' => 2,
                        'meta' => [
                            'size' => 'L',
                            'color' => '#003366',
                        ],
                    ],
                    [
                        'barcode' => '2468013579',
                        'quantity' => 3,
                        'meta' => [
                            'size' => 'XL',
                            'color' => '#000000',
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Converse Chuck Taylor All Star',
                'description' => 'Iconic Converse Chuck Taylor All Star sneakers',
                'purchase_price' => 39.99,
                'sell_price' => 59.99,
                'image' => 'converse-chuck-taylor.jpg',
                'meta' => [
                    'brand' => 'Converse',
                    'material' => 'Canvas',
                    'style' => 'Casual',
                    'type' => 'footwear',
                    'size_type' => 'numeric',
                    'size_chart' => '31-45',
                    'is_best_seller' => true,
                    'is_new' => false,
                    'is_featured' => true,
                ],
                'variants' => [
                    [
                        'barcode' => '9876543210',
                        'quantity' => 35,
                        'meta' => [
                            'size' => 'US 8',
                            'color' => 'Red',
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Tommy Hilfiger Crewneck Sweater',
                'description' => 'Classic Tommy Hilfiger crewneck sweater',
                'purchase_price' => 99.99,
                'sell_price' => 129.99,
                'meta' => [
                    'brand' => 'Tommy Hilfiger',
                    'material' => 'Wool',
                    'style' => 'Casual',
                    'image' => 'tommy-hilfiger-sweater.jpg',
                    'type' => 'clothing',
                    'size_type' => 'char',
                    'size_chart' => 'S, M, L, XL, XXL',
                    'is_best_seller' => true,
                    'is_new' => false,
                    'is_featured' => true,
                ],
                'variants' => [
                    [
                        'barcode' => '0123456789',
                        'quantity' => 10,
                        'meta' => [
                            'size' => 'M',
                            'color' => '#003366',
                        ],
                    ]
                ],
            ],
            [
                'name' => 'Puma Suede Classic Sneakers',
                'description' => 'Timeless Puma Suede Classic sneakers',
                'purchase_price' => 49.99,
                'sell_price' => 69.99,
                'image' => 'puma-suede-classic.jpg',
                'meta' => [
                    'brand' => 'Puma',
                    'material' => 'Suede',
                    'style' => 'Casual',
                    'type' => 'footwear',
                    'size_type' => 'numeric',
                    'size_chart' => '31-45',
                    'is_best_seller' => true,
                    'is_new' => false,
                    'is_featured' => true,
                ],
                'variants' => [
                    [
                        'barcode' => '6789012345',
                        'quantity' => 40,
                        'meta' => [
                            'size' => 'US 9',
                            'color' => 'Black',
                        ],
                    ]
                ]
            ],
            [
                'name' => 'Levi\'s 501 Original Fit Jeans',
                'description' => 'Classic Levi\'s 501 Original Fit jeans',
                'purchase_price' => 59.99,
                'sell_price' => 89.99,
                'image' => 'levis-501-jeans.jpg',
                'meta' => [
                    'brand' => 'Levi\'s',
                    'material' => 'Denim',
                    'style' => 'Casual',
                    'type' => 'clothing',
                    'size_type' => 'char',
                    'size_chart' => 'W 28-38, L 30-34',
                    'is_best_seller' => true,
                    'is_new' => false,
                    'is_featured' => true,
                ],
                'variants' => [
                    [
                        'barcode' => '3456789012',
                        'quantity' => 20,
                        'meta' => [
                            'size' => '32W 32L',
                            'color' => '#000000',
                        ],
                    ]
                ],
            ],
            [
                'name' => 'New Balance 574 Sneakers',
                'description' => 'Iconic New Balance 574 sneakers',
                'purchase_price' => 59.99,
                'sell_price' => 79.99,
                'image' => 'new-balance-574.jpg',
                'meta' => [
                    'brand' => 'New Balance',
                    'material' => 'Suede',
                    'style' => 'Casual',
                    'type' => 'footwear',
                    'size_type' => 'numeric',
                    'size_chart' => '31-45',
                    'is_best_seller' => true,
                    'is_new' => false,
                    'is_featured' => true,
                ],
                'variants' => [
                    [
                        'barcode' => '7890123456',
                        'quantity' => 30,
                        'meta' => [
                            'size' => 'US 10',
                            'color' => '#333333',
                        ],]
                ],
            ],
            [
                'name' => 'Calvin Klein Boxer Briefs (3-Pack)',
                'description' => 'Comfortable Calvin Klein boxer briefs in a pack of three',
                'purchase_price' => 29.99,
                'sell_price' => 39.99,
                'image' => 'calvin-klein-boxer-briefs.jpg',
                'meta' => [
                    'brand' => 'Calvin Klein',
                    'material' => 'Cotton',
                    'style' => 'Casual',
                    'type' => 'underwear',
                    'size_type' => 'char',
                    'size_chart' => 'S, M, L, XL',
                    'is_best_seller' => true,
                    'is_new' => false,
                    'is_featured' => true,
                ],
                'variants' => [
                    [
                        'barcode' => '4567890123',
                        'quantity' => 50,
                        'meta' => [
                            'size' => 'L',
                            'color' => '#000000',
                        ],
                    ]
                ],
            ],
            [
                'name' => 'Vans Old Skool Skate Shoes',
                'description' => 'Classic Vans Old Skool skate shoes',
                'purchase_price' => 49.99,
                'sell_price' => 69.99,
                'quantity' => 25,
                'image' => 'vans-old-skool.jpg',
                'meta' => [
                    'brand' => 'Vans',
                    'material' => 'Canvas',
                    'style' => 'Casual',
                    'type' => 'footwear',
                    'size_type' => 'numeric',
                    'size_chart' => '31-45',
                    'is_best_seller' => true,
                    'is_new' => false,
                    'is_featured' => true,
                ],
                'variants' => [
                    [
                        'barcode' => '5678901234',
                        'quantity' => 25,
                        'meta' => [
                            'size' => 'US 9',
                            'color' => '#000000',
                        ],
                    ]
                ],
            ],
            [
                'name' => 'Under Armour Tech Polo Shirt',
                'description' => 'Performance Under Armour polo shirt with moisture-wicking technology',
                'purchase_price' => 29.99,
                'sell_price' => 49.99,
                'quantity' => 15,
                'image' => 'under-armour-polo-shirt.jpg',
                'meta' => [
                    'brand' => 'Under Armour',
                    'material' => 'Polyester',
                    'style' => 'Sport',
                    'type' => 'clothing',
                    'size_type' => 'char',
                    'size_chart' => 'S, M, L, XL, XXL',
                    'is_best_seller' => true,
                    'is_new' => false,
                    'is_featured' => true,
                ],
                'variants' => [
                    [
                        'barcode' => '6789012345',
                        'quantity' => 15,
                        'meta' => [
                            'color' => 'Grey',
                            'size' => 'XL',
                        ],
                    ]
                ],
            ],
            [
                'name' => 'The North Face Resolve Waterproof Jacket',
                'description' => 'Durable and waterproof The North Face Resolve jacket',
                'purchase_price' => 99.99,
                'sell_price' => 149.99,
                'quantity' => 10,
                'image' => 'north-face-waterproof-jacket.jpg',
                'meta' => [
                    'brand' => 'The North Face',
                    'material' => 'Nylon',
                    'style' => 'Outdoor',
                    'type' => 'outerwear',
                    'size_type' => 'char',
                    'size_chart' => 'S, M, L, XL, XXL',
                    'is_best_seller' => true,
                    'is_new' => false,
                    'is_featured' => true,
                ],
                'variants' => [
                    [
                        'barcode' => '7890123456',
                        'quantity' => 10,
                        'meta' => [
                            'size' => 'L',
                            'color' => 'Black',
                        ],
                    ]
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
                $inventory_item = ProductFacade::findInventoryItem($inventory_item_id);
                $items[] = [
                    'inventory_item_id' => $inventory_item->id,
                    'quantity' => random_int(1, 5),
                    'price' => $inventory_item->product()->sell_price,
                ];
            }

            SalesFacade::addSaleItems(
                saleId: $sale->id,
                items: $items,
            );
        }
    }
}
