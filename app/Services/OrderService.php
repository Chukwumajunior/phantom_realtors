<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\Product;
use App\Models\Property;
use App\Models\Service;
use App\Models\User;

class OrderService
{
    public function createOrder(User $customer, int $merchantId, array $items, ?string $notes = null): Order
    {
        $totalAmount = 0;
        $orderItems = [];

        foreach ($items as $item) {
            $model = $this->resolveItemable($item['itemable_type'], $item['itemable_id']);
            $unitPrice = $this->getItemPrice($model);
            $quantity = $item['quantity'] ?? 1;
            $subtotal = $unitPrice * $quantity;
            $totalAmount += $subtotal;

            $orderItems[] = [
                'itemable_type' => get_class($model),
                'itemable_id' => $model->id,
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'subtotal' => $subtotal,
            ];
        }

        $order = Order::create([
            'customer_id' => $customer->id,
            'merchant_id' => $merchantId,
            'status' => OrderStatus::Pending,
            'total_amount' => $totalAmount,
            'notes' => $notes,
        ]);

        foreach ($orderItems as $orderItem) {
            $order->items()->create($orderItem);
        }

        return $order->load('items');
    }

    private function resolveItemable(string $type, int $id)
    {
        return match ($type) {
            'property' => Property::findOrFail($id),
            'product' => Product::findOrFail($id),
            'service' => Service::findOrFail($id),
            default => throw new \InvalidArgumentException("Invalid item type: {$type}"),
        };
    }

    private function getItemPrice($model): float
    {
        if ($model instanceof Property || $model instanceof Product) {
            return (float) $model->price;
        }

        if ($model instanceof Service) {
            return (float) ($model->price_from ?? 0);
        }

        return 0;
    }
}
