<?php

namespace Core\Sales\Models;

use App\Models\Sale;
use Core\Sales\Enums\PaymentMethod;
use Illuminate\Database\Eloquent\Model;
use Spatie\LaravelData\Data;

class SaleData extends Data
{

    public function __construct(
        public ?int $id,
        public int $user_id,
        public int $customer_id,
        public float $total_amount = 0.0,
        public string $payment_method = PaymentMethod::CASH->value,
    ){}

    public static function fromArray(array $inputs): SaleData
    {
        return new self(
            id: $inputs['id'] ?? null,
            user_id: $inputs['user_id'],
            customer_id: $inputs['customer_id'],
            total_amount: $inputs['total_amount'] ?? 0,
            payment_method: $inputs['payment_method'] ?? 0,
        );
    }

    public static function fromModel($model): SaleData
    {
        return new self(
            id: $model->id,
            user_id: $model->user_id,
            customer_id: $model->customer_id,
            total_amount: $model?->total_amount ?? 0,
            payment_method: $model?->payment_method ?? PaymentMethod::CASH->value,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'customer_id' => $this->customer_id,
            'total_amount' => $this->total_amount,
            'payment_method' => $this->payment_method,
        ];
    }

    public function toModel(): Sale|Model
    {
        if ($this->id) {
            $model = Sale::findOrFail($this->id);
        }else {
            $model = new Sale();
        }

        $model->fill([
            'user_id' => $this->user_id,
            'customer_id' => $this->customer_id,
            'total_amount' => $this->total_amount,
            'payment_method' => $this->payment_method,
        ]);

        return $model;
    }
}
