<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\FcmNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        if ($user->role !== 'buyer') {
            return response()->json(['message' => 'Only buyers can place orders'], 403);
        }

        $data = $request->validate([
            'address' => ['nullable', 'string', 'max:255'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'integer', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
        ]);

        $itemsData = $data['items'];

        return DB::transaction(function () use ($user, $data, $itemsData) {
            $total = 0;
            $orderItems = [];

            foreach ($itemsData as $item) {
                $product = Product::findOrFail($item['product_id']);
                $qty = $item['quantity'];

                $total += $product->price * $qty;

                $orderItems[] = [
                    'product_id' => $product->id,
                    'quantity' => $qty,
                    'unit_price' => $product->price,
                ];
            }

            // Commission from settings (default 10%)
            $commissionRate = (float) (\App\Models\Setting::get('commission_rate', '0.10'));
            $commissionAmount = $total * $commissionRate;

            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => $total,
                'commission_rate' => $commissionRate,
                'commission_amount' => $commissionAmount,
                'address' => $data['address'] ?? null,
                'payment_method' => 'cod',
                'status' => 'pending',
            ]);

            foreach ($orderItems as $item) {
                $order->items()->create($item);
            }

            $order->load('items.product');

            // Trigger basic FCM notifications (if configured)
            app(FcmNotificationService::class)->sendToUserIds(
                [$user->id],
                'Order placed',
                'Your order #'.$order->id.' has been placed.',
                ['order_id' => $order->id]
            );

            return response()->json($order, 201);
        });
    }
}

