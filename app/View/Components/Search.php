<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Search extends Component
{
    public $column, $placeholder;
    /**
     * Create a new component instance.
     */
    public function __construct(
        string $column = 'search',
        string $placeholder = 'Search...'
    )
    {
        $this->column = $column;
        $this->placeholder = $placeholder;
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.search', [
            'value' => request($this->column)
        ]);
    }
}
