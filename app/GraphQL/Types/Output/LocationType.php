<?php

namespace App\GraphQL\Types\Output;

use App\Models\Event;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class LocationType extends GraphQLType
{
    const TYPE_NAME = 'LocationType';

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
            'name' => [
                'type' => Type::string(),
            ],
            'slug' => [
                'type' => Type::string(),
            ],
        ];
    }
}
