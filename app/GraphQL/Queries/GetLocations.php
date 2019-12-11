<?php

namespace App\GraphQL\Queries;

use App\GraphQL\BaseMutation;
use App\GraphQL\Types\Output\LocationType;
use App\Models\City;
use Closure;
use Illuminate\Support\Arr;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

class GetLocations extends BaseMutation
{
    protected $attributes = [
        'name' => 'locations'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type(LocationType::TYPE_NAME));
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
            return City::whereId($id)->all();
        }

        return City::all();
    }
}
