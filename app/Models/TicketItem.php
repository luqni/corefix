<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketItem extends Model
{
    protected $fillable = ['ticket_id', 'description', 'quantity', 'price'];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
