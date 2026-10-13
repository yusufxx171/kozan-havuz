<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Project;
use App\Models\Service;
use App\Models\Slider;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        return view('pages.home', [
            'sliders' => Slider::query()->published()->get(),
            'categories' => Category::query()->published()->withCount(['products' => fn ($query) => $query->active()])->get(),
            'services' => Service::query()->published()->where('is_featured', true)->get(),
            'featuredProducts' => Product::query()->published()->where('is_featured', true)->with('category')->limit(8)->get(),
            'projects' => Project::query()->published()->limit(4)->get(),
        ]);
    }
}
