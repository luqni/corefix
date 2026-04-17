<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\LandingPage;

class Home extends Component
{
    public function render()
    {
        return view('livewire.home')->layout('layouts.landing');
    }
}
