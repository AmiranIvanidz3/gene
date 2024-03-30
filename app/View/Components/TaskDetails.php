<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TaskDetails extends Component
{

    public $item;
    public $priorityColor;
    /**
     * Create a new component instance.
     *
     * @return void
     */

     
    public function __construct($item, $priorityColor)
    {
        //
        $this->item = $item;
        $this->priorityColor = $priorityColor;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.task-details');
    }
}
