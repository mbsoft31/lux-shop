<?php

namespace Core\Sales\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Core\Sales\Models\SaleData;
use Illuminate\View\View;

class SalesController
{

    public function index(): View
    {
        $sales = SaleData::collect(Sale::all());
        return view('admin.sales.index', [
            'sales' => $sales,
        ]);
    }

    public function create(): View
    {
        return view('admin.sales.create', [

        ]);
    }

    public function pos(): View
    {
        return view('pos', [
            'products' => Product::all(),
            'types' => [
                'clothing' => __('Clothing'),
                'footwear' => __('Footwear'),
                'underwear' => __('Underwear'),
                'outerwear' => __('Outerwear'),
            ]
        ]);
    }

}
