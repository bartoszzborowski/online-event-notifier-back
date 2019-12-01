<?php

namespace App\GraphQL\Queries;

use App\GraphQL\Types\Output\EventType;
use App\Models\User;
use Closure;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

class GetEvents extends Query
{
    protected $attributes = [
        'name' => 'events'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type(EventType::TYPE_NAME));
    }

    public function args(): array
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::string()],
            'email' => ['name' => 'email', 'type' => Type::string()]
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
//        if (isset($args['id'])) {
//            return User::where('id' , $args['id'])->get();
////        }
////
////        if (isset($args['email'])) {
////            return User::where('email', $args['email'])->get();
////        }

        return User::all();
    }
}
