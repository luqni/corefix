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

    public $name, $code, $capital_price, $price, $stock, $spare_part_type_id;
    public $partId;
    public $isModalOpen = false;
    public $isQrModalOpen = false;
    public $selectedPartForQr = null;

    public $search = '';
    public $selectedCategory = '';
    public $sortField = 'name';
    public $sortDirection = 'asc';

    protected function rules()
    {
        return [
            'name' => 'required|min:2',
            'code' => 'nullable|string|max:50|unique:spare_parts,code,' . $this->partId,
            'spare_part_type_id' => 'required|exists:spare_part_types,id',
            'capital_price' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ];
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedCategory()
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

        if (!empty($this->selectedCategory)) {
            $query->where('spare_part_type_id', $this->selectedCategory);
        }

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('name', 'ilike', '%' . $this->search . '%')
                  ->orWhere('code', 'ilike', '%' . $this->search . '%')
                  ->orWhereHas('type', function ($tq) {
                      $tq->where('name', 'ilike', '%' . $this->search . '%');
                  });
            });
        }

        $query->orderBy($this->sortField, $this->sortDirection);

        return view('livewire.admin.sparepart-list', [
            'parts' => $query->paginate(10),
            'types' => SparePartType::orderBy('name', 'asc')->get(),
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

    public function showQrModal($id)
    {
        $this->selectedPartForQr = SparePart::with('type')->findOrFail($id);
        $this->isQrModalOpen = true;
    }

    public function closeQrModal()
    {
        $this->isQrModalOpen = false;
        $this->selectedPartForQr = null;
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->code = '';
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

        $data = [
            'name' => $this->name,
            'code' => !empty($this->code) ? trim($this->code) : null,
            'spare_part_type_id' => $this->spare_part_type_id,
            'type' => $type ? $type->name : 'General',
            'capital_price' => $this->capital_price,
            'price' => $this->price,
            'stock' => $this->stock,
        ];

        SparePart::updateOrCreate(['id' => $this->partId], $data);

        session()->flash('message', $this->partId ? 'Spare Part Updated Successfully.' : 'Spare Part Created Successfully.');

        $this->closeModal();
    }

    public function edit($id)
    {
        $part = SparePart::findOrFail($id);
        $this->partId = $id;
        $this->name = $part->name;
        $this->code = $part->code;
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
