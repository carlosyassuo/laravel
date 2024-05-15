<?php

namespace CarlosYassuo\Laravel\Providers;

use Illuminate\Support\ServiceProvider;

class InspirationProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->commands([
            \CarlosYassuo\Laravel\Commands\Cms\CreatePage::class,
        ]);
    }
}
