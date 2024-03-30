<?php

namespace App\View\Components;

use Illuminate\View\Component;

class author extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $author;
    public $actualreel;
    public $css;
    public $class;
    public $actualvideo;

    public function __construct($author, $actualreel = null, $actualvideo = null, $css = null)
    {
        $this->author = $author;
        $this->actualreel = $actualreel;
        $this->actualvideo = $actualvideo;
        $this->css = $css;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.author');
    }
}
