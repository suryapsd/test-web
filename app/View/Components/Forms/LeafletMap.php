<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LeafletMap extends Component
{
    public $name;
    public $label;
    public $columnSpan;
    public $latitude;
    public $longitude;

    /**
     * Create a new component instance.
     */
    public function __construct($name, $label = null, $latitude = null, $longitude = null, $columnSpan = 'col-md-12')
    {
        $this->name = $name;
        $this->label = $label ?: format_field_label($name);
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->columnSpan = $columnSpan;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.forms.leaflet-map');
    }
}
