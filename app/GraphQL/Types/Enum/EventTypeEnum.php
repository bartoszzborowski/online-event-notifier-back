<?php

namespace App\GraphQL\Type\Enum;

use Rebing\GraphQL\Support\Type as GraphQLType;
use App\Models\EventType;

class EventTypeEnum extends GraphQLType
{
    const TYPE_NAME = 'EnumEventTypesType';

    protected $enumObject = true;

    protected $attributes = [
        'name' => self::TYPE_NAME,
        'description' => 'Types of employer interview feeling',
        'values' => 
        // EventType::all()->pluck('id','name')->flip()->toArray(),
         [   
            'pop'=>'1',
           'rock'=>'2'
        ]
    ];
}

