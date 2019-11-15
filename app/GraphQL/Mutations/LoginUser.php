<?php

namespace App\GraphQL\Mutations;
use App\GraphQL\Types\UserLoginType;
use App\GraphQL\Types\UserType;
use App\Repository\UserRepository;
use Illuminate\Support\Arr;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type as GraphqlType;
use Rebing\GraphQL\Support\Mutation;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginUser extends Mutation
{
    const MUTATION_NAME = 'login';

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
            ['name' => 'input', 'type' => GraphQL::type(UserLoginType::TYPE_NAME)]
        ];
    }

//    public function rules(array $args = []): array
//    {
//        $input = GraphQLConstant::INPUT_ARG_NAME . '.';
//
//        return [
//            $input . UserLoginType::FIELD_EMAIL => ['required', 'email'],
//            $input . UserLoginType::FIELD_PASSWORD => ['required']
//        ];
//    }

    /**
     * @param $root
     * @param $args
     * @return User
     * @throws \Exception
     */
    public function resolve($root, $args)
    {
        $args = Arr::get($args, 'input');

        $user = $this->userRepository->findByField('email', $args['email'])->first();

        $credentials = Arr::only($args, [
           'email', 'password'
        ]);

        if ($user && $token = auth()->login($user)) {
            $user['token'] = $token;
            return $user;
        }
        throw new \Exception('Error login');
    }
}
