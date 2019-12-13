<?php

namespace App\GraphQL\Types\Output;

use App\Models\City;
use App\Models\Event;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class EventType extends GraphQLType
{
    const TYPE_NAME = 'EventType';

    protected $attributes = [
        'name' => self::TYPE_NAME,
        'model' => Event::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
            ],
            'event_type' => [
                'type' => Type::string(),
            ],
            'city_id' => [
                'type' => Type::string(),
            ],
            'user_id' => [
                'type' => Type::string(),
            ],
            'address' => [
                'type' => Type::string(),
            ],
            'name' => [
                'type' => Type::string(),
            ],
            'description' => [
                'type' => Type::string(),
            ],
            'fee' => [
                'type' => Type::string(),
            ],
            'event_date' => [
                'type' => Type::string(),
            ],
            'attendance_counter' => [
                'type' => Type::int(),
            ]

        ];
    }

    protected function resolveAttendanceCounterField($root, $args)
    {
        return $root->members->count() ?? 0;
    }

    protected function resolveEventTypeField($root, $args)
    {
        return \App\Models\EventType::whereId($root->event_type)->pluck('name')->first();
    }

    protected function resolveCityIdField($root, $args)
    {
        return City::whereId($root->city_id)->pluck('slug')->first();
    }
}
