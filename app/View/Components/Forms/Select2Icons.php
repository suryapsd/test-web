<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Select2Icons extends Component
{
    public $name;
    public $label;
    public $required;
    public $class;
    public $columnSpan;
    public $datas;

    /**
     * Create a new component instance.
     */
    public function __construct(
        $name,
        $label = null,
        $required = true,
        $class = '',
        $columnSpan = 'col-12',
        $datas
    ) {
        $this->name = $name;
        $this->label = $label ?: format_field_label($name);
        $this->required = filter_var($required, FILTER_VALIDATE_BOOLEAN);
        $this->class = $class;
        $this->columnSpan = $columnSpan;
        $this->datas = $datas;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.forms.select2-icons');
    }
}
