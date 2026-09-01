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
    public $newItemCapitalPrice = '';
    public $newItemQty = 1;
    public $newItemIsSparePart = false;

    public $selectedPartId = '';
    public $scanInput = '';

    // Customer Edit
    public $isEditingCustomer = false;
    public $editCustomerName;
    public $editCustomerWa;
    public $editCustomerAddress;
    public $editDeviceModel;
    public $editIssue;

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
                $this->newItemCapitalPrice = $part->capital_price;
                $this->newItemIsSparePart = true;
            }
        }
    }

    public function editCustomerData()
    {
        if (!auth()->user()->hasRole(['super_admin', 'admin'])) return;
        
        $this->editCustomerName = $this->ticket->customer_name;
        $this->editCustomerWa = $this->ticket->customer_wa;
        $this->editCustomerAddress = $this->ticket->customer_address;
        $this->editDeviceModel = $this->ticket->device_model;
        $this->editIssue = $this->ticket->issue_description;
        $this->isEditingCustomer = true;
    }

    public function saveCustomerData()
    {
        if (!auth()->user()->hasRole(['super_admin', 'admin'])) abort(403);
        $this->validate([
            'editCustomerName' => 'required',
            'editCustomerWa' => 'required',
            'editDeviceModel' => 'required',
        ]);
        
        $this->ticket->update([
            'customer_name' => $this->editCustomerName,
            'customer_wa' => $this->editCustomerWa,
            'customer_address' => $this->editCustomerAddress,
            'device_model' => $this->editDeviceModel,
            'issue_description' => $this->editIssue,
        ]);
        
        $this->ticket->logs()->create([
            'user_id' => auth()->id(),
            'new_status' => $this->ticket->status,
            'notes' => 'Customer information updated by admin.',
        ]);
        
        $this->isEditingCustomer = false;
        $this->loadTicket();
        session()->flash('message', 'Customer details updated successfully.');
    }

    public function addItem()
    {
        if (!auth()->user()->hasRole(['super_admin', 'admin'])) abort(403);

        $this->validate([
            'newItemDescription' => 'required|min:2',
            'newItemPrice' => 'required|numeric|min:0',
            'newItemCapitalPrice' => 'nullable|numeric|min:0',
            'newItemQty' => 'required|integer|min:1',
        ]);

        $capitalPrice = ($this->newItemCapitalPrice !== '' && $this->newItemCapitalPrice !== null)
            ? (float) $this->newItemCapitalPrice
            : 0;

        $isSparePart = (bool) $this->newItemIsSparePart;

        if ($this->selectedPartId) {
            $part = SparePart::find($this->selectedPartId);
            if ($part) {
                if ($this->newItemCapitalPrice === '' || $this->newItemCapitalPrice === null) {
                    $capitalPrice = $part->capital_price;
                }
                $isSparePart = true;
            }
        }

        $this->ticket->items()->create([
            'description' => $this->newItemDescription,
            'price' => $this->newItemPrice,
            'quantity' => $this->newItemQty,
            'capital_price' => $capitalPrice,
            'is_spare_part' => $isSparePart,
        ]);

        $this->recalculateTotal();
        $this->reset(['newItemDescription', 'newItemPrice', 'newItemCapitalPrice', 'newItemQty', 'newItemIsSparePart', 'selectedPartId']);
        $this->loadTicket();
    }

    public function handleScanSubmit(bool $instantAdd = true)
    {
        if (empty(trim($this->scanInput))) {
            return;
        }

        $input = trim($this->scanInput);
        $this->scanInput = '';
        $this->scanPart($input, $instantAdd);
    }

    public function scanPart(string $codeOrId, bool $instantAdd = false)
    {
        if (!auth()->user()->hasRole(['super_admin', 'admin'])) abort(403);

        $part = SparePart::findByCodeOrId($codeOrId);

        if (!$part) {
            session()->flash('scan_error', "Suku cadang dengan kode/QR '{$codeOrId}' tidak ditemukan.");
            return;
        }

        $this->selectedPartId = $part->id;
        $this->newItemDescription = $part->name;
        $this->newItemPrice = $part->price;
        $this->newItemCapitalPrice = $part->capital_price;
        $this->newItemIsSparePart = true;
        $this->newItemQty = 1;

        if ($instantAdd) {
            $this->addItem();
            session()->flash('scan_success', "Berhasil menambahkan '{$part->name}' (Rp " . number_format($part->price, 0, ',', '.') . ") ke tagihan tiket.");
        } else {
            session()->flash('scan_success', "Suku cadang '{$part->name}' berhasil dipilih. Silakan sesuaikan jumlah atau klik Tambah Item.");
        }
    }

    public function removeItem($itemId)
    {
        if (!auth()->user()->hasRole(['super_admin', 'admin'])) abort(403);
        
        TicketItem::destroy($itemId);
        $this->recalculateTotal();
        $this->loadTicket();
    }

    public function recalculateTotal()
    {
        $subtotal = $this->ticket->items->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        $discount = 0;
        if ($this->ticket->coupon_code) {
           $coupon = \App\Models\Coupon::where('code', $this->ticket->coupon_code)->first();
           if ($coupon) {
               if ($coupon->type == 'fixed') {
                   $discount = $coupon->value;
               } else {
                   $discount = ($subtotal * $coupon->value) / 100;
               }
           }
        }

        $total = max(0, $subtotal - $discount);

        $this->ticket->update([
            'subtotal' => $subtotal,
            'discount_amount' => $discount,
            'total_cost' => $total
        ]);
        
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
        if (!auth()->user()->hasRole(['super_admin', 'admin'])) abort(403);
        
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

    public function approvePaymentDirect()
    {
        if (!auth()->user()->hasRole(['super_admin', 'admin'])) abort(403);
        
        $this->ticket->update([
            'payment_status' => 'paid',
        ]);

        $this->ticket->logs()->create([
            'user_id' => auth()->id(),
            'new_status' => $this->ticket->status,
            'notes' => 'Payment marked as PAID (Direct Transaction/Cash) without proof by admin.',
        ]);

        $this->loadTicket();
        session()->flash('message', 'Payment marked as paid (Direct Transaction).');
    }

    public function markAsRefunded()
    {
        if (!auth()->user()->hasRole(['super_admin', 'admin'])) abort(403);
        
        $oldStatus = $this->ticket->status;
        $this->ticket->update([
            'payment_status' => 'refunded',
            'status' => 'refunded',
        ]);

        $this->ticket->logs()->create([
            'user_id' => auth()->id(),
            'old_status' => $oldStatus,
            'new_status' => 'refunded',
            'notes' => 'Status pesanan diubah ke REFUND dan dana ditandai telah dikembalikan/retur.',
        ]);

        $this->newStatus = 'refunded';
        $this->loadTicket();
        session()->flash('message', 'Pesanan berhasil ditandai sebagai REFUND.');
    }

    public function markAsCancelled()
    {
        if (!auth()->user()->hasRole(['super_admin', 'admin'])) abort(403);
        
        $oldStatus = $this->ticket->status;
        $this->ticket->update([
            'status' => 'cancelled',
            'payment_status' => $this->ticket->payment_status === 'paid' ? 'refunded' : 'unpaid',
        ]);

        $this->ticket->logs()->create([
            'user_id' => auth()->id(),
            'old_status' => $oldStatus,
            'new_status' => 'cancelled',
            'notes' => 'Pesanan DIBATALKAN (Cancel) oleh admin.',
        ]);

        $this->newStatus = 'cancelled';
        $this->loadTicket();
        session()->flash('message', 'Pesanan berhasil DIBATALKAN (Cancel).');
    }

    public function markAsUnpaid()
    {
        if (!auth()->user()->hasRole(['super_admin', 'admin'])) abort(403);
        
        $this->ticket->update([
            'payment_status' => 'unpaid',
        ]);

        $this->ticket->logs()->create([
            'user_id' => auth()->id(),
            'new_status' => $this->ticket->status,
            'notes' => 'Status pembayaran diubah kembali menjadi UNPAID (Belum Bayar) oleh admin.',
        ]);

        $this->loadTicket();
        session()->flash('message', 'Status pembayaran diubah menjadi Unpaid.');
    }

    public $searchPart = '';

    public function render()
    {
        $sparePartsQuery = SparePart::orderBy('name', 'asc');
        
        if (!empty($this->searchPart)) {
            $sparePartsQuery->where('name', 'ilike', '%' . $this->searchPart . '%');
        }

        return view('livewire.admin.ticket-detail', [
            'spareParts' => $sparePartsQuery->get(),
        ]);
    }
}
