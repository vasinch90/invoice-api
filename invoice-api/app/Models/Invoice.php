<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'user_id', 'invoice_number', 'client_name',
        'client_email', 'items', 'total', 'status',
        'due_date', 'payment_id',
    ];

    protected $casts = [
        'items' => 'array',
        'total' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
