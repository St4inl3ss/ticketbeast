<?php
/**
 * Created by PhpStorm.
 * User: stainlessphil
 * Date: 08/10/17
 * Time: 3:41 PM
 */

namespace Tests\Feature;


use App\Billing\FakePaymentGateway;
use App\Billing\PaymentGateway;
use App\Concert;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\CustomTestCase;

/**
 * Class PurchaseTicketsTest
 *
 * @package Tests\Feature
 */
class PurchaseTicketsTest extends CustomTestCase
{

    use RefreshDatabase;

    /**
     * @test
     */
    public function customer_can_purchase_concert_tickets()
    {
        $paymentGateway = new FakePaymentGateway();
        $this->app->instance(PaymentGateway::class, $paymentGateway);

        $concert = factory(Concert::class)->create(
            [
                'ticket_price' => 3250
            ]
        );

        $response = $this->json(
            'POST', "/concerts/$concert->id/orders", [
                'email' => 'john@example.com',
                'ticket_quantity' => 3,
                'payment_token' => $paymentGateway->getValidToken()
            ]
        );

        $response->assertStatus(201);

        self::assertEquals(9750, $paymentGateway->totalCharges());

        $order = $concert->orders()->where('email', 'john@example.com')->first();
        self::assertNotNull($order);
        self::assertEquals(3, $order->tickets->count());
    }

}