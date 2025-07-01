<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SinglePqnia extends Component
{
    public $label;
    public $name;
    public $type;
    public $placeholder;
    public $required;
    public $class;
    public $columnSpan;
    public $images;

    /**
     * Create a new component instance.
     */
    public function __construct(
        $name,
        $label = null,
        $type = 'text',
        $placeholder = null,
        $required = true,
        $class = '',
        $columnSpan = 'col-12',
        $images = null
    ) {
        $nameTemp = str_replace('_', ' ', $name);
        $this->name = $name;
        $this->label = $label ?: format_field_label($name);
        $this->type = $type;
        $this->placeholder = $placeholder ?: 'Enter the ' . $nameTemp;
        $this->required = filter_var($required, FILTER_VALIDATE_BOOLEAN);
        $this->class = $class;
        $this->columnSpan = $columnSpan;
        $this->images = $images;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.forms.single-pqnia');
    }
}
