<?php

namespace App\Livewire\Admin;

use App\Models\SparePart;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin', ['title' => 'Spare Parts Management'])]
class SparepartList extends Component
{
    use WithPagination;

    public $showModal = false;
    public $partId;
    public $name;
    public $type;
    public $price;
    public $stock = 0;

    protected $rules = [
        'name' => 'required|min:3',
        'type' => 'required',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
    ];

    public function create()
    {
        $this->reset(['partId', 'name', 'type', 'price', 'stock']);
        $this->showModal = true;
    }

    public function edit($id)
    {
        $part = SparePart::findOrFail($id);
        $this->partId = $part->id;
        $this->name = $part->name;
        $this->type = $part->type;
        $this->price = $part->price;
        $this->stock = $part->stock;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->partId) {
            $part = SparePart::findOrFail($this->partId);
            $part->update([
                'name' => $this->name,
                'type' => $this->type,
                'price' => $this->price,
                'stock' => $this->stock,
            ]);
            session()->flash('message', 'Spare part updated successfully.');
        } else {
            SparePart::create([
                'name' => $this->name,
                'type' => $this->type,
                'price' => $this->price,
                'stock' => $this->stock,
            ]);
            session()->flash('message', 'Spare part added successfully.');
        }

        $this->showModal = false;
        $this->reset(['partId', 'name', 'type', 'price', 'stock']);
    }

    public function delete($id)
    {
        SparePart::findOrFail($id)->delete();
        session()->flash('message', 'Spare part deleted successfully.');
    }

    public function render()
    {
        return view('livewire.admin.sparepart-list', [
            'parts' => SparePart::latest()->paginate(10),
        ]);
    }
}
