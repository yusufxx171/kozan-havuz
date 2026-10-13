<?php

namespace App\View\Composers;

use App\Models\Category;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Support\Collection;
use Illuminate\View\View;

/**
 * Shares site-wide settings and navigation data with the public layout.
 */
class SiteComposer
{
    /**
     * @var array{site: array<string, string|null>, navCategories: Collection<int, Category>, navServices: Collection<int, Service>}|null
     */
    private ?array $data = null;

    public function compose(View $view): void
    {
        $this->data ??= [
            'site' => Setting::allValues(),
            'navCategories' => Category::query()->published()->get(['id', 'name', 'slug', 'icon']),
            'navServices' => Service::query()->published()->get(['id', 'title', 'slug']),
        ];

        $view->with($this->data);
    }
}
