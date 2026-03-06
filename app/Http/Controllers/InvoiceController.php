<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function show($id)
    {
        $ticket = Ticket::with(['items', 'user'])->findOrFail($id);
        $isPdf = false;
        
        return view('admin.invoice', compact('ticket', 'isPdf'));
    }

    public function downloadPdf($id)
    {
        $ticket = Ticket::with(['items', 'user'])->findOrFail($id);
        $isPdf = true;
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.invoice', compact('ticket', 'isPdf'));
        
        // Setting paper to A4 just in case
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('Invoice_' . substr($ticket->id, 0, 8) . '.pdf');
    }
}
