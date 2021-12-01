<?php

declare(strict_types=1);

namespace Infrastructure\Api\GraphQL\V1\Queries\Users;

use Domain\User\Models\User;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

final class FindUserByUuidQuery extends Query
{
    /**
     * Property $attributes.
     *
     * @var array<string,object|string>
     **/
    protected $attributes = [
        'name' => 'user',
        'description' => 'Display a specified user by uuid.',
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
     * @return array<string,object|string>
     **/
    public function args(): array
    {
        return [
            'uuid' => [
                'name' => 'uuid',
                'type' => Type::nonNull(
                    wrappedType: Type::string(),
                )
            ]
        ];
    }

    /**
     * Method resolve.
     *
     * @param mixed $root
     * @param array<string,object|string> $args
     * @return \App\Models\User
     **/
    public function resolve(mixed $root, array $args): User
    {
        return User::where(function ($query) use ($args) {
            $query->where(
                column: 'uuid',
                operator: '=',
                value: $args['uuid']
            );
        })
            // ->withTrashed()
            ->firstOrFail();
    }
}
