<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Trade Entry
        $this->app->bind(
            'App\Trade\Interfaces\EntryInterface',
            'App\Trade\Repositories\EntryEloquent'
        );
        
        // Capital Entry
        $this->app->bind(
            'App\Capital\Interfaces\EntryInterface',
            'App\Capital\Repositories\EntryEloquent'
        );

        
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
