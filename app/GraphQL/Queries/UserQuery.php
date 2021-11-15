<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\User;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class UserQuery
 * 
 * @property array<string> $attributes
 * @method type
 */
class UserQuery extends Query
{
    /**
     * Property $attributes
     * 
     * @var array<string>
     **/
    protected $attributes = [
        'name' => 'user',
    ];

    /**
     * Method type
     * 
     * @return \GraphQL\Type\Definition\Type
     **/
    public function type(): Type
    {
        return GraphQL::type('user');
    }

    /**
     * Method args
     * 
     * @return array<string,object|string>
     **/
    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::int(),
                'rules' => ['required']
            ],
        ];
    }

    /**
     * Method resolve
     * 
     * @param mixed $root
     * @param array<string,object|string> $args
     * @return \App\Models\User|null
     **/
    public function resolve($root, $args): ?User
    {
        return User::findOrFail($args['id']);
    }
}
