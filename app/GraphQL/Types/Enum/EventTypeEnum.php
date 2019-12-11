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
    ];

    public function __construct()
    {
         $evensType = EventType::all()->pluck('id','name')->toArray();
         $this->attributes['values'] = $evensType;
    }
}

