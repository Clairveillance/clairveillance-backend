<?php

declare(strict_types=1);

namespace Database\GraphQL\Queries;

use Domain\User\Models\User;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Illuminate\Database\Eloquent\Collection;

final class UsersQuery extends Query
{
    /**
     * Property $attributes.
     *
     * @var array<string,object|string>
     **/
    protected $attributes = [
        'name' => 'users',
        'description' => 'Display the list of all users. Find by firstname, lastname, company, country, state, city, theme and/or language. Order by column (default: username) and/or direction (default: asc).'
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
            'firstname' => [
                'name' => 'firstname',
                'type' => Type::string(),
            ],
            'lastname' => [
                'name' => 'lastname',
                'type' => Type::string(),
            ],
            'company' => [
                'name' => 'company',
                'type' => Type::string(),
            ],
            'country' => [
                'name' => 'country',
                'type' => Type::string(),
            ],
            'state' => [
                'name' => 'state',
                'type' => Type::string(),
            ],
            'city' => [
                'name' => 'city',
                'type' => Type::string(),
            ],
            'theme' => [
                'name' => 'theme',
                'type' => Type::string(),
            ],
            'language' => [
                'name' => 'language',
                'type' => Type::string(),
            ],
            'column' => [
                'name' => 'column',
                'type' => Type::string(),
                'rules' => ['nullable'],
            ],
            'direction' => [
                'name' => 'direction',
                'type' => Type::string(),
                'rules' => ['nullable'],
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
        return User::where(function ($query) use ($args) {
            if (isset($args['firstname'])) {
                $query->where('firstname', $args['firstname']);
            }
            if (isset($args['lastname'])) {
                $query->where('lastname', $args['lastname']);
            }
            if (isset($args['company'])) {
                $query->where('company', $args['company']);
            }
            if (isset($args['country'])) {
                $query->where('country', $args['country']);
            }
            if (isset($args['state'])) {
                $query->where('state', $args['state']);
            }
            if (isset($args['city'])) {
                $query->where('city', $args['city']);
            }
            if (isset($args['theme'])) {
                $query->where('theme', $args['theme']);
            }
            if (isset($args['language'])) {
                $query->where('language', $args['language']);
            }
        })->orderByUsername(
            column: $args['column'] ?? 'username',
            direction: $args['direction'] ?? 'asc'
        )->get();
    }
}
