<?php

declare(strict_types=1);

namespace Database\GraphQL\Queries;

use Domain\User\Models\User;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class UsersQuery.
 *
 * @property array<string> $attributes
 * @method type
 */
final class UsersQuery extends Query
{
    /**
     * Property $attributes.
     *
     * @var array<string>
     **/
    protected $attributes = [
        'name' => 'users',
        'description' => 'Display the list of all users.'
    ];

    /**
     * Method type.
     *
     * @return \GraphQL\Type\Definition\Type
     **/
    public function type(): Type
    {
        return Type::listOf(GraphQL::type('user'));
    }

    /**
     * Method args.
     *
     * @return array<string,object|string>
     **/
    public function args(): array
    {
        return [
            'column' => [
                'name' => 'column',
                'type' => Type::string(),
            ],
            'direction' => [
                'name' => 'direction',
                'type' => Type::string(),
            ],
        ];
    }

    /**
     * Method resolve.
     *
     * @param mixed $root
     * @param array<string,object|string> $args
     * @return \Illuminate\Database\Eloquent\Collection
     **/
    public function resolve($root, $args): Collection
    {
        return User::orderByUsername(
            column: $args['column'] ?? 'username',
            direction: $args['direction'] ?? 'asc'
        )->get();
    }
}
