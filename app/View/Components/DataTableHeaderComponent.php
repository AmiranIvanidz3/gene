<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DataTableHeaderComponent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $header;
    public $url;
    public $createButton;
    public $createButtonText;
    
    public function __construct($header, $url, $createButton = true, $createButtonText = "{{ env('CREATE_NEW') }}")
    {
        //

        $this->header = $header;
        $this->url = $url;
        $this->createButton = $createButton;
        $this->createButtonText = $createButtonText;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.data-table-header-component');
    }
}
