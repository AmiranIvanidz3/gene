<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TasksModal extends Component
{
    public $title;
    public $priorities;
    public $users;
    public $target;
    public $disableTable;
    public $id;
    public $submitButtonId;
    public $formId;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title = 'Create Task', $priorities = [], $users = [], $target = 'control_id', $disableTable = null, $id = null, $submitButtonId = 'add_tasks_btn', $formId = 'add_tasks_form')
    {
        $this->title = $title;
        $this->priorities = $priorities;
        $this->users = $users;
        $this->target = $target;
        $this->disableTable = $disableTable;
        $this->id = $id;
        $this->submitButtonId = $submitButtonId;
        $this->formId = $formId;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tasks-modal');
    }
}
