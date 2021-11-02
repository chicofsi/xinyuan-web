<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Area;

class SideBar extends Component
{
    public function render()
    {
    	$areas=Area::get();

        return view('livewire.side-bar',compact('areas'));
    }
}
