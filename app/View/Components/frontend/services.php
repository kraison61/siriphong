<?php

namespace App\View\Components\frontend;

use App\Models\Category;
use App\Models\Product;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class services extends Component
{
    /** @var Collection<int, Category> */
    public Collection $categories;

    /** @var Collection<int, Product> */
    public Collection $services;

    /**
     * @var array<string, string>
     */
    public array $categoryIcons = [
        'motor' => 'bi-cpu',
        'filter' => 'bi-funnel',
        'electrical' => 'bi-lightning',
        'pipe' => 'bi-bezier2',
        'repair-service' => 'bi-tools',
        'maintenance' => 'bi-clipboard2-pulse',
    ];

    /**
     * @var list<string>
     */
    public array $gradients = [
        'bg-[linear-gradient(135deg,#0f2347_0%,#3d5a80_100%)]',
        'bg-[linear-gradient(135deg,#1e4a8a,#0f2347)]',
        'bg-[linear-gradient(135deg,#1a3a6b,#0d2b5e)]',
        'bg-[linear-gradient(135deg,#2a5298,#1a3a6b)]',
        'bg-[linear-gradient(135deg,#0f2347,#1e4a8a)]',
        'bg-[linear-gradient(135deg,#1a3a6b,#2a5298)]',
    ];

    public function __construct()
    {
        $this->categories = Category::query()
            ->where('type', 'service')
            ->orderBy('sort_order')
            ->get();

        $this->services = Product::query()
            ->with('category')
            ->where('type', 'service')
            ->where('is_active', true)
            ->orderByDesc('is_featured')
            ->orderBy('id')
            ->get();
    }

    public function render(): View|Closure|string
    {
        return view('components.frontend.services');
    }
}
