<?php

namespace App\GraphQL\Mutations;

use App\Constants\GraphQL as GraphQLConstant;
use App\GraphQL\Types\Input\UpdateUserType;
use Rebing\GraphQL\Support\Facades\GraphQL;

class UpdateUser extends CreateUser
{
    const MUTATION_NAME = 'updateUser';

    protected $attributes = [
        'name' => self::MUTATION_NAME
    ];

    public function args(): array
    {
        return [
            ['name' => GraphQLConstant::INPUT_ARG_NAME, 'type' => GraphQL::type(UpdateUserType::TYPE_NAME)]
        ];
    }

    public function resolve($root, $args)
    {
        throw new \Exception('Register not successful');
    }
}
