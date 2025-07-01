<?php

namespace App\View\Components\FormWizard;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StepperNumber extends Component
{
    public $steps;

    /**
     * Create a new component instance.
     */
    public function __construct($steps)
    {
        $this->steps = $steps;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form-wizard.stepper-number');
    }
}
