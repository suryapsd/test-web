<?php

namespace App\View\Components\FormWizard;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StepperNumberContent extends Component
{
    public $contentNum;
    public $title;
    public $desc;
    public $isFirst;
    public $isLast;

    /**
     * Create a new component instance.
     */
    public function __construct($contentNum, $title, $desc, $isFirst = false, $isLast = false)
    {
        $this->contentNum = $contentNum;
        $this->title = $title;
        $this->desc = $desc;
        $this->isFirst = $isFirst;
        $this->isLast = $isLast;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form-wizard.stepper-number-content');
    }
}
