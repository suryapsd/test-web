<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Select2Default extends Component
{
    public $name;
    public $label;
    public $required;
    public $class;
    public $columnSpan;
    public $datas;
    public $btnNew;

    /**
     * Create a new component instance.
     */
    public function __construct(
        $name,
        $label = null,
        $required = true,
        $class = '',
        $columnSpan = 'col-12',
        $datas,
        $btnNew = false,
    ) {
        $this->name = $name;
        $this->label = $label ?: format_field_label($name);
        $this->required = filter_var($required, FILTER_VALIDATE_BOOLEAN);
        $this->class = $class;
        $this->columnSpan = $columnSpan;
        $this->datas = $datas;
        $this->btnNew = filter_var($btnNew, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.forms.select2-default');
    }
}
