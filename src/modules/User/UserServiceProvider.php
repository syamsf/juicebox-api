<?php

namespace Modules\User;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Modules\User\Models\UserModel;
use Modules\User\Policy\UserPolicy;

class UserServiceProvider extends ServiceProvider {
    public function boot(): void {
        $this->registerCommands();
        $this->registerRateLimit();
        $this->registerSchedule();
        $this->registerEvents();
        $this->registerPolicies();
    }

    public function register(): void {
        $this->loadRoutesFrom(__DIR__ . '/Extras/routes/api.php');
    }

    public function registerPolicies(): void {
        Gate::policy(UserModel::class, UserPolicy::class);
    }

    public function registerCommands(): void {
        if ($this->app->runningInConsole()) {
            $this->commands([
            ]);
        }
    }

    public function registerRateLimit(): void {
//        RateLimiter::for('custom', function (Request $request) {
//            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
//        });
    }

    public function registerEvents(): void {
//        array_map(function ($listener) {
//            Event::listen(Event::class, $listener);
//        }, [
//            Listener::class
//        ]);
    }

    public function registerSchedule(): void {
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
        });
    }
}
