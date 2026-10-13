<?php

namespace App\Providers;

use App\Support\Media;
use App\View\Composers\SiteComposer;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(SiteComposer::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        AliasLoader::getInstance()->alias('Media', Media::class);

        View::composer(['components.*', 'partials.*', 'pages.*'], SiteComposer::class);
    }
}
