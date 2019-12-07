<?php

namespace App\GraphQL\Mutations;

use App\Constants\GraphQL as GraphQLConstant;
use App\GraphQL\Types\Input\UpdateUserType;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Tymon\JWTAuth\Facades\JWTAuth;

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
        $args = Arr::get($args, 'input');
        $user = User::find($args['users_id'])->first();
        // dd($user);
        if($user->id == JWTAuth::user()->id or JWTAuth::user()->getAdmin()){
              return $user->update($args);
        }else{
            throw new \Exception('Error:1 during update user');
        }
        throw new \Exception('Error:2 update user ');
    }
}
