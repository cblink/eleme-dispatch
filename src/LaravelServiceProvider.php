<?php


namespace Cblink\ElemeDispatch;


class LaravelServiceProvider extends \Illuminate\Support\ServiceProvider
{
    protected $defer = true;

    public function register()
    {
        $this->app->singleton(ElemeDispatch::class, function() {
            return new ElemeDispatch(config('services.eleme-dispatch'));
        });

        $this->app->alias(ElemeDispatch::class, 'eleme-dispatch');
    }

    public function provides()
    {
        return [ElemeDispatch::class, 'eleme-dispatch'];
    }
}