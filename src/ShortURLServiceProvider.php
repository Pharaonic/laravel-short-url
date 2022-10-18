<?php

namespace Pharaonic\Laravel\ShortURL;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class ShortURLServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Config Merge
        $this->mergeConfigFrom(__DIR__ . '/config/short-url.php', 'Pharaonic.short-url');

        // Loads
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    { 
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/database/migrations' => database_path('migrations'),
            ], ['migrations', 'pharaonic', 'laravel-short-url']);

            $this->publishes([
                __DIR__ . '/config.php' => config_path('Pharaonic/basket.php')
            ], ['config', 'pharaonic', 'laravel-short-url']);
        } else {
            // Directive
            Blade::directive('shortURL', function ($data = null) {
                return "<?php echo shortURL($data); ?>";
            });
    
            // Routes
            $this->loadRoutesFrom(__DIR__ . '/route.php');
        }
    }
}
