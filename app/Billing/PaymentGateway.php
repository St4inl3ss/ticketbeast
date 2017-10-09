<?php
/**
 * Created by PhpStorm.
 * User: stainlessphil
 * Date: 08/10/17
 * Time: 4:37 PM
 */

namespace App\Billing;

/**
 * Interface PaymentGateway
 * @package App\Billing
 */
interface PaymentGateway
{
    /**
     * @param int $amount
     * @param string $token
     * @return mixed
     */
    public function charge(int $amount, string $token);

    /**
     * @return string
     */
    public function getValidToken(): string;

    /**
     * @return int
     */
    public function totalCharges(): int;


}