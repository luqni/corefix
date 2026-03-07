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

    public $search = '';
    public $sortField = 'name';
    public $sortDirection = 'asc';

    protected $rules = [
        'name' => 'required',
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
        $query = SparePartType::query();

        if (!empty($this->search)) {
            $query->where('name', 'ilike', '%' . $this->search . '%');
        }

        $query->orderBy($this->sortField, $this->sortDirection);

        return view('livewire.admin.spare-part-type-list', [
            'types' => $query->paginate(10),
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
