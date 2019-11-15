<?php

namespace App\GraphQL\Types;

use App\Models\User;
use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;

class UserLoginType extends GraphQLType
{
    const TYPE_NAME = 'UserLoginInputType';

    const FIELD_EMAIL = 'email';
    const FIELD_PASSWORD = 'password';

    protected $inputObject = true;

    protected $attributes = [
        'name'        => self::TYPE_NAME,
        'description' => 'A user',
        'model'       => User::class,
    ];

    public function fields(): array
    {
        return [
            'email' => [
                'type' => Type::string()
            ],
            'password' => [
                'type' => Type::string()
            ]
        ];
    }
}
