<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function summary()
    {
        $invoices = Invoice::where('user_id', auth()->id())->get();

        return response()->json([
            'total_invoices' => $invoices->count(),
            'total_revenue'  => $invoices->where('status', 'paid')->sum('total'),
            'unpaid_amount'  => $invoices->where('status', 'sent')->sum('total'),
            'by_status' => [
                'draft'   => $invoices->where('status', 'draft')->count(),
                'sent'    => $invoices->where('status', 'sent')->count(),
                'paid'    => $invoices->where('status', 'paid')->count(),
                'overdue' => $invoices->where('status', 'overdue')->count(),
            ],
            'recent' => $invoices->sortByDesc('created_at')->take(3)->values(),
        ]);
    }
}
