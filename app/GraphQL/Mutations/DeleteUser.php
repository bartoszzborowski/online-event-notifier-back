<?php

namespace App\GraphQL\Mutations;
use App\Repository\UserRepository;
use GraphQL\Type\Definition\Type as GraphqlType;
use Rebing\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\Type;

class DeleteUser extends Mutation
{
    const MUTATION_NAME = 'deleteUsers';

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
        return GraphqlType::int();
    }

    public function args(): array
    {
        return [
            ['name' => 'users_id', 'type' => GraphqlType::listOf(Type::int())]
        ];
    }

    public function rules(array $args = []): array
    {
        return [
            'users_id' => ['required'],
        ];
    }

    public function resolve($root, $args)
    {

        throw new \Exception('Error login');
    }
}
