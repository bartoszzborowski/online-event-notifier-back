<?php

namespace App\GraphQL\Queries;

use App\GraphQL\BaseMutation;
use App\GraphQL\Types\Output\EventType;
use App\Models\Event;
use Closure;
use Illuminate\Support\Arr;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

class GetEvents extends BaseMutation
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
            'id' => ['name' => 'id', 'type' => Type::int()],
            'user' => ['name' => 'byUser', 'type' => Type::boolean()],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $id = Arr::get($args, 'id');
        $user = Arr::get($args, 'byUser');
        
        if($user) {
            return Event::whereUserId($this->currentUser->id)->get();
        }

        if($id) {
            return Event::whereId($id)->get();
        }

        return Event::all();
    }
}
