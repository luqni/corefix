<?php

namespace Tests\Feature\Admin;

use App\Models\FinancialTransaction;
use App\Models\User;
use App\Livewire\Admin\FinancialTransactionList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class FinancialTransactionTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthenticated_user_cannot_access_transactions()
    {
        $response = $this->get(route('admin.transactions'));
        $response->assertRedirect(route('login'));
    }

    public function test_non_staff_user_cannot_access_transactions()
    {
        $user = User::factory()->create(['role' => 'customer']);

        $response = $this->actingAs($user)->get(route('admin.transactions'));
        $response->assertStatus(403);
    }

    public function test_admin_can_access_transactions_page()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get(route('admin.transactions'));
        $response->assertStatus(200);
    }

    public function test_admin_can_create_income_and_expense_transactions()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        Livewire::actingAs($admin)
            ->test(FinancialTransactionList::class)
            ->set('type', 'income')
            ->set('category', 'Penjualan Aksesoris & Merchandise')
            ->set('title', 'Penjualan Tempered Glass')
            ->set('amount', 75000)
            ->set('transaction_date', now()->format('Y-m-d'))
            ->set('payment_method', 'cash')
            ->set('description', 'Penjualan offline di toko')
            ->call('store')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('financial_transactions', [
            'type' => 'income',
            'title' => 'Penjualan Tempered Glass',
            'amount' => 75000,
        ]);

        Livewire::actingAs($admin)
            ->test(FinancialTransactionList::class)
            ->set('type', 'expense')
            ->set('category', 'Listrik, Air & Kebersihan')
            ->set('title', 'Token Listrik Workshop')
            ->set('amount', 200000)
            ->set('transaction_date', now()->format('Y-m-d'))
            ->set('payment_method', 'transfer')
            ->call('store')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('financial_transactions', [
            'type' => 'expense',
            'title' => 'Token Listrik Workshop',
            'amount' => 200000,
        ]);
    }

    public function test_admin_can_update_and_delete_transaction()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $transaction = FinancialTransaction::create([
            'user_id' => $admin->id,
            'type' => 'expense',
            'category' => 'Pembelian Alat & Tools Servis',
            'title' => 'Beli Obeng Set',
            'amount' => 150000,
            'transaction_date' => now()->format('Y-m-d'),
            'payment_method' => 'cash',
        ]);

        Livewire::actingAs($admin)
            ->test(FinancialTransactionList::class)
            ->call('edit', $transaction->id)
            ->set('amount', 175000)
            ->call('store')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('financial_transactions', [
            'id' => $transaction->id,
            'amount' => 175000,
        ]);

        Livewire::actingAs($admin)
            ->test(FinancialTransactionList::class)
            ->call('delete', $transaction->id);

        $this->assertDatabaseMissing('financial_transactions', [
            'id' => $transaction->id,
        ]);
    }
}
