<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'client_name'  => 'required|string',
            'client_email' => 'required|email',
            'items'        => 'required|array',
            'items.*.name' => 'required|string',
            'items.*.qty'  => 'required|integer|min:1',
            'items.*.price'=> 'required|numeric|min:0',
            'due_date'     => 'required|date',
        ]);

        $total = collect($data['items'])
            ->sum(fn($item) => $item['qty'] * $item['price']);

        $invoice = Invoice::create([
            ...$data,
            'user_id'        => auth()->id(),
            'invoice_number' => 'INV-' . strtoupper(uniqid()),
            'total'          => $total,
        ]);

        return response()->json($invoice, 201);
    }

    public function exportPdf($id)
    {
        $invoice = Invoice::findOrFail($id);
        $pdf = Pdf::loadView('invoices.pdf', compact('invoice'));
        return $pdf->download("invoice-{$invoice->invoice_number}.pdf");
    }
}
