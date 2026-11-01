<?php

namespace NjDigitalLab\Larables\Providers;

use Illuminate\Support\ServiceProvider;
use NjDigitalLab\Larables\Commands\MakeTableCommand;
use NjDigitalLab\Larables\Larables;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([
            MakeTableCommand::class,
        ]);
    }
    
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', Larables::viewsId());

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../../public' => public_path(Larables::assetsRelativePath()),
            ], Larables::assetsTagId());

            $this->publishes([
                __DIR__. '/../../resources/views' => resource_path(Larables::viewsRelativePath()),
            ], Larables::viewsTagId());
        }
    }
}