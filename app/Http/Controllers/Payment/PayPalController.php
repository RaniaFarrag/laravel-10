<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\ExpressCheckout;


class PayPalController extends Controller
{
    /** View Payment Page */
    public function index()
    {
        return view('payment.paypal');
    }

    /** Payment */
    public function payment()
    {
        $data = [];
        $data['items'] = [
            [
                'name' => 'subscribe',
                'price' => 1000,
                'desc' => 'test desc',
                'qty' => 2,
            ],
            [
                'name' => 'make like',
                'price' => 200,
                'desc' => 'test desc',
                'qty' => 1,
            ],
        ];

        $data['invoice_id'] = 1;
        $data['invoice_description'] = 'order Invoice #'.$data['invoice_id'];
        $data['return_url'] = 'http://localhost:8000/paypal/payment/success';
        $data['cancel_url'] = 'http://localhost:8000/paypal/payment/cancel';
        $data['total'] = 2200;

        $provider = new ExpressCheckout;

        $response = $provider->setExpressCheckout($data, true);
        return redirect($response['paypal_link']);

    }

    /** If Payment Process Successfully */
    public function paymentSuccess(Request $request)
    {
        $provider = new ExpressCheckout;
        $response = $provider->getExpressCheckoutDetails($request->token);

        if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])){
            return redirect()
                ->route('paypal')
                ->with('success', 'Transaction complete.');
        }
        else {
            return redirect()
                ->route('paypal')
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }

    /** If Payment Process Canceled */
    public function paymentCancel()
    {
        return redirect()
            ->route('paypal')
            ->with('error', $response['message'] ?? 'You have canceled the transaction.');

    }
}
