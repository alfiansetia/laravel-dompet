<?php

namespace App\Providers;

use App\Models\Comp;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        view()->composer(
            [
                'layouts.template',
                'comp.index'
            ],
            function ($view) {
                $view->with('comp', Comp::first());
                $view->with('user', auth()->user());
            }
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
