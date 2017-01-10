<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(
            ['layouts.main', 'layouts.admin'],
            'App\Http\ViewComposers\BodyClassComposer'
        );

        view()->composer(
            ['layouts.admin'],
            'App\Http\ViewComposers\AdminMenuComposer'
        );

    }
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
