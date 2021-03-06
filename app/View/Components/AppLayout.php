<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AppLayout extends Component
{

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public ?string $title = null,
        public ?string $ribbon = null,
        public ?string $style = null,
        public ?string $script = null,
    )
    {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('layouts.app');
    }
}
