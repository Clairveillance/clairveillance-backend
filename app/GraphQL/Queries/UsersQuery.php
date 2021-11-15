<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\User;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class UsersQuery
 * 
 * @property array<string> $attributes
 * @method type
 */
class UsersQuery extends Query
{
    /**
     * Property $attributes
     * 
     * @var array<string>
     **/
    protected $attributes = [
        'name' => 'users',
    ];

    /**
     * Method type
     * 
     * @return \GraphQL\Type\Definition\Type
     **/
    public function type(): Type
    {
        return Type::listOf(GraphQL::type('user'));
    }

    /**
     * Method resolve
     * 
     * @param mixed $root
     * @param array<string,object|string> $args
     * @return \Illuminate\Database\Eloquent\Collection
     **/
    public function resolve($root, $args): Collection
    {
        return User::all();
    }
}
