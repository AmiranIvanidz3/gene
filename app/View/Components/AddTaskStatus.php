<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AddTaskStatus extends Component
{

    public $isMine;
    public $isCreator;
    public $item;
    public $errors;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($isMine, $item, $errors, $isCreator)
    {
        $this->isMine = $isMine;
        $this->isCreator = $isCreator;
        $this->item = $item;
        $this->errors = $errors;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.add-task-status');
    }
}
