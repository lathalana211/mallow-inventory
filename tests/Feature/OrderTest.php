<?php

namespace Tests\Feature;

use App\Jobs\SendOrderConfirmationJob;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_is_created_and_stock_is_deducted(): void
    {
        Queue::fake();

        $customer = Customer::factory()->create();

        $product = Product::factory()->create([
            'price' => 100,
            'tax_percentage' => 10,
            'stock_on_hand' => 10,
        ]);

        $response = $this->postJson('/api/orders', [
            'customer' => [
                'name' => $customer->name,
                'email' => $customer->email,
            ],
            'items' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 2,
                ],
            ],
        ]);

        $response->assertCreated()
            ->assertJsonPath('order.subtotal', '200.00')
            ->assertJsonPath('order.tax', '20.00')
            ->assertJsonPath('order.grand_total', '220.00');

        $this->assertDatabaseHas('orders', [
            'customer_id' => $customer->id,
            'grand_total' => 220,
        ]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'stock_on_hand' => 8,
        ]);

        Queue::assertPushed(
            SendOrderConfirmationJob::class,
            fn ($job) => $job->orderId === 1
                || $job->orderId === Order::first()->id
        );
    }

    public function test_order_is_rejected_when_stock_is_insufficient(): void
    {
        Queue::fake();

        $customer = Customer::factory()->create();

        $product = Product::factory()->create([
            'price' => 100,
            'tax_percentage' => 10,
            'stock_on_hand' => 1,
        ]);

        $response = $this->postJson('/api/orders', [
            'customer' => [
                'name' => $customer->name,
                'email' => $customer->email,
            ],
            'items' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 2,
                ],
            ],
        ]);

        $response->assertUnprocessable();

        $this->assertDatabaseCount('orders', 0);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'stock_on_hand' => 1,
        ]);

        Queue::assertNothingPushed();
    }
}
