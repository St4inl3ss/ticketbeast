<?php

namespace App\Http\Controllers;

use App\Billing\PaymentGateway;
use App\Concert;
use Illuminate\Http\Request;

/**
 * Class ConcertOrdersController
 *
 * @package App\Http\Controllers
 */
class ConcertOrdersController extends Controller
{

    /**
     * @var PaymentGateway
     */
    private $paymentGateway;

    /**
     * ConcertOrdersController constructor.
     *
     * @param PaymentGateway $paymentGateway
     */
    public function __construct(PaymentGateway $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }

    /**
     * @param Request $request
     * @param $concertId
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, $concertId)
    {
        $concert = Concert::find($concertId);
        $ticketQuantity = $request->get('ticket_quantity');
        $token = $request->get('payment_token');

        $amount = $ticketQuantity * $concert->ticket_price;

        $this->paymentGateway->charge($amount, $token);

        return response()->json([], 201);
    }
}
