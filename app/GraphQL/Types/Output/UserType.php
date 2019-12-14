<?php

namespace App\GraphQL\Types\Output;

use App\Models\User;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class UserType extends GraphQLType
{
    const TYPE_NAME = 'UserType';

    protected $attributes = [
        'name' => self::TYPE_NAME,
        'description' => 'A user',
        'model' => User::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The id of the user',
            ],
            'email' => [
                'type' => Type::string(),
                'description' => 'The email of user',
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'The name of user',
            ],
            'surname' => [
                'type' => Type::string(),
                'description' => 'The surname of user',
            ],
            'admin' => [
                'type' => Type::boolean()
            ],
            'token' => [
                'type' => Type::string(),
            ],
            'events' => [
                'type' => Type::listOf(GraphQL::type(EventType::TYPE_NAME)),
            ]
        ];
    }

    protected function resolveEmailField($root, $args)
    {
        return strtolower($root->email);
    }
}
