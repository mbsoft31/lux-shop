<?php

namespace Core\Customer\Providers;

use App\Models\Customer;
use Core\Customer\Models\CustomerData;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Spatie\LaravelData\DataCollection;

class CustomerService
{
    public function __construct()
    {
    }

    /**
     * @return array|Collection<CustomerData>|DataCollection<CustomerData>
     */
    public function all(): array|Collection|DataCollection
    {
        return CustomerData::collect(Customer::all());
    }

    public function create(array $data): CustomerData
    {
        $customerData = CustomerData::fromArray($data);
        $customer = $customerData->toModel();
        $customer->save();

        return $customerData->fromModel($customer);
    }

    public function update(int $id, array $data): CustomerData
    {
        $customerData = CustomerData::fromArray($data);
        $customer = Customer::findOrFail($id);
        $customer->update($customerData->toArray());

        return $customerData->fromModel($customer);
    }

    public function delete(int $id): int
    {
        return Customer::destroy($id);
    }

    /**
     * @param int $id
     * @return CustomerData
     * @throws ModelNotFoundException<Customer>
     */
    public function find(int $id): CustomerData
    {
        return CustomerData::fromModel(Customer::findOrFail($id));
    }

    public function createGuestCustomer()
    {
        return $this->create([
            'name' => 'Guest',
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
        ]);
    }
}
