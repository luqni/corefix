<?php

namespace App\Livewire\Admin;

use App\Models\Ticket;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin', ['title' => 'Create New Order'])]
class CreateOrder extends Component
{
    public $name;
    public $whatsapp;
    public $address;
    public $device;
    public $issue;

    public function mount()
    {
        if (!auth()->user()->hasRole(['super_admin', 'admin'])) {
            abort(403, 'Unauthorized access.');
        }
    }

    protected $rules = [
        'name' => 'required|min:3',
        'whatsapp' => 'required|numeric|min_digits:10',
        'address' => 'required|min:5',
        'device' => 'required|min:2',
        'issue' => 'required|min:5',
    ];

    public function save()
    {
        $this->validate();

        $ticket = Ticket::create([
            'customer_name' => $this->name,
            'customer_wa' => $this->whatsapp,
            'customer_address' => $this->address,
            'device_model' => $this->device,
            'issue_description' => $this->issue,
            'status' => 'pending',
            'payment_status' => 'unpaid',
        ]);

        // Log the creation
        $ticket->logs()->create([
            'user_id' => auth()->id(),
            'new_status' => 'pending',
            'notes' => 'Ticket created manually by admin.',
        ]);

        session()->flash('message', 'Order created successfully.');

        return redirect()->route('admin.tickets.show', $ticket->id);
    }

    public function render()
    {
        return view('livewire.admin.create-order');
    }
}
