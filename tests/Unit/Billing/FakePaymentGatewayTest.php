<?php
/**
 * Created by PhpStorm.
 * User: stainlessphil
 * Date: 08/10/17
 * Time: 4:12 PM
 */

namespace Tests\Unit\Billing;


use App\Billing\FakePaymentGateway;
use Tests\CustomTestCase;

class FakePaymentGatewayTest extends CustomTestCase
{

    /** @test */
    public function charges_with_a_valid_payment_token_are_successful()
    {
        $paymentGateway = new FakePaymentGateway();

        $paymentGateway->charge(2500, $paymentGateway->getValidToken());

        self::assertEquals(2500, $paymentGateway->totalCharges());
    }
}