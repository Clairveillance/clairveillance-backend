<?php return array (
  'barryvdh/laravel-debugbar' => 
  array (
    'providers' => 
    array (
      0 => 'Barryvdh\\Debugbar\\ServiceProvider',
    ),
    'aliases' => 
    array (
      'Debugbar' => 'Barryvdh\\Debugbar\\Facades\\Debugbar',
    ),
  ),
  'barryvdh/laravel-ide-helper' => 
  array (
    'providers' => 
    array (
      0 => 'Barryvdh\\LaravelIdeHelper\\IdeHelperServiceProvider',
    ),
  ),
  'darkaonline/l5-swagger' => 
  array (
    'providers' => 
    array (
      0 => 'L5Swagger\\L5SwaggerServiceProvider',
    ),
    'aliases' => 
    array (
      'L5Swagger' => 'L5Swagger\\L5SwaggerFacade',
    ),
  ),
  'facade/ignition' => 
  array (
    'providers' => 
    array (
      0 => 'Facade\\Ignition\\IgnitionServiceProvider',
    ),
    'aliases' => 
    array (
      'Flare' => 'Facade\\Ignition\\Facades\\Flare',
    ),
  ),
  'fruitcake/laravel-cors' => 
  array (
    'providers' => 
    array (
      0 => 'Fruitcake\\Cors\\CorsServiceProvider',
    ),
  ),
  'laravel/sail' => 
  array (
    'providers' => 
    array (
      0 => 'Laravel\\Sail\\SailServiceProvider',
    ),
  ),
  'laravel/sanctum' => 
  array (
    'providers' => 
    array (
      0 => 'Laravel\\Sanctum\\SanctumServiceProvider',
    ),
  ),
  'laravel/tinker' => 
  array (
    'providers' => 
    array (
      0 => 'Laravel\\Tinker\\TinkerServiceProvider',
    ),
  ),
  'nesbot/carbon' => 
  array (
    'providers' => 
    array (
      0 => 'Carbon\\Laravel\\ServiceProvider',
    ),
  ),
  'nunomaduro/collision' => 
  array (
    'providers' => 
    array (
      0 => 'NunoMaduro\\Collision\\Adapters\\Laravel\\CollisionServiceProvider',
    ),
  ),
  'nuwave/lighthouse' => 
  array (
    'aliases' => 
    array (
      'graphql' => 'Nuwave\\Lighthouse\\GraphQL',
    ),
    'providers' => 
    array (
      0 => 'Nuwave\\Lighthouse\\LighthouseServiceProvider',
      1 => 'Nuwave\\Lighthouse\\Auth\\AuthServiceProvider',
      2 => 'Nuwave\\Lighthouse\\GlobalId\\GlobalIdServiceProvider',
      3 => 'Nuwave\\Lighthouse\\OrderBy\\OrderByServiceProvider',
      4 => 'Nuwave\\Lighthouse\\Pagination\\PaginationServiceProvider',
      5 => 'Nuwave\\Lighthouse\\Scout\\ScoutServiceProvider',
      6 => 'Nuwave\\Lighthouse\\SoftDeletes\\SoftDeletesServiceProvider',
      7 => 'Nuwave\\Lighthouse\\Validation\\ValidationServiceProvider',
    ),
  ),
  'spatie/laravel-query-builder' => 
  array (
    'providers' => 
    array (
      0 => 'Spatie\\QueryBuilder\\QueryBuilderServiceProvider',
    ),
  ),
);