<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ControlCardComponent extends Component
{

    public $jsonData;
    public $canUpdate = false;
    public $countControlCards = 0;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($jsonData = null, $canUpdate = false, $countControlCards = 0)
    {
        $this->jsonData = $jsonData;
        $this->canUpdate = $canUpdate;
        $this->countControlCards = $countControlCards;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.control-card-component');
    }
}
