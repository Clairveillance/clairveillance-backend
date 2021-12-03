<?php

namespace Domain\Shared\Models\Concerns;

use Illuminate\Database\Eloquent\Factories\Factory;

trait HasFactory
{
    /**
     * Get a new factory instance for the model.
     *
     * @param  mixed  $parameters
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public static function factory(...$parameters)
    {
        // NOTE: We need to implements this trait to all Models instead of the original one.
        // We remove the namespace from the Model::class path before we call the Factory static function factoryForModel().
        $class_with_namespace = explode('\\', get_called_class());
        $class_name = end($class_with_namespace);
        $factory = static::newFactory() ?: Factory::factoryForModel($class_name);

        return $factory
            ->count(is_numeric($parameters[0] ?? null) ? $parameters[0] : null)
            ->state(is_array($parameters[0] ?? null) ? $parameters[0] : ($parameters[1] ?? []));
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        //
    }
}
