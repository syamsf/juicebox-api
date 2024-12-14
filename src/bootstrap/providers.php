<?php

return [
    App\Providers\AppServiceProvider::class,
    Modules\SharedCommon\SharedCommonServiceProvider::class,
    Modules\User\UserServiceProvider::class,
    Modules\CorrelationId\CorrelationIdServiceProvider::class,
];
