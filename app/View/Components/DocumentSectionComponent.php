<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DocumentSectionComponent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $section;
    public $isPublic;
    public $noButtons;
    public $document;

    public function __construct($section, $isPublic = false, $noButtons = false, $document = null)
    {
        //

        $this->section = $section;
        $this->isPublic = $isPublic;
        $this->noButtons = $noButtons;
        $this->document = $document;




    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.document-section-component');
    }


}
