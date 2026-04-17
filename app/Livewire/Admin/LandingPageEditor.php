<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\LandingPage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.admin')]
#[Title('Edit Landing Page')]
class LandingPageEditor extends Component
{
    public $state = [];

    public function mount()
    {
        $this->state = LandingPage::pluck('value', 'key')->toArray();
    }

    public function save()
    {
        foreach ($this->state as $key => $value) {
            LandingPage::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Landing page content updated successfully!'
        ]);
    }

    public function render()
    {
        return view('livewire.admin.landing-page-editor');
    }
}
