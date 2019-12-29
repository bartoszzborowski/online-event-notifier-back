<?php

namespace App\GraphQL\Queries;

use App\GraphQL\BaseMutation;
use App\GraphQL\Type\Enum\CityTypeEnum;
use App\GraphQL\Type\Enum\EventTypeEnum;
use App\GraphQL\Types\Output\EventType;
use App\Repository\EventRepository;
use Closure;
use Illuminate\Support\Arr;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

class SearchEvents extends BaseMutation
{
    protected $attributes = [
        'name' => 'searchEvents'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type(EventType::TYPE_NAME));
    }

    public function args(): array
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::string()],
            'name' => ['name' => 'name', 'type' => Type::string()],
            'date' => ['name' => 'date', 'type' => Type::string()],
            'city_id' => ['name' => 'city_id', 'type' => GraphQL::type(CityTypeEnum::TYPE_NAME)],
            'event_type' => ['name' => 'event_type', 'type' => GraphQL::type(EventTypeEnum::TYPE_NAME)],
            'entry_fee' => ['name' => 'entry_fee', 'type' => Type::float()],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        /** @var EventRepository $eventRepository */
        $eventRepository = app(EventRepository::class);
        $id = Arr::get($args, 'id');
        $name = Arr::get($args, 'name');
        $date = Arr::get($args, 'date');
        $cityId= Arr::get($args, 'city_id');
        $evenType = Arr::get($args, 'event_type');
        $entryFee = Arr::get($args, 'entry_fee');
        $where = [];

        if($id) {
            $where['id'] = $id;
        }

        if($name) {
            $where[] = ['name', 'like', (string)($name)];
        }

        if($date) {
            $where['event_date'] = $date;
        }

        if($cityId) {
            $where['city_id'] = $cityId;
        }

        if($evenType) {
            $where['event_type'] = $evenType;
        }

        if($entryFee) {
            $where['fee'] = $entryFee;
        }

        return $eventRepository->findWhere($where);
    }
}
