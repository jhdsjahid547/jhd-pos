<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PerPageSelector extends Component
{
    public $perPage, $options, $routeName;
    /**
     * Create a new component instance.
     */
    public function __construct($perPage = 10, $options = [10, 20, 50, 100], $routeName = null)
    {
        $this->perPage = (int) request('per_page', $perPage);
        $this->options = $options;
        $this->routeName = $routeName;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.per-page-selector');
    }
}
