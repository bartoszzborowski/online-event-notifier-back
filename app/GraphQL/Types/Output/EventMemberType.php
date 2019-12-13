<?php

namespace App\GraphQL\Types\Output;

use App\Models\Event;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class EventMemberType extends GraphQLType
{
    const TYPE_NAME = 'EventMemberType';

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
            'user_id' => [
                'type' => Type::int(),
            ],
            'event_id' => [
                'type' => Type::int(),
            ],
        ];
    }
}
