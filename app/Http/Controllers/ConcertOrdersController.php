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
        $this->validate($request, [
            'email' => 'required'
        ]);

        $concert = Concert::find($concertId);

        $ticketQuantity = $request->get('ticket_quantity');

        $this->paymentGateway->charge(
            $ticketQuantity * $concert->ticket_price,
            $request->get('payment_token')
        );

        $concert->orderTickets($request->get('email'), $ticketQuantity);

        return response()->json([], 201);
    }
}
