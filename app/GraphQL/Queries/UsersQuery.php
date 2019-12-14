<?php

namespace App\GraphQL\Queries;

use App\GraphQL\Types\Output\UserType;
use App\Models\User;
use Closure;
use GraphQL\Error\Error;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Arr;
use Rebing\GraphQL\Support\Query;
use Tymon\JWTAuth\Facades\JWTAuth;

class UsersQuery extends Query
{
    protected $attributes = [
        'name' => 'users'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type(UserType::TYPE_NAME));
    }

    public function args(): array
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::Int()],
            'email' => ['name' => 'email', 'type' => Type::string()]
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {

        $id = Arr::get($args, 'userId');


        if ((!empty(JWTAuth::user()) and (JWTAuth::user()->getAdmin())) and isset($args['email'])) {
            return User::whereEmail($args['email'])->get();
        }

        if((!empty(JWTAuth::user()) and (JWTAuth::user()->getAdmin())) and $id){
             return User::whereId($id)->get();
        }

        if(!empty(JWTAuth::user()) and ( JWTAuth::user()->getAdmin())){
            return User::all();
        }

        return new Error("You shouldn't be here");
    }
}
