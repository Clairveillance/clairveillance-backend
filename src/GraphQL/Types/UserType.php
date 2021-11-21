<?php

declare(strict_types=1);

namespace GraphQL\Types;

use Domain\Shared\Models\User;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

/**
 * Class UserType.
 *
 * @property array<string,object|string> $attributes
 * @method fields
 */
class UserType extends GraphQLType
{
    /**
     * Property $attributes.
     *
     * @var array<string,object|string>
     **/
    protected $attributes = [
        'name' => 'User',
        'description' => 'Details about a user',
        'model' => User::class,
    ];

    /**
     * Method fields.
     *
     * @return array<string,object|string>
     **/
    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Id of the user',
            ],
            'uuid' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Uuid of the user',
            ],
            // 'username' => [
            // 'type' => Type::nonNull(Type::string()),
            // 'description' => 'The screen name of the user',
            // ],
            'firstname' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The first name of the user',
            ],
            'lastname' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The last name of the user',
            ],
            'avatar' => [
                'type' => Type::string(),
                'description' => 'The avatar url of the user',
            ],
            'description' => [
                'type' => Type::string(),
                'description' => 'Short description of the user',
            ],
            'company' => [
                'type' => Type::string(),
                'description' => 'The company name of the user',
            ],
            'website' => [
                'type' => Type::string(),
                'description' => 'The website url of the user',
            ],
            'country' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The country of origin of the user',
            ],
            'state' => [
                'type' => Type::string(),
                'description' => 'The state/region of the user',
            ],
            'city' => [
                'type' => Type::string(),
                'description' => 'The city of the user',
            ],
            'zip' => [
                'type' => Type::string(),
                'description' => 'The zip/postcode of the user',
            ],
            'address' => [
                'type' => Type::string(),
                'description' => 'The address of the user',
            ],
            'address_2' => [
                'type' => Type::string(),
                'description' => 'The address (second line) of the user',
            ],
            'phone' => [
                'type' => Type::string(),
                'description' => 'The phone number of the user',
            ],
            'theme' => [
                'type' => Type::string(),
                'description' => 'The theme specified by the user',
            ],
            'language' => [
                'type' => Type::string(),
                'description' => 'The language specified by the the user',
            ],
            'email' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The email address of the user',
            ],
            'password' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The encrypted password of the user',
            ],
            'remember_token' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The remember token of the user',
            ],
            'created_at' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The date and time of the creation of the user',
            ],
            'updated_at' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The date and time of the last update of the user',
            ],
            'email_verified_at' => [
                'type' => Type::string(),
                'description' => 'The date and time of the email validation of the user',
            ],
        ];
    }
}
