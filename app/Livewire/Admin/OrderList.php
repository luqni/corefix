<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Ticket;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin', ['title' => 'Order Management'])]
class OrderList extends Component
{
    use WithPagination;

    public $status = '';
    public $dateFilter = 'all';

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function updatingDateFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $tickets = Ticket::latest()
            ->when($this->status, function ($query) {
                return $query->where('status', $this->status);
            })
            ->when($this->dateFilter !== 'all', function ($query) {
                return match ($this->dateFilter) {
                    'today' => $query->whereDate('created_at', today()),
                    'week' => $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]),
                    'month' => $query->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year),
                    'year' => $query->whereYear('created_at', now()->year),
                    default => $query,
                };
            })
            ->paginate(10);

        return view('livewire.admin.order-list', [
            'tickets' => $tickets,
        ]);
    }
}
