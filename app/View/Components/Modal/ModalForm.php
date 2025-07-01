<?php

namespace App\View\Components\Modal;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ModalForm extends Component
{
    public $id;
    public $title;
    public $size;
    public $formAction;
    public $formId;
    public $isrequired;
    public $modalScroll;

    /**
     * Create a new component instance.
     */
    public function __construct(
        $id,
        $title,
        $size = '',
        $formAction = 'javascript:void(0)',
        $formId = 'modalForm',
        $isrequired = true,
        $modalScroll = true,
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->size = $size;
        $this->formAction = $formAction;
        $this->formId = $formId;
        $this->isrequired = filter_var($isrequired, FILTER_VALIDATE_BOOLEAN);
        $this->modalScroll = filter_var($modalScroll, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.modal.modal-form');
    }
}
