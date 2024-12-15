<?php

namespace Modules\Weather;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;
use Modules\Weather\Commands\FetchWeatherCommand;

class WeatherServiceProvider extends ServiceProvider {
    public function register(): void {
        $this->loadRoutesFrom(__DIR__ . '/Extras/routes/api.php');
        $this->mergeConfigFrom(__DIR__ . '/Extras/config/weather.php', 'weather');
    }

    public function boot(): void {
        $this->registerCommands();
        $this->registerSchedule();
    }

   public function registerCommands(): void {
        if ($this->app->runningInConsole()) {
            $this->commands([
                FetchWeatherCommand::class
            ]);
        }
    }

    public function registerSchedule(): void {
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);

            $schedule->command('weather:current')->hourly();
        });
    }
}
