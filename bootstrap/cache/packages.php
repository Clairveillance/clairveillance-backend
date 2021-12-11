<?php

return [
    'barryvdh/laravel-debugbar' => [
        'providers' => [
            0 => 'Barryvdh\\Debugbar\\ServiceProvider',
        ],
        'aliases' => [
            'Debugbar' => 'Barryvdh\\Debugbar\\Facade',
        ],
    ],
    'darkaonline/l5-swagger' => [
        'providers' => [
            0 => 'L5Swagger\\L5SwaggerServiceProvider',
        ],
        'aliases' => [
            'L5Swagger' => 'L5Swagger\\L5SwaggerFacade',
        ],
    ],
    'facade/ignition' => [
        'providers' => [
            0 => 'Facade\\Ignition\\IgnitionServiceProvider',
        ],
        'aliases' => [
            'Flare' => 'Facade\\Ignition\\Facades\\Flare',
        ],
    ],
    'fruitcake/laravel-cors' => [
        'providers' => [
            0 => 'Fruitcake\\Cors\\CorsServiceProvider',
        ],
    ],
    'laravel/sail' => [
        'providers' => [
            0 => 'Laravel\\Sail\\SailServiceProvider',
        ],
    ],
    'laravel/sanctum' => [
        'providers' => [
            0 => 'Laravel\\Sanctum\\SanctumServiceProvider',
        ],
    ],
    'laravel/tinker' => [
        'providers' => [
            0 => 'Laravel\\Tinker\\TinkerServiceProvider',
        ],
    ],
    'nesbot/carbon' => [
        'providers' => [
            0 => 'Carbon\\Laravel\\ServiceProvider',
        ],
    ],
    'nunomaduro/collision' => [
        'providers' => [
            0 => 'NunoMaduro\\Collision\\Adapters\\Laravel\\CollisionServiceProvider',
        ],
    ],
    'nuwave/lighthouse' => [
        'aliases' => [
            'graphql' => 'Nuwave\\Lighthouse\\GraphQL',
        ],
        'providers' => [
            0 => 'Nuwave\\Lighthouse\\LighthouseServiceProvider',
            1 => 'Nuwave\\Lighthouse\\Auth\\AuthServiceProvider',
            2 => 'Nuwave\\Lighthouse\\GlobalId\\GlobalIdServiceProvider',
            3 => 'Nuwave\\Lighthouse\\OrderBy\\OrderByServiceProvider',
            4 => 'Nuwave\\Lighthouse\\Pagination\\PaginationServiceProvider',
            5 => 'Nuwave\\Lighthouse\\Scout\\ScoutServiceProvider',
            6 => 'Nuwave\\Lighthouse\\SoftDeletes\\SoftDeletesServiceProvider',
            7 => 'Nuwave\\Lighthouse\\Validation\\ValidationServiceProvider',
        ],
    ],
    'spatie/laravel-query-builder' => [
        'providers' => [
            0 => 'Spatie\\QueryBuilder\\QueryBuilderServiceProvider',
        ],
    ],
];
