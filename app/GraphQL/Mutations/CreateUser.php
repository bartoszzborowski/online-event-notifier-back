<?php

namespace App\GraphQL\Mutations;

use App\Constants\GraphQL as GraphQLConstant;
use App\GraphQL\Types\Input\UserType as UserInputType;
use App\GraphQL\Types\Output\UserType;
use App\Repository\UserRepository;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type as GraphqlType;
use Rebing\GraphQL\Support\Mutation;

class CreateUser extends Mutation
{
    const MUTATION_NAME = 'createUser';

    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    protected $attributes = [
        'name' => self::MUTATION_NAME
    ];

    public function type(): GraphqlType
    {
        return GraphQL::type(UserType::TYPE_NAME);
    }

    public function args(): array
    {
        return [
            [
                'name' => GraphQLConstant::INPUT_ARG_NAME,
                'type' => GraphQL::type(UserInputType::TYPE_NAME)]
        ];
    }

    public function rules(array $args = []): array
    {
        $input = GraphQLConstant::INPUT_ARG_NAME . '.';

        return [
            $input . UserInputType::FIELD_NAME => ['required'],
            $input . UserInputType::FIELD_SURNAME => ['required'],
            $input . UserInputType::FIELD_EMAIL => ['required', 'email'],
            $input . UserInputType::FIELD_BASE_CITY => ['required'],
            $input . UserInputType::FIELD_PASSWORD => ['required']
        ];
    }

    public function resolve($root, $args)
    {

        throw new \Exception('Register not successful');
    }
}
