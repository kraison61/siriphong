<?php

namespace App\View\Components\frontend;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class navbar extends Component
{
    public function render(): View|Closure|string
    {
        return view('components.frontend.navbar');
    }
}
