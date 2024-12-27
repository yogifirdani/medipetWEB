<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test checkout with correct ATM and account number.
     *
     * @return void
     */
    public function test_checkout_with_valid_payment_data()
    {
        // Create a test user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a sample product
        $product = Product::factory()->create([
            'nama' => 'Sample Product',
            'harga' => 50000,
            'stok' => 20,
        ]);

        // Simulate adding the product to the cart
        $cart = [
            $product->id => [
                'id' => $product->id,
                'nama' => $product->nama,
                'harga' => $product->harga,
                'quantity' => 1,
            ]
        ];
        Session::put('cart', $cart);

        // Perform the checkout request with required data
        $response = $this->post('/checkout', [
            'selected_items' => json_encode([
                [
                    'id' => $product->id,
                    'quantity' => 1
                ]
            ]),
            'atm' => 'BCA',
            'no_rekening' => '1234567890',
        ]);

        // Assertions
        $response->assertStatus(200); // Check if request was successful
        $response->assertViewIs('pages.app.Shopping.co'); // Check if the view is correct
        $response->assertViewHas('selectedCart'); // Check if the cart data is passed to the view
        $response->assertViewHas('totalPrice'); // Check if the total price is passed to the view

        // Check if the order was created in the database
        $this->assertDatabaseHas('manage_orders', [
            'id_cust' => $user->id,
            'id_product' => $product->id,
            'jumlah_pembelian' => 1,
            'total_harga' => $product->harga,
            'status_pesanan' => 'proses',
        ]);

        // Check if the product stock was reduced
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'stok' => $product->stok - 1,
        ]);
    }
}
