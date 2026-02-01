<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'customer_name',
        'customer_wa',
        'customer_address',
        'device_model',
        'issue_description',
        'status',
        'payment_status',
        'payment_proof',
        'total_cost',
        'coupon_code',
        'discount_amount',
        'subtotal',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function logs()
    {
        return $this->hasMany(TicketLog::class);
    }

    public function items()
    {
        return $this->hasMany(TicketItem::class);
    }
}
