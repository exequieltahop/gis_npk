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

    public $type, $id, $name, $required, $label, $inputClass, $value;

    public function __construct($id = '', $name = '', $label = '', $type = 'text', $required = true, $inputClass = '', $value = '')
    {
        $this->type = $type;
        $this->id = $id;
        $this->name = $name;
        $this->required = $required;
        $this->label = $label;
        $this->inputClass = $inputClass;
        $this->value = $value;
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.input');
    }
}
