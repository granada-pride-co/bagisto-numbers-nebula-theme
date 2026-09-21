<?php

namespace NumbersNebula\NebulaCosmetics\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class NebulaCosmeticsServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void {}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'nc');

        $this->app['view']->prependNamespace('shop', __DIR__.'/../Resources/views');

        $this->loadTranslationsFrom(__DIR__.'/../Resources/lang', 'nc');

        Blade::anonymousComponentPath(__DIR__.'/../Resources/views/components', 'nc');

        Blade::anonymousComponentPath(__DIR__.'/../Resources/views/components', 'shop');

        $this->publishes([
            __DIR__.'/../Resources/views' => resource_path('themes/nebula-cosmetics/views'),
        ], 'nebula-cosmetics-views');

        $this->publishes([
            __DIR__.'/../Resources/assets/images' => public_path('themes/shop/nebula-cosmetics/images'),
        ], 'nebula-cosmetics-images');

        $this->loadRoutesFrom(__DIR__.'/../Routes/admin-routes.php');
    }
}
