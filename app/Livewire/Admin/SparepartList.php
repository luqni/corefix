<?php

namespace App\Livewire\Admin;

use App\Models\SparePart;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Models\SparePartType; // Added this import

#[Layout('layouts.admin')]
class SparepartList extends Component
{
    use WithPagination;

    public $name, $capital_price, $price, $stock, $spare_part_type_id; // type removed from public property, using relation
    public $partId;
    public $isModalOpen = false;

    public $search = '';
    public $sortField = 'name';
    public $sortDirection = 'asc';

    protected $rules = [
        'name' => 'required',
        'spare_part_type_id' => 'required|exists:spare_part_types,id',
        'capital_price' => 'required|numeric',
        'price' => 'required|numeric',
        'stock' => 'required|integer',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function render()
    {
        $query = SparePart::with('type');

        if (!empty($this->search)) {
            $query->where('name', 'ilike', '%' . $this->search . '%')
                  ->orWhereHas('type', function ($q) {
                      $q->where('name', 'ilike', '%' . $this->search . '%');
                  });
        }

        $query->orderBy($this->sortField, $this->sortDirection);

        return view('livewire.admin.sparepart-list', [
            'parts' => $query->paginate(10), // Eager load type
            'types' => SparePartType::all(), // Pass types for dropdown
            'title' => 'Spare Parts Inventory'
        ]);
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetInputFields();
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->spare_part_type_id = null;
        $this->capital_price = '';
        $this->price = '';
        $this->stock = '';
        $this->partId = null;
    }

    public function store()
    {
        $this->validate();

        $type = SparePartType::find($this->spare_part_type_id);

        SparePart::updateOrCreate(['id' => $this->partId], [
            'name' => $this->name,
            'spare_part_type_id' => $this->spare_part_type_id,
            'type' => $type->name, // Keep syncing type string for now just in case
            'capital_price' => $this->capital_price,
            'price' => $this->price,
            'stock' => $this->stock,
        ]);

        session()->flash('message', $this->partId ? 'Spare Part Updated Successfully.' : 'Spare Part Created Successfully.');

        $this->closeModal();
    }

    public function edit($id)
    {
        $part = SparePart::findOrFail($id);
        $this->partId = $id;
        $this->name = $part->name;
        $this->spare_part_type_id = $part->spare_part_type_id;
        $this->capital_price = $part->capital_price;
        $this->price = $part->price;
        $this->stock = $part->stock;

        $this->openModal();
    }

    public function delete($id)
    {
        SparePart::findOrFail($id)->delete();
        session()->flash('message', 'Spare part deleted successfully.');
    }

    // Removed duplicate render method
}
