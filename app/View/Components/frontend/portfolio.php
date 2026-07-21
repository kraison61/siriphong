<?php

namespace App\View\Components\frontend;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class portfolio extends Component
{
    /** @var Collection<int, \App\Models\Portfolio> */
    public Collection $portfolios;

    /**
     * @var list<string>
     */
    public array $gradients = [
        'bg-[linear-gradient(135deg,#0f2347,#2a5298)]',
        'bg-[linear-gradient(135deg,#1a3a6b,#0f2347)]',
        'bg-[linear-gradient(135deg,#2a5298,#1a3a6b)]',
    ];

    public function __construct()
    {
        $this->portfolios = \App\Models\Portfolio::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();
    }

    public function render(): View|Closure|string
    {
        return view('components.frontend.portfolio');
    }
}
