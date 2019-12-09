<?php

namespace App\GraphQL\Type\Enum;

use App\Models\City;
use Rebing\GraphQL\Support\Type as GraphQLType;

class CityTypeEnum extends GraphQLType
{
    const TYPE_NAME = 'EnumCityTypesType';

    protected $enumObject = true;

    protected $attributes = [
        'name' => self::TYPE_NAME,
        'description' => 'Types of city',
    ];

    public function __construct()
    {
        $cities = City::all()->pluck('id','slug')->toArray();
        $this->attributes['values'] = $cities;
    }
}

