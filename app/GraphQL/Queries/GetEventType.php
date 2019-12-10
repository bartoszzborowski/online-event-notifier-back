<?php

namespace App\GraphQL\Queries;

use App\GraphQL\BaseMutation;
use App\GraphQL\Types\Output\EventTypeType;
use App\Models\EventType as EventTypeAlias;
use Closure;
use Illuminate\Support\Arr;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

class GetEventType extends BaseMutation
{
    protected $attributes = [
        'name' => 'eventType'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type(EventTypeType::TYPE_NAME));
    }

    public function args(): array
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::int()],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $inputArgs = Arr::get($args, 'input');
        $id = Arr::get($inputArgs, 'id');

        if($id) {
            return EventTypeAlias::whereId($id)->all();
        }

        return EventTypeAlias::all();
    }
}
