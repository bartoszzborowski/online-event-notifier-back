<?php

namespace App\GraphQL\Queries;

use App\GraphQL\BaseMutation;
use App\GraphQL\Types\Output\UserType;
use Closure;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

class GetUserByToken extends BaseMutation
{
    protected $attributes = [
        'name' => 'userByToken'
    ];

    public function type(): Type
    {
        return GraphQL::type(UserType::TYPE_NAME);
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        if($this->currentUser) {
            return $this->currentUser;
        } else {
            throw new \Exception('User not found');
        }
    }
}
