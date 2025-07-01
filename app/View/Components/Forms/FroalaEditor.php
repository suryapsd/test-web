<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FroalaEditor extends Component
{
    public $name;
    public $label;
    public $required;
    public $columnSpan;

    /**
     * Create a new component instance.
     */
    public function __construct($name, $label = null, $required = false, $columnSpan = 'col-12')
    {
        $this->name = $name;
        $this->label = $label ?: format_field_label($name);
        $this->required = filter_var($required, FILTER_VALIDATE_BOOLEAN);
        $this->columnSpan = $columnSpan;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.forms.froala-editor');
    }
}
