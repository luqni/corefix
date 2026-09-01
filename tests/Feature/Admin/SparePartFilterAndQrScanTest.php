<?php

namespace Tests\Feature\Admin;

use App\Models\SparePart;
use App\Models\SparePartType;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class SparePartFilterAndQrScanTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private SparePartType $typeLcd;
    private SparePartType $typeBattery;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->typeLcd = SparePartType::create(['name' => 'LCD Screen', 'slug' => 'lcd-screen']);
        $this->typeBattery = SparePartType::create(['name' => 'Battery', 'slug' => 'battery']);
    }

    public function test_spare_parts_can_be_filtered_by_category(): void
    {
        $part1 = SparePart::create([
            'code' => 'SP-LCD-01',
            'name' => 'LCD iPhone 11',
            'type' => 'LCD Screen',
            'spare_part_type_id' => $this->typeLcd->id,
            'capital_price' => 200000,
            'price' => 350000,
            'stock' => 10,
        ]);

        $part2 = SparePart::create([
            'code' => 'SP-BAT-01',
            'name' => 'Baterai iPhone 11',
            'type' => 'Battery',
            'spare_part_type_id' => $this->typeBattery->id,
            'capital_price' => 100000,
            'price' => 180000,
            'stock' => 5,
        ]);

        // When no category is filtered, both are visible
        Livewire::actingAs($this->admin)
            ->test(\App\Livewire\Admin\SparepartList::class)
            ->assertSee('LCD iPhone 11')
            ->assertSee('Baterai iPhone 11');

        // When LCD category is selected, only LCD is visible
        Livewire::actingAs($this->admin)
            ->test(\App\Livewire\Admin\SparepartList::class)
            ->set('selectedCategory', $this->typeLcd->id)
            ->assertSee('LCD iPhone 11')
            ->assertDontSee('Baterai iPhone 11');

        // When Battery category is selected, only Battery is visible
        Livewire::actingAs($this->admin)
            ->test(\App\Livewire\Admin\SparepartList::class)
            ->set('selectedCategory', $this->typeBattery->id)
            ->assertSee('Baterai iPhone 11')
            ->assertDontSee('LCD iPhone 11');
    }

    public function test_spare_part_lookup_by_code_or_qr_format(): void
    {
        $part = SparePart::create([
            'code' => 'SP-9999',
            'name' => 'Camera Module iPhone 12',
            'type' => 'Camera',
            'spare_part_type_id' => $this->typeLcd->id,
            'capital_price' => 150000,
            'price' => 250000,
            'stock' => 8,
        ]);

        // Direct code
        $this->assertEquals($part->id, SparePart::findByCodeOrId('SP-9999')?->id);
        
        // Direct ID
        $this->assertEquals($part->id, SparePart::findByCodeOrId((string)$part->id)?->id);

        // QR format: COREFIX:PART:SP-9999
        $this->assertEquals($part->id, SparePart::findByCodeOrId('COREFIX:PART:SP-9999')?->id);

        // QR format: COREFIX:PART:{id}
        $this->assertEquals($part->id, SparePart::findByCodeOrId("COREFIX:PART:{$part->id}")?->id);
    }

    public function test_admin_can_scan_qr_code_to_add_spare_part_to_ticket(): void
    {
        $ticket = Ticket::create([
            'customer_name' => 'Rian',
            'customer_wa' => '081234567899',
            'customer_address' => 'Jakarta Barat',
            'device_model' => 'iPhone 11',
            'issue_description' => 'Ganti LCD',
            'status' => 'repairing',
            'payment_status' => 'unpaid',
        ]);

        $part = SparePart::create([
            'code' => 'SP-LCD-11',
            'name' => 'LCD iPhone 11 Original',
            'type' => 'LCD Screen',
            'spare_part_type_id' => $this->typeLcd->id,
            'capital_price' => 250000,
            'price' => 450000,
            'stock' => 5,
        ]);

        // Test scan with Instant Add (true)
        Livewire::actingAs($this->admin)
            ->test(\App\Livewire\Admin\TicketDetail::class, ['id' => $ticket->id])
            ->call('scanPart', 'COREFIX:PART:SP-LCD-11', true)
            ->assertSee('LCD iPhone 11 Original');

        $this->assertDatabaseHas('ticket_items', [
            'ticket_id' => $ticket->id,
            'description' => 'LCD iPhone 11 Original',
            'price' => 450000,
            'capital_price' => 250000,
            'quantity' => 1,
            'is_spare_part' => true,
        ]);

        // Test barcode scanner USB input with enter key
        Livewire::actingAs($this->admin)
            ->test(\App\Livewire\Admin\TicketDetail::class, ['id' => $ticket->id])
            ->set('scanInput', 'SP-LCD-11')
            ->call('handleScanSubmit', true);

        // Total items should now be 2
        $this->assertEquals(2, $ticket->fresh()->items()->count());
    }

    public function test_scanning_invalid_qr_shows_error_notification(): void
    {
        $ticket = Ticket::create([
            'customer_name' => 'Rian',
            'customer_wa' => '081234567899',
            'customer_address' => 'Jakarta Barat',
            'device_model' => 'iPhone 11',
            'issue_description' => 'Ganti LCD',
            'status' => 'repairing',
            'payment_status' => 'unpaid',
        ]);

        Livewire::actingAs($this->admin)
            ->test(\App\Livewire\Admin\TicketDetail::class, ['id' => $ticket->id])
            ->call('scanPart', 'SP-INVALID-999', true)
            ->assertSee('tidak ditemukan');
    }
}
