<?php

namespace Tests\Feature\Admin;

use App\Models\FinancialTransaction;
use App\Models\SparePart;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CancelledRefundOrderProfitTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'role' => 'admin',
        ]);
    }

    public function test_admin_can_cancel_ticket_and_add_used_items_with_capital_price(): void
    {
        $ticket = Ticket::create([
            'customer_name' => 'John Doe',
            'customer_wa' => '081234567890',
            'customer_address' => 'Jakarta',
            'device_model' => 'iPhone 11',
            'issue_description' => 'Mati Total',
            'status' => 'diagnosing',
            'payment_status' => 'unpaid',
        ]);

        $part = SparePart::create([
            'name' => 'IC Power iPhone 11',
            'type' => 'spare_part',
            'stock' => 10,
            'capital_price' => 75000,
            'price' => 200000,
        ]);

        Livewire::actingAs($this->admin)
            ->test(\App\Livewire\Admin\TicketDetail::class, ['id' => $ticket->id])
            ->call('markAsCancelled')
            ->assertSet('newStatus', 'cancelled')
            ->set('selectedPartId', $part->id)
            ->set('newItemPrice', 0) // Did not charge customer
            ->call('addItem');

        $this->assertDatabaseHas('tickets', [
            'id' => $ticket->id,
            'status' => 'cancelled',
        ]);

        $this->assertDatabaseHas('ticket_items', [
            'ticket_id' => $ticket->id,
            'description' => 'IC Power iPhone 11',
            'capital_price' => 75000,
            'price' => 0,
            'quantity' => 1,
            'is_spare_part' => true,
        ]);
    }

    public function test_cancelled_and_refunded_items_cost_turns_into_negative_profit_on_dashboard(): void
    {
        // 1. Create a cancelled ticket with used sparepart (Capital: 80,000, Price charged: 0)
        $cancelledTicket = Ticket::create([
            'customer_name' => 'Alice',
            'customer_wa' => '081234567891',
            'customer_address' => 'Bandung',
            'device_model' => 'Samsung S20',
            'issue_description' => 'Layar Blank',
            'status' => 'cancelled',
            'payment_status' => 'unpaid',
            'total_cost' => 0,
        ]);

        $cancelledTicket->items()->create([
            'description' => 'Flex Cable Rusak saat diagnosa',
            'capital_price' => 80000,
            'price' => 0,
            'quantity' => 1,
            'is_spare_part' => true,
        ]);

        // 2. Create a refunded ticket with used sparepart & service (Capital: 30,000, Price charged: 0)
        $refundedTicket = Ticket::create([
            'customer_name' => 'Bob',
            'customer_wa' => '081234567892',
            'customer_address' => 'Surabaya',
            'device_model' => 'MacBook Pro',
            'issue_description' => 'Tidak mau charge',
            'status' => 'refunded',
            'payment_status' => 'refunded',
            'total_cost' => 0,
        ]);

        $refundedTicket->items()->create([
            'description' => 'Thermal Paste & Cleaning',
            'capital_price' => 30000,
            'price' => 0,
            'quantity' => 1,
            'is_spare_part' => false,
        ]);

        // 3. Create a normal paid ticket (Sparepart Rev: 200,000, Cap: 100,000 -> Profit: 100,000)
        $paidTicket = Ticket::create([
            'customer_name' => 'Charlie',
            'customer_wa' => '081234567893',
            'customer_address' => 'Yogyakarta',
            'device_model' => 'Asus ROG',
            'issue_description' => 'Ganti Kipas',
            'status' => 'done',
            'payment_status' => 'paid',
            'total_cost' => 200000,
        ]);

        $paidTicket->items()->create([
            'description' => 'Kipas Asus ROG',
            'capital_price' => 100000,
            'price' => 200000,
            'quantity' => 1,
            'is_spare_part' => true,
        ]);

        // 4. Non-order transactions: income 50,000, expense 20,000
        FinancialTransaction::create([
            'user_id' => $this->admin->id,
            'type' => 'income',
            'title' => 'Aksesoris Cash',
            'category' => 'Penjualan Aksesoris',
            'amount' => 50000,
            'transaction_date' => now()->toDateString(),
        ]);

        FinancialTransaction::create([
            'user_id' => $this->admin->id,
            'type' => 'expense',
            'title' => 'Tagihan Listrik',
            'category' => 'Listrik',
            'amount' => 20000,
            'transaction_date' => now()->toDateString(),
        ]);

        // Sparepart profit: (200k - 100k) - 80k = 20,000
        // Service profit: 0 - 30k = -30,000
        // Order Gross profit: 20,000 + (-30,000) = -10,000
        // Net Business Profit: -10,000 + 50,000 (income) - 20,000 (expense) = 20,000
        // Cancelled loss: 80,000 + 30,000 = 110,000

        Livewire::actingAs($this->admin)
            ->test(\App\Livewire\Admin\Dashboard::class)
            ->assertViewHas('sparepartProfit', 20000.0)
            ->assertViewHas('serviceProfit', -30000.0)
            ->assertViewHas('orderGrossProfit', -10000.0)
            ->assertViewHas('cancelledLoss', 110000.0)
            ->assertViewHas('netBusinessProfit', 20000.0);
    }
}
