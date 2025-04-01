<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Input extends Component
{
    /**
     * Create a new component instance.
     */

    public $type, $id, $name, $required, $label, $inputClass;

    public function __construct($type, $id, $name, $required = true, $label, $inputClass = '')
    {
        $this->type = $type;
        $this->id = $id;
        $this->name = $name;
        $this->required = $required;
        $this->label = $label;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.input');
    }
}
