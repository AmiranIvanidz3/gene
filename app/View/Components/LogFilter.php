<?php

namespace App\View\Components;

use Illuminate\View\Component;

class LogFilter extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $filters = [
        'ip' => 'IP',
        'session' => 'Session',
        'query_string' => 'Query String',
        'referrer' => 'Referrer',
    ];
    public function __construct()
    {
    
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.log-filter');
    }
}
