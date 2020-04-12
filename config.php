<?php

$configService = $ioc->resolve(App\Services\ConfigService::class);

$configService->Set('host', '');
$configService->Set('port', '3306');
$configService->Set('db', '');
$configService->Set('user', '');
$configService->Set('password', '');

$configService->Set('domain', '');

$configService->Set('secret', 'strong_key_phrase');

$configService->Set('auth_cookie_name', 'auth');

unset($configService);