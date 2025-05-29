<?php
// app/Providers/AppServiceProvider.php - Enregistrer le service
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\GroqService;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(GroqService::class, function ($app) {
            return new GroqService();
        });
    }

    public function boot()
    {
        //
    }
}