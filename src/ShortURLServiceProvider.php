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
        $this->mergeConfigFrom(__DIR__ . '/config/short-url.php', ['pharaonic', 'laravel-short-url']);

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
        // Publishes
        $this->publishes([
            __DIR__ . '/config/short-url.php' => config_path('Pharaonic/short-url.php'),
            __DIR__ . '/database/migrations/2021_02_01_000005_create_short_urls_table.php' => database_path('migrations/2021_02_01_000005_create_short_urls_table.php')
        ], ['pharaonic', 'laravel-short-url']);

        // Blade Directive
        Blade::directive('shortURL', function ($data = null) {
            return "<?php echo shortURL($data); ?>";
        });

        // Routes
        $this->loadRoutesFrom(__DIR__ . '/route.php');
    }
}
