<?php

namespace App\GraphQL\Types\Output;

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
            ]
        ];
    }
}
