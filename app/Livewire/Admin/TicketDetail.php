<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Ticket;
use App\Models\TicketItem;
use App\Models\SparePart;
use App\Models\TicketLog;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin', ['title' => 'Ticket Details'])]
class TicketDetail extends Component
{
    public $ticketId;
    public $ticket;

    // Actions
    public $newStatus;
    public $note = '';
    public $cost = 0; // Keeping this mainly for reference, but items will drive the total

    // Item Management
    public $newItemDescription = '';
    public $newItemPrice = '';
    public $newItemQty = 1;

    public $selectedPartId = '';

    public function mount($id)
    {
        $this->ticketId = $id;
        $this->loadTicket();
        $this->newStatus = $this->ticket->status;
        $this->cost = $this->ticket->total_cost;
    }

    public function loadTicket()
    {
        $this->ticket = Ticket::with(['logs.user', 'items'])->findOrFail($this->ticketId);
    }

    public function updatedSelectedPartId($value)
    {
        if ($value) {
            $part = SparePart::find($value);
            if ($part) {
                $this->newItemDescription = $part->name;
                $this->newItemPrice = $part->price;
            }
        }
    }

    public function addItem()
    {
        $this->validate([
            'newItemDescription' => 'required|min:3',
            'newItemPrice' => 'required|numeric|min:0',
            'newItemQty' => 'required|integer|min:1',
        ]);

        $this->ticket->items()->create([
            'description' => $this->newItemDescription,
            'price' => $this->newItemPrice,
            'quantity' => $this->newItemQty,
        ]);

        $this->recalculateTotal();
        $this->reset(['newItemDescription', 'newItemPrice', 'newItemQty', 'selectedPartId']);
        $this->loadTicket();
    }

    public function removeItem($itemId)
    {
        TicketItem::destroy($itemId);
        $this->recalculateTotal();
        $this->loadTicket();
    }

    public function recalculateTotal()
    {
        $total = $this->ticket->items->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        $this->ticket->update(['total_cost' => $total]);
        $this->cost = $total;
    }

    public function updateStatus()
    {
        $this->validate([
            'newStatus' => 'required',
            'note' => 'nullable|string',
        ]);

        $oldStatus = $this->ticket->status;
        
        $this->ticket->update([
            'status' => $this->newStatus,
        ]);

        // Log it
        $this->ticket->logs()->create([
            'user_id' => auth()->id(),
            'old_status' => $oldStatus,
            'new_status' => $this->newStatus,
            'notes' => $this->note ?: 'Status updated by admin',
        ]);

        $this->note = '';
        $this->loadTicket();
        
        session()->flash('message', 'Status updated successfully.');
    }

    public function updateCost() // Manually override cost if needed, though items are preferred
    {
        $this->validate(['cost' => 'numeric|min:0']);

        $this->ticket->update([
            'total_cost' => $this->cost,
        ]);
        
        session()->flash('message', 'Total cost updated.');
    }

    public function approvePayment()
    {
        $this->ticket->update([
            'payment_status' => 'paid',
        ]);

        $this->ticket->logs()->create([
            'user_id' => auth()->id(),
            'new_status' => $this->ticket->status,
            'notes' => 'Payment verified and approved by admin.',
        ]);

        $this->loadTicket();
        session()->flash('message', 'Payment approved.');
    }

    public function render()
    {
        return view('livewire.admin.ticket-detail', [
            'spareParts' => SparePart::all(),
        ]);
    }
}
