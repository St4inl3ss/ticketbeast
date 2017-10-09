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
     * @var PaymentGateway
     */
    protected $paymentGateway;

    protected function setUp()
    {
        parent::setUp();

        $this->paymentGateway = new FakePaymentGateway();
        $this->app->instance(PaymentGateway::class, $this->paymentGateway);
    }

    /**
     * @test
     */
    public function customer_can_purchase_concert_tickets()
    {
        $this->setUp();

        $concert = factory(Concert::class)->create(
            [
                'ticket_price' => 3250
            ]
        );

        $response = $this->json(
            'POST', "/concerts/$concert->id/orders", [
                'email' => 'john@example.com',
                'ticket_quantity' => 3,
                'payment_token' => $this->paymentGateway->getValidToken()
            ]
        );

        $response->assertStatus(201);

        self::assertEquals(9750, $this->paymentGateway->totalCharges());

        $order = $concert->orders()->where('email', 'john@example.com')->first();
        self::assertNotNull($order);
        self::assertEquals(3, $order->tickets->count());
    }

    /**
     * @test
     */
    public function email_is_requested_to_purchase_tickets()
    {
        $this->setUp();
        $concert = factory(Concert::class)->create();

        $response = $this->json(
            'POST', "/concerts/$concert->id/orders", [
                'ticket_quantity' => 3,
                'payment_token' => $this->paymentGateway->getValidToken()
            ]
        );

        $response->assertStatus(422);

        self::assertArrayHasKey('email', $response->json()['errors']);
        self::assertContains('required', implode(' ', $response->json()['errors']['email']));
    }

}