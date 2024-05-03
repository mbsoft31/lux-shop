<?php

namespace Core\Sales\Livewire;

use App\Models\Customer;
use App\Models\Product;
use App\Models\User;
use Core\Product\Models\ProductData;
use Core\Sales\Enums\PaymentMethod;
use Core\Sales\Providers\SalesFacade;
use Core\Sales\Providers\SalesService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;

class SaleCreateForm extends Component
{

    public array $form;

    public array $users = [];
    public Collection $customers;
    public array $products = [];
    public bool $openCustomer;

    public function resetForm(): void
    {
        $this->reset('form');
        $this->fill([
            'openCustomer' => false,
            'form.user_id' => Auth::id(),
            'form.customer_id' => Customer::first()?->id,
            'form.total_amount' => 0,
            'form.discount_amount' => 0,
            'form.payment_method' => PaymentMethod::CASH->value,
        ]);
        foreach (User::all() as $user) {
            $users[$user->id] = $user->name;
        }
        $this->users = $users;

        $products = [];
        foreach (Product::all() as $product) {
            $products[$product->id] = $product->name;
        }
        $this->products = $products;

        /*$customers = [];
        foreach (Customer::all() as $customer) {
            $customers[$customer->id] = $customer->name;
        }
        $this->customers = $customers;*/
        $this->customers = Customer::all();
    }

    public function select($key): void
    {
        $this->form['customer_id'] = $key;
        $this->closeCustomers();
    }

    public function closeCustomers(): void
    {
        $this->openCustomer = false;
    }

    public function openCustomers(): void
    {
        $this->openCustomer = true;
    }

    public function mount(): void
    {
        $this->resetForm();
    }

    public function saveSale(): void
    {
        $sale = SalesFacade::createSale(
            customerId: $this->form['customer_id'],
            totalAmount: $this->form['total_amount'],
            paymentMethod:  PaymentMethod::tryFrom($this->form['payment_method'] ?? PaymentMethod::CASH),
        );
    }

    public function render(): View
    {
        return view("admin.sales.partials.sale-form", [
            'metaConfig' => []
        ]);
    }
}
