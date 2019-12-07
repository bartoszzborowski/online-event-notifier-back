<?php

namespace App\GraphQL\Mutations;

use App\Models\User;
use App\Repository\UserRepository;
use Carbon\Carbon;
use GraphQL\Type\Definition\Type as GraphqlType;
use Rebing\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

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

        $user = User::find($args['users_id'])->first();
        // dd($user);
        if($user->id == JWTAuth::user()->id or JWTAuth::user()->getAdmin()){
              return $user->update([
                    'name' =>'Usuniety',
                    'surname' => 'Usuniety',
                    'email' => 'Usuniety@'.Carbon::now()->toDateTimeString().'.pl',
                    'base_city' => $user->base_city,
                    'admin'=> 0,
                    'password' => Hash::make('usuniety123'),
                  ]
              );
        }else{
            throw new \Exception('Error:1 during delete user');
        }
        throw new \Exception('Error:2 delete user ');
    }
}
