<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ImpactScaleComponent extends Component
{

    public $count_impact_types;
    public $count_impacts;
    public $color;
    public $impact_data_json;
    public $impact_scale_values;
    public $impacts;
    public $risk_treatment_details_json;
    public $edit;
    public $disableButtons;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($countImpactTypes, $impactDataJson, $impactScaleValues, $impacts, $riskTreatmentDetailsJson, $edit, $countImpacts = null, $disableButtons = false, $color = '#cfcfcf')
    {
        $this->count_impact_types = $countImpactTypes;
        $this->count_impacts = $countImpacts ? $countImpacts : count($impacts);
        $this->color = $color;
        $this->impact_data_json = $impactDataJson;
        $this->impact_scale_values = $impactScaleValues;
        $this->impacts = $impacts;
        $this->risk_treatment_details_json = $riskTreatmentDetailsJson;
        $this->edit = $edit;
        $this->disableButtons = $disableButtons;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.impact-scale-component');
    }
}
