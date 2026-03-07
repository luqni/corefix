<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin', ['title' => 'User Management'])]
class UserList extends Component
{
    use WithPagination;

    public $isModalOpen = false;
    public $userId = null;
    
    public $name = '';
    public $email = '';
    public $password = '';
    public $role = 'teknisi';

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount()
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Unauthorized. Super Admin only.');
        }
    }

    public function openModal()
    {
        $this->resetInputFields();
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
        $this->email = '';
        $this->password = '';
        $this->role = 'teknisi';
        $this->userId = null;
    }

    public function store()
    {
        $rules = [
            'name' => 'required',
            'email' => ['required', 'email', Rule::unique('users')->ignore($this->userId)],
            'role' => 'required|in:super_admin,admin,teknisi',
        ];

        if (!$this->userId) {
            $rules['password'] = 'required|min:6';
        } else {
            $rules['password'] = 'nullable|min:6';
        }

        $this->validate($rules);

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
        ];

        if ($this->password) {
            $data['password'] = bcrypt($this->password);
        }

        User::updateOrCreate(['id' => $this->userId], $data);
        
        session()->flash('message', $this->userId ? 'User updated successfully.' : 'User created successfully.');
        
        $this->closeModal();
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->userId = $id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        // don't set password so it stays blank unless changed
        
        $this->isModalOpen = true;
    }

    public function delete($id)
    {
        // Prevent deleting yourself
        if ($id == auth()->id()) {
            session()->flash('error', 'You cannot delete yourself.');
            return;
        }

        User::find($id)->delete();
        session()->flash('message', 'User deleted successfully.');
    }

    public function render()
    {
        $users = User::latest()
            ->when($this->search, function($query) {
                $query->where('name', 'ilike', '%' . $this->search . '%')
                      ->orWhere('email', 'ilike', '%' . $this->search . '%')
                      ->orWhere('role', 'ilike', '%' . $this->search . '%');
            })
            ->paginate(10);
            
        return view('livewire.admin.user-list', [
            'users' => $users
        ]);
    }
}
