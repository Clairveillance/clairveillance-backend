<?php

declare(strict_types=1);

namespace Database\GraphQL\Queries;

use Domain\User\Models\User;
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
            'uiid' => [
                'name' => 'uiid',
                'type' => Type::string(),
                'rules' => ['required'],
            ],
        ];
    }

    /**
     * Method resolve.
     *
     * @param mixed $root
     * @param array<string,object|string> $args
     * @return \App\Models\User|null
     **/
    public function resolve($root, $args): ?User
    {
        return User::where('uuid', $args['uiid'])->firstOrFail();
    }
}
