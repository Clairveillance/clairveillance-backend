<?php

declare(strict_types=1);

namespace Database\GraphQL\Queries;

use Domain\User\Models\User;
use Exception;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

/**
 * Class UserQuery.
 *
 * @property array<string> $attributes
 * @method type
 */
final class UserQuery extends Query
{
    /**
     * Property $attributes.
     *
     * @var array<string>
     **/
    protected $attributes = [
        'name' => 'user',
    ];

    /**
     * Method type.
     *
     * @return \GraphQL\Type\Definition\Type
     **/
    public function type(): Type
    {
        return GraphQL::type('user');
    }

    /**
     * Method args.
     *
     * @return array<string,object|string>
     **/
    public function args(): array
    {
        return [
            'uuid' => [
                'name' => 'uuid',
                'type' => Type::string(),
            ],
            'username' => [
                'name' => 'username',
                'type' => Type::string(),
            ],
            'email' => [
                'name' => 'email',
                'type' => Type::string(),
            ],
        ];
    }

    /**
     * Method resolve.
     *
     * @param mixed $root
     * @param array<string,object|string> $args
     * @return \App\Models\User
     **/
    public function resolve($root, $args): User
    {
        return User::where(function ($query) use ($args) {
            if (isset($args['uuid'])) {
                $query->where('uuid', $args['uuid']);
            }
            if (isset($args['username'])) {
                $query->where('username', $args['username']);
            }
            if (isset($args['email'])) {
                $query->where('email', $args['email']);
            }
        })->firstOrFail();
    }
}
