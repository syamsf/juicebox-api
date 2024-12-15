<?php

return [
    App\Providers\AppServiceProvider::class,
    Modules\SharedCommon\SharedCommonServiceProvider::class,
    Modules\User\UserServiceProvider::class,
    Modules\Weather\WeatherServiceProvider::class,
    Modules\Post\PostServiceProvider::class,
    Modules\CorrelationId\CorrelationIdServiceProvider::class,
];
