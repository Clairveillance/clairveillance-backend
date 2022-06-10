<?php

declare(strict_types=1);

namespace Infrastructure\Eloquent\Models\Shared\Traits;

use Illuminate\Database\Eloquent\Factories\Factory;

trait HasFactory
{
    public static function factory(...$parameters)
    {
        // NOTE: We need to implements this Trait to all Models instead of the original one.
        // The main reason to use this custom Trait instead of the original one
        // is that we need to remove the namespace from the Model::class path
        // before we call the Factory static function factoryForModel().
        $class_with_namespace = explode('\\', get_called_class());
        $class_without_namespace = end($class_with_namespace);
        $factory = static::newFactory() ?: Factory::factoryForModel($class_without_namespace);
        return $factory
            ->count(is_numeric($parameters[0] ?? null) ? $parameters[0] : null)
            ->state(is_array($parameters[0] ?? null) ? $parameters[0] : ($parameters[1] ?? []));
    }

    protected static function newFactory()
    {
        //
    }
}
