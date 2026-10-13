<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\View\View;

class PageController extends Controller
{
    public function about(): View
    {
        return view('pages.about', [
            'page' => Page::query()->where('slug', 'hakkimizda')->where('is_active', true)->firstOrFail(),
        ]);
    }

    public function show(Page $page): View
    {
        abort_unless($page->is_active, 404);

        return view('pages.page', ['page' => $page]);
    }
}
