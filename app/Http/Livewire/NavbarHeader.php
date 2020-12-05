<?php

namespace App\Http\Livewire;

use Livewire\Component;

class NavbarHeader extends Component
{
    public $hiddenNavbar = false;

    public $hiddenNavbarMenu = true;

    public function render()
    {
        return view('livewire.navbar-header');
    }
}
