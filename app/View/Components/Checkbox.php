<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Checkbox extends Component
{
    public $id;
    public $name;
    public $checked;

    public function __construct($id, $name, $checked = false)
    {
        $this->id = $id;
        $this->name = $name;
        $this->checked = $checked;
    }

    public function render()
    {
        return view('components.checkbox');
    }
}
