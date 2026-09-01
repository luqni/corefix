<?php

namespace Tests\Feature\Admin;

use App\Models\FinancialTransaction;
use App\Models\Ticket;
use App\Models\TicketItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class DashboardFilterAndExportTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $teknisi;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->teknisi = User::factory()->create([
            'role' => 'teknisi',
        ]);
    }

    public function test_dashboard_filters_data_by_last_month_properly(): void
    {
        // 1. Order from THIS month
        $thisMonthTicket = Ticket::create([
            'customer_name' => 'Alice This Month',
            'customer_wa' => '0811111111',
            'customer_address' => 'Jakarta',
            'device_model' => 'iPhone 13',
            'issue_description' => 'LCD Broken',
            'status' => 'done',
            'payment_status' => 'paid',
            'total_cost' => 500000,
        ]);

        // 2. Order from LAST month
        $lastMonthDate = now()->subMonth()->startOfMonth()->addDays(5);
        $lastMonthTicket = Ticket::create([
            'customer_name' => 'Bob Last Month',
            'customer_wa' => '0822222222',
            'customer_address' => 'Semarang',
            'device_model' => 'Samsung S21',
            'issue_description' => 'Battery Replacement',
            'status' => 'done',
            'payment_status' => 'paid',
            'total_cost' => 300000,
        ]);
        $lastMonthTicket->created_at = $lastMonthDate;
        $lastMonthTicket->saveQuietly();

        // 3. Financial Transaction from LAST month
        FinancialTransaction::create([
            'user_id' => $this->admin->id,
            'type' => 'expense',
            'category' => 'Listrik, Air & Kebersihan',
            'title' => 'Tagihan Listrik PLN Bulan Lalu',
            'amount' => 150000,
            'transaction_date' => $lastMonthDate->format('Y-m-d'),
            'payment_method' => 'transfer',
        ]);

        // Test with last_month filter
        Livewire::actingAs($this->admin)
            ->test(\App\Livewire\Admin\Dashboard::class)
            ->set('dateFilter', 'last_month')
            ->assertViewHas('revenue', 300000)
            ->assertViewHas('completed', 1)
            ->assertViewHas('otherExpense', 150000)
            ->assertSee('Bulan Lalu');
    }

    public function test_admin_can_export_dashboard_financial_report_to_excel_csv(): void
    {
        $ticket = Ticket::create([
            'customer_name' => 'John Export',
            'customer_wa' => '08123456789',
            'customer_address' => 'Bandung',
            'device_model' => 'MacBook Pro M1',
            'issue_description' => 'Keyboard not working',
            'status' => 'done',
            'payment_status' => 'paid',
            'total_cost' => 1200000,
        ]);

        TicketItem::create([
            'ticket_id' => $ticket->id,
            'description' => 'Keyboard Original MacBook M1',
            'price' => 1200000,
            'capital_price' => 700000,
            'quantity' => 1,
            'is_spare_part' => true,
        ]);

        FinancialTransaction::create([
            'user_id' => $this->admin->id,
            'type' => 'expense',
            'category' => 'Internet, Wi-Fi & Pulsa',
            'title' => 'Indihome Toko',
            'amount' => 350000,
            'transaction_date' => now()->format('Y-m-d'),
            'payment_method' => 'transfer',
        ]);

        $component = Livewire::actingAs($this->admin)
            ->test(\App\Livewire\Admin\Dashboard::class)
            ->set('dateFilter', 'all')
            ->call('exportExcel');

        $response = $component->instance()->exportExcel();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('text/csv', $response->headers->get('Content-Type'));
        $this->assertStringContainsString('Laporan_Keuangan_CoreFix', $response->headers->get('Content-Disposition'));

        // Capture streamed response content
        ob_start();
        $response->sendContent();
        $csvContent = ob_get_clean();

        $this->assertStringContainsString('LAPORAN KEUANGAN & PERFORMA OPERASIONAL COREFIX', $csvContent);
        $this->assertStringContainsString('John Export', $csvContent);
        $this->assertStringContainsString('MacBook Pro M1', $csvContent);
        $this->assertStringContainsString('Indihome Toko', $csvContent);
        $this->assertStringContainsString('TOTAL LABA BERSIH AKHIR (NET PROFIT)', $csvContent);
    }
}
