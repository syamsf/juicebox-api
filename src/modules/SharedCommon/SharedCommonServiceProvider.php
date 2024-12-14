<?php

namespace Modules\SharedCommon;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Modules\SharedCommon\Commands\CustomMigrationCommand;
use Modules\SharedCommon\Http\Middleware\CustomAuthMechanism;
use Modules\SharedCommon\Http\Middleware\ForceJsonResponse;
use Modules\SharedCommon\Http\Middleware\HorizonAuth;
use Modules\SharedCommon\Http\Middleware\ValidateHeaderAuth;

class SharedCommonServiceProvider extends ServiceProvider {
    /**
     * @throws \Exception
     */
    public function boot(): void {
        $this->registerCommands();
        $this->registerRateLimit();
        $this->registerSchedule();
        $this->registerEvents();
        $this->registerPolicies();
        $this->registerMiddleware();
    }

    public function register(): void {
//        $this->loadMigrationsFrom(__DIR__ . "/Extras/database/migrations");
//        $this->loadRoutesFrom(__DIR__ . '/Extras/routes/api.php');
    }

    public function registerPolicies(): void {
//        Gate::policy(UserModel::class, UserPolicy::class);
    }

    public function registerCommands(): void {
        if ($this->app->runningInConsole()) {
            $this->commands([
                CustomMigrationCommand::class
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

    /**
     * @throws \Exception
     */
    public function registerMiddleware(): void {
        $router = $this->app->make(Router::class);

        $router->aliasMiddleware("json.response", ForceJsonResponse::class);
        $router->aliasMiddleware("horizon.basic_auth", HorizonAuth::class);
        $router->aliasMiddleware("custom_header_auth", ValidateHeaderAuth::class);
        $router->aliasMiddleware("custom_auth_mechanism", CustomAuthMechanism::class);
    }
}
