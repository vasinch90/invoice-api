<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoice::where('user_id', auth()->id())->latest()->get();
        return response()->json(['count' => $invoices->count(), 'invoices' => $invoices]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'client_name'    => 'required|string',
            'client_email'   => 'required|email',
            'items'          => 'required|array|min:1',
            'items.*.name'   => 'required|string',
            'items.*.qty'    => 'required|integer|min:1',
            'items.*.price'  => 'required|numeric|min:0',
            'due_date'       => 'required|date',
        ]);

        $total = collect($request->items)
            ->sum(fn($item) => $item['qty'] * $item['price']);

        $invoice = Invoice::create([
            'user_id'        => auth()->id(),
            'invoice_number' => 'INV-' . strtoupper(uniqid()),
            'client_name'    => $request->client_name,
            'client_email'   => $request->client_email,
            'items'          => $request->items,
            'total'          => $total,
            'due_date'       => $request->due_date,
        ]);

        return response()->json(['message' => 'Invoice created', 'invoice' => $invoice], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $invoice = Invoice::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        return response()->json($invoice);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:draft,sent,paid,overdue',
        ]);

        $invoice = Invoice::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $invoice->update(['status' => $request->status]);

        return response()->json(['message' => 'Status updated', 'invoice' => $invoice]);
    }
}
