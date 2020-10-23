<?php

declare(strict_types=1);

namespace Rszewc\Thecats;

use Rszewc\Thecats\HttpClient\ThecatsHttpClient;
use Illuminate\Support\ServiceProvider;

class CatsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/cats.php' => config_path('cats.php'),
        ], 'config');
    }

    public function register()
    {
        $this->app->singleton(Cats::class, function ($app) {
            $client = new ThecatsHttpClient(config('cats.auth.key'));
            return new Cats($client);
        });

        $this->mergeConfigFrom(
            __DIR__.'/config/cats.php', 'cats'
        );
    }
}