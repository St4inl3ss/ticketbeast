<?php
/**
 * Created by PhpStorm.
 * User: stainlessphil
 * Date: 08/10/17
 * Time: 4:00 PM
 */

namespace App\Billing;

use Illuminate\Support\Collection;

/**
 * Class FakePaymentGateway
 *
 * @package App\Billing
 */
class FakePaymentGateway implements PaymentGateway
{

    /**
     * @var  Collection
     */
    private $charges;

    /**
     * FakePaymentGateway constructor.
     */
    public function __construct()
    {
        $this->charges = new Collection();
    }

    /**
     * @return string
     */
    public function getValidToken(): string
    {
        return 'valid-token';
    }

    /**
     * @return int
     */
    public function totalCharges(): int
    {
        return $this->charges->sum();
    }

    /**
     * @param int $amount
     * @param string $token
     *
     * @return void
     */
    public function charge(int $amount, string $token): void
    {
        $this->charges->push($amount);
    }
}