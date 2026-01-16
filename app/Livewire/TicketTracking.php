<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Ticket;
use Livewire\WithFileUploads;

class TicketTracking extends Component
{
    use WithFileUploads;

    public $ticketId = '';
    public $ticket;
    public $paymentProof;
    public $isUploaded = false;

    public function mount($id = null)
    {
        if ($id) {
            $this->ticketId = $id;
            $this->trackTicket();
        }
    }

    public function trackTicket()
    {
        $this->validate(['ticketId' => 'required|uuid']);
        $this->ticket = Ticket::with('logs')->find($this->ticketId);
    }

    public function uploadProof()
    {
        $this->validate([
            'paymentProof' => 'required|image|max:2048', // 2MB Max
        ]);

        if ($this->ticket) {
            $path = $this->paymentProof->store('payment_proofs', 'public');
            
            $this->ticket->update([
                'payment_proof' => $path,
                'payment_status' => 'waiting_verification',
            ]);

            // Log update
            $this->ticket->logs()->create([
                'new_status' => $this->ticket->status,
                'notes' => 'Payment proof uploaded by customer.',
            ]);

            $this->isUploaded = true;
            $this->paymentProof = null;
        }
    }

    public function render()
    {
        return view('livewire.ticket-tracking');
    }
}
