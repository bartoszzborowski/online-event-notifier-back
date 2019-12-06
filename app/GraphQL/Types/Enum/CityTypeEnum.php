<?php

namespace App\GraphQL\Type\Enum;

use Rebing\GraphQL\Support\Type as GraphQLType;

class CityTypeEnum extends GraphQLType
{
    const TYPE_NAME = 'EnumCityTypesType';

    protected $enumObject = true;

    protected $attributes = [
        'name' => self::TYPE_NAME,
        'description' => 'Types of city',
        'values' => 
        // EventType::all()->pluck('id','name')->flip()->toArray(),
         [   
            'Warszawa'=>'1',
           'Krakow'=>'2'
        ]
    ];
}

