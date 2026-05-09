<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function charge(Request $request)
    {
        $invoice = Invoice::findOrFail($request->invoice_id);

        // Omise charge (sandbox)
        \Omise::setSecretKey(config('services.omise.secret'));
        $charge = \OmiseCharge::create([
            'amount'      => $invoice->total * 100, // satang
            'currency'    => 'thb',
            'card'        => $request->token,
            'description' => "Invoice {$invoice->invoice_number}",
        ]);

        if ($charge['status'] === 'successful') {
            $invoice->update([
                'status'     => 'paid',
                'payment_id' => $charge['id'],
            ]);
        }

        return response()->json(['status' => $charge['status']]);
    }

    public function webhook(Request $request)
    {
        $event = $request->all();
        if ($event['key'] === 'charge.complete') {
            $invoice = Invoice::where('payment_id', $event['data']['id'])->first();
            $invoice?->update(['status' => 'paid']);
        }
        return response()->json(['received' => true]);
    }
}
