<?php

namespace App\GraphQL\Types;

use App\Models\User;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Auth;
use Rebing\GraphQL\Support\Type as GraphQLType;

class UserType extends GraphQLType
{
    const TYPE_NAME = 'UserType';

    protected $attributes = [
        'name'        => self::TYPE_NAME,
        'description' => 'A user',
        'model'       => User::class,
    ];

    public function fields(): array
    {
        return [
            'id'    => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'The id of the user',
            ],
            'email' => [
                'type'        => Type::string(),
                'description' => 'The email of user',
                'privacy'     => function (array $args): bool {
                    return $args['id'] == Auth::id();
                }
            ],
            'token'  => [
                'type'        => Type::string(),]
        ];
    }

    protected function resolveEmailField($root, $args)
    {
        return strtolower($root->email);
    }
}
