<?php

namespace App\View\Components;

use App\Models\Category;
use Illuminate\View\Component;
use Illuminate\View\View;

class SiteLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        $categories = Category::where('level', '!=', 0)->get();

        return view('layouts.site', compact('categories'));
    }
}
