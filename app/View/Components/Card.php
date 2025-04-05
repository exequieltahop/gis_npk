<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Card extends Component
{
    /**
     * Create a new component instance.
     */

    public $cardTitle, $cardBodyClass;

    public function __construct($cardTitle, $cardBodyClass = '')
    {
        $this->cardTitle = $cardTitle;
        $this->cardBodyClass = $cardBodyClass;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.card');
    }
}
