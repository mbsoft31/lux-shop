<?php

namespace Core\Customer\Models;

use App\Models\Customer;
use Spatie\LaravelData\Data;

class CustomerData extends Data
{
    public function __construct(
        public ?int $id,
        public ?int $user_id,
        public string $name,
        public string $email,
        public string $phone,
        public ?string $address = null,
    ){}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            user_id: $data['user_id'] ?? null,
            name: $data['name'],
            email: $data['email'],
            phone: $data['phone'],
            address: $data['address'] ?? null,
        );
    }

    public function fromModel(Customer $customer): self
    {
        return new self(
            id: $customer->id,
            user_id: $customer->user_id,
            name: $customer->name,
            email: $customer->email,
            phone: $customer->phone,
            address: $customer->address,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
        ];
    }

    public function toModel(): Customer
    {
        if ($this->id) {
            $customer = Customer::find($this->id);
        } else {
            $customer = new Customer();
            $customer->user_id = $this->user_id;
            $customer->name = $this->name;
            $customer->email = $this->email;
            $customer->phone = $this->phone;
            $customer->address = $this->address;
        }
        return $customer;
    }
}
