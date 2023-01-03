<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Vechile extends Component
{
    public $vechiles;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($vechiles)
    {
        $this->vechiles = $vechiles;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.vechile');
    }
}
