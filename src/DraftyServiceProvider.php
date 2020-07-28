<?php

namespace Nekodev\Drafty;

use Illuminate\Support\ServiceProvider;

class DraftyServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
    }

    public function register()
    {
        $this->commands([
            Console\DraftModelCommand::class,
        ]);
    }
}
