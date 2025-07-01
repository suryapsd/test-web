<?php

namespace App\View\Components\FormWizard;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StepperNumberHeader extends Component
{
    public $stepNum;
    public $title;
    public $subtitle;
    public $chevron;

    /**
     * Create a new component instance.
     */
    public function __construct($stepNum, $title, $subtitle, $chevron = true)
    {
        $this->stepNum = $stepNum;
        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->chevron = $chevron;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form-wizard.stepper-number-header');
    }
}
