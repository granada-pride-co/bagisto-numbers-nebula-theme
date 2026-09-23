<?php

namespace NumbersNebula\NebulaCosmetics\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use NumbersNebula\NebulaCosmetics\Database\Seeders\NebulaCosmeticsSectionsSeeder;
use Webkul\Theme\Contracts\Section;
use Webkul\Theme\SectionSchema;

class NebulaCosmeticsServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../Config/system.php',
            'core'
        );

        $this->app->singleton(
            SectionSchema::class,
            \NumbersNebula\NebulaCosmetics\Sections\SectionSchema::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->concord->registerModel(
            Section::class,
            \NumbersNebula\NebulaCosmetics\Models\Section::class
        );

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

        Event::listen('appearance.theme.activate.after', function ($channel) {
            if ($channel->theme === 'nebula-cosmetics') {
                app(NebulaCosmeticsSectionsSeeder::class)->seedForChannel($channel);
            }
        });

        Event::listen('bagisto.admin.appearance.sections.index.after', function ($viewRenderEventManager) {
            $viewRenderEventManager->addTemplate('nc::admin.appearance.color-fields');
        });
    }
}
