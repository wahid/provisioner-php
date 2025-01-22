<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);

        /*Log::info(message: "Registering plugins");

        if (Schema::hasTable('plugins')) {
            $manager = new Manager();
            $manager->register(Google::class);
            $manager->register(Afas::class);

            $this->app->singleton(Manager::class, function ($app) use ($manager) {
                return $manager;
            });

            Log::info(message: "Plugins registered");
        } else {
            Log::info(message: "Plugins table does not exist");
        }*/
    }
}
