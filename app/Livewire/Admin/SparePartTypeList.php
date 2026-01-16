<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\SparePartType;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Support\Str;

#[Layout('layouts.admin')]
class SparePartTypeList extends Component
{
    use WithPagination;

    public $name;
    public $typeId;
    public $isModalOpen = false;

    protected $rules = [
        'name' => 'required',
    ];

    public function render()
    {
        return view('livewire.admin.spare-part-type-list', [
            'types' => SparePartType::paginate(10),
            'title' => 'Spare Part Categories'
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
        $this->typeId = null;
    }

    public function store()
    {
        $this->validate();

        SparePartType::updateOrCreate(['id' => $this->typeId], [
            'name' => $this->name,
            'slug' => Str::slug($this->name),
        ]);

        session()->flash('message', $this->typeId ? 'Category Updated Successfully.' : 'Category Created Successfully.');

        $this->closeModal();
    }

    public function edit($id)
    {
        $type = SparePartType::findOrFail($id);
        $this->typeId = $id;
        $this->name = $type->name;

        $this->openModal();
    }

    public function delete($id)
    {
        SparePartType::find($id)->delete();
        session()->flash('message', 'Category Deleted Successfully.');
    }
}
