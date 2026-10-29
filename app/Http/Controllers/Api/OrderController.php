<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Jobs\SendOrderConfirmationJob;
class OrderController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'customer.name' => ['required', 'string', 'max:255'],
            'customer.email' => ['required', 'email', 'max:255'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'integer', 'distinct', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
        ]);

        $order = DB::transaction(function () use ($validated) {
            $customer = Customer::firstOrCreate(
                ['email' => $validated['customer']['email']],
                ['name' => $validated['customer']['name']]
            );

            $subtotal = 0;
            $taxTotal = 0;
            $orderItems = [];

            foreach ($validated['items'] as $item) {
                $product = Product::whereKey($item['product_id'])
                    ->lockForUpdate()
                    ->firstOrFail();

                $quantity = $item['quantity'];

                if ($product->stock_on_hand < $quantity) {
                    throw ValidationException::withMessages([
                        'items' => [
                            "Insufficient stock for product: {$product->name}.",
                        ],
                    ]);
                }

                $unitPrice = (float) $product->price;
                $taxPercentage = (float) $product->tax_percentage;

                $lineSubtotal = round($unitPrice * $quantity, 2);
                $lineTax = round($lineSubtotal * $taxPercentage / 100, 2);

                $subtotal += $lineSubtotal;
                $taxTotal += $lineTax;

                $orderItems[] = [
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'tax_percentage' => $taxPercentage,
                ];

                $product->decrement('stock_on_hand', $quantity);
            }

            $order = Order::create([
                'customer_id' => $customer->id,
                'subtotal' => round($subtotal, 2),
                'tax' => round($taxTotal, 2),
                'grand_total' => round($subtotal + $taxTotal, 2),
            ]);

            $order->items()->createMany($orderItems);

            return $order->load(['customer', 'items.product']);
        });
        SendOrderConfirmationJob::dispatch($order->id);
        return response()->json([
            'message' => 'Order created successfully.',
            'order' => $order,
        ], 201);
        
    }

    
public function history(\Illuminate\Http\Request $request): \Illuminate\Http\JsonResponse
{
    $validated = $request->validate([
        'email' => ['required', 'email'],
    ]);

    $customer = \App\Models\Customer::where(
        'email',
        $validated['email']
    )->first();

    if (!$customer) {
        return response()->json([
            'message' => 'No customer found with this email.',
            'orders' => [],
        ]);
    }

    $orders = $customer->orders()
        ->with(['items.product'])
        ->latest()
        ->get();

    return response()->json([
        'customer' => $customer,
        'orders' => $orders,
    ]);
}

}
