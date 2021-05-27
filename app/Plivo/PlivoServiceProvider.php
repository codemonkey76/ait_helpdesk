<?php

namespace App\Plivo;

use Illuminate\Support\ServiceProvider;

class PlivoServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->when(PlivoChannel::class)
            ->needs(Plivo::class)
            ->give(fn() => new Plivo(config('services.plivo')));
    }
}
