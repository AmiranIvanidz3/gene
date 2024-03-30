<?php

namespace App\View\Components;

use Illuminate\View\Component;

use App\Models\Blockchain;

class BlockchainCards extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $blockchains;

    public function __construct($blockchains = null)
    {
        $this->blockchains = $blockchains ? $blockchains : $this->getAllBBlockchains();
    }

    public function getAllBBlockchains(){
        return Blockchain::orderBy('id')->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.blockchain-cards');
    }
}
