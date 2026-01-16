<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Ticket;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin', ['title' => 'Dashboard Overview'])]
class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.admin.dashboard', [
            'pending' => Ticket::where('status', 'pending')->count(),
            'process' => Ticket::whereIn('status', ['diagnosing', 'repairing', 'waiting_approval'])->count(),
            'completed' => Ticket::where('status', 'done')->count(),
            'revenue' => Ticket::where('payment_status', 'paid')->sum('total_cost'),
        ]);
    }
}
