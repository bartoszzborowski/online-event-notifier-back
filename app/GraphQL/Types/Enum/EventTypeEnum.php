<?php

namespace App\GraphQL\Type\Enum;

use Rebing\GraphQL\Support\Type as GraphQLType;

class EventTypeEnum extends GraphQLType
{
    const TYPE_NAME = 'EnumEventTypesType';

    protected $enumObject = true;

    protected $attributes = [
        'name' => self::TYPE_NAME,
        'description' => 'Types of employer interview feeling',
        'values' => [
            'pop',
            'rock'
        ]
    ];
}

