<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Ticket;
use App\Models\TicketItem;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin', ['title' => 'Dashboard Overview'])]
class Dashboard extends Component
{
    public function render()
    {
        $paidTickets = Ticket::with('items')->where('payment_status', 'paid')->get();
        
        $sparepartProfit = 0;
        $serviceProfit = 0;

        foreach ($paidTickets as $ticket) {
            $ticketSparepartRevenue = $ticket->items->where('is_spare_part', true)->sum(fn($i) => $i->price * $i->quantity);
            $ticketSparepartCapital = $ticket->items->where('is_spare_part', true)->sum(fn($i) => $i->capital_price * $i->quantity);
            
            $ticketServiceRevenue = $ticket->items->where('is_spare_part', false)->sum(fn($i) => $i->price * $i->quantity);
            $ticketServiceCapital = $ticket->items->where('is_spare_part', false)->sum(fn($i) => $i->capital_price * $i->quantity);

            $subtotal = $ticketSparepartRevenue + $ticketServiceRevenue;
            $discount = $ticket->discount_amount ?? 0;

            if ($subtotal > 0 && $discount > 0) {
                // Apportion discount based on revenue share
                $serviceDiscount = $discount * ($ticketServiceRevenue / $subtotal);
                $sparepartDiscount = $discount * ($ticketSparepartRevenue / $subtotal);
                
                $serviceProfit += ($ticketServiceRevenue - $serviceDiscount) - $ticketServiceCapital;
                $sparepartProfit += ($ticketSparepartRevenue - $sparepartDiscount) - $ticketSparepartCapital;
            } else {
                $serviceProfit += $ticketServiceRevenue - $ticketServiceCapital;
                $sparepartProfit += $ticketSparepartRevenue - $ticketSparepartCapital;
            }
        }

        return view('livewire.admin.dashboard', [
            'pending' => Ticket::where('status', 'pending')->count(),
            'process' => Ticket::whereIn('status', ['diagnosing', 'repairing', 'waiting_approval'])->count(),
            'completed' => Ticket::where('status', 'done')->count(),
            'revenue' => Ticket::where('payment_status', 'paid')->sum('total_cost'),
            'sparepartProfit' => $sparepartProfit,
            'serviceProfit' => $serviceProfit,
        ]);
    }
}
