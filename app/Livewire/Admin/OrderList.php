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

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function render()
    {
        $tickets = Ticket::latest()
            ->when($this->status, function ($query) {
                return $query->where('status', $this->status);
            })
            ->paginate(10);

        return view('livewire.admin.order-list', [
            'tickets' => $tickets,
        ]);
    }
}
