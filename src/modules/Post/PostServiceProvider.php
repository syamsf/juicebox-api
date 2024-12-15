<?php

namespace Modules\Post;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Modules\Post\Models\PostModel;
use Modules\Post\Policy\PostPolicy;

class PostServiceProvider extends ServiceProvider {
    public function register(): void {
        $this->loadRoutesFrom(__DIR__ . '/Extras/routes/api.php');
        $this->loadMigrationsFrom(__DIR__ . '/Extras/database/migrations');
    }

    public function boot(): void {
        $this->registerPolicies();
    }

    public function registerPolicies(): void {
        Gate::policy(PostModel::class, PostPolicy::class);
    }
}
