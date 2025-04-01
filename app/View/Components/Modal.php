<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Modal extends Component
{
    /**
     * Create a new component instance.
     */

    public $modalId, $modalTitle, $modalBodyClass;

    public function __construct($modalId, $modalTitle, $modalBodyClass = '')
    {
        $this->modalId = $modalId;
        $this->modalTitle = $modalTitle;
        $this->modalBodyClass = $modalBodyClass;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.modal');
    }
}
