<?php

declare(strict_types=1);

Broadcast::channel('adminarea-tenants-index', function ($user) {
    return $user->can('list', app('rinvex.tenants.tenant'));
}, ['guards' => ['admin']]);
