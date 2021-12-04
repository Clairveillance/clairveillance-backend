<?php

declare(strict_types=1);

namespace App\GraphQL\V1\Queries\Users;

use Domain\User\Models\User;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

final class UserQuery extends Query
{
    /**
     * Property $attributes.
     *
     * @var array<string,object|string>
     **/
    protected $attributes = [
        'name' => 'user',
        'description' => 'Display a specified user. Find by uuid, username and/or email.',
    ];

    /**
     * Method type.
     *
     * @return \GraphQL\Type\Definition\Type
     **/
    public function type(): Type
    {
        return GraphQL::type(
            name: 'user',
            fresh: false
        );
    }

    /**
     * Method args.
     *
     * @return array<int|string,array|string|FieldDefinition|Field>
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
     * @param array<int|string,array|string|FieldDefinition|Field> $args
     * @return \Domain\User\Models\User
     **/
    public function resolve(mixed $root, array $args): User
    {
        return User::where(function ($query) use ($args) {
            if (isset($args['uuid'])) {
                $query->where(
                    column: 'uuid',
                    operator: '=',
                    value: $args['uuid']
                );
            }
            if (isset($args['username'])) {
                $query->where(
                    column: 'username',
                    operator: '=',
                    value: $args['username']
                );
            }
            if (isset($args['email'])) {
                $query->where(
                    column: 'email',
                    operator: '=',
                    value: $args['email']
                );
            }
        })
            // ->withTrashed()
            ->firstOrFail();
    }
}
