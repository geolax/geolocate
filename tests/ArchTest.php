<?php

arch('contracts')
    ->expect('Geolax\Geolocate\Contracts')
    ->toBeInterfaces();

arch('data transfer objects are readonly')
    ->expect('Geolax\Geolocate\Data')
    ->toBeReadonly();

arch('exceptions extend base exceptions')
    ->expect('Geolax\Geolocate\Exceptions')
    ->toExtend(Exception::class);

arch('source code does not use debugging functions')
    ->expect(['dd', 'dump', 'ray', 'var_dump', 'print_r'])
    ->not->toBeUsed();
