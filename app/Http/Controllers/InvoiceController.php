<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function show($id)
    {
        $ticket = Ticket::with(['items', 'user'])->findOrFail($id);
        
        return view('admin.invoice', compact('ticket'));
    }
}
