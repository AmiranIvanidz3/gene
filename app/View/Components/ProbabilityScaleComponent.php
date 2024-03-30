<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ProbabilityScaleComponent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */


    public $errors;
    public $edit;
    public $risk_treatment_details_json;
    public $probabilities;

    public function __construct($errors, $edit, $riskTreatmentDetailsJson, $probabilities)
    {
        $this->errors = $errors;
        $this->edit = $edit;
        $this->risk_treatment_details_json = $riskTreatmentDetailsJson;
        $this->probabilities = $probabilities;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.probability-scale-component');
    }
}
