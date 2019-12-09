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
        $inputArgs = Arr::get($args, 'input');
        $id = Arr::get($inputArgs, 'id');
        $user = Arr::get($inputArgs, 'user');

        if($user) {
            return Event::whereUserId($this->currentUser->id)->all();
        }

        if($id) {
            return Event::whereId($id)->all();
        }

        return Event::all();
    }
}
