<?php

namespace Core\Sales\Controllers;

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

}
