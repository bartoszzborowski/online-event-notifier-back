<?php

namespace App\GraphQL\Types\Input;

use App\GraphQL\Type\Enum\EventTypeEnum;
use App\GraphQL\Type\Enum\CityTypeEnum;
use App\Models\Event;
use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;

class EventType extends GraphQLType
{
    const TYPE_NAME = 'EventInputType';

    const FIELD_ID = 'id';
    const FIELD_ADDRESS = 'address';
    const FIELD_CITY_ID = 'city_id';
    const FIELD_DESCRIPTION = 'description';
    const FIELD_EVENT_DATE = 'event_date';
    const FIELD_EVENT_TYPE = 'event_type';
    const FIELD_FEE = 'fee';
    const FIELD_NAME = 'name';
    const FIELD_USER_ID = 'user_id';

    protected $inputObject = true;

    protected $attributes = [
        'name' => self::TYPE_NAME,
        'model' => Event::class,
    ];

    public function fields(): array
    {
        return [
            self::FIELD_ID => [
                'type' => Type::string()
            ],
            self::FIELD_ADDRESS => [
                'type' => Type::string()
            ],
            self::FIELD_CITY_ID => [
                'type' => GraphQL::type(CityTypeEnum::TYPE_NAME)
            ],
            self::FIELD_DESCRIPTION => [
                'type' => Type::string()
            ],
            self::FIELD_EVENT_DATE => [
                'type' => Type::string()
            ],
            self::FIELD_EVENT_TYPE => [
                'type' => GraphQL::type(EventTypeEnum::TYPE_NAME)
            ],
            self::FIELD_FEE => [
                'type' => Type::float()
            ],
            self::FIELD_NAME => [
                'type' => Type::string()
            ],
            self::FIELD_USER_ID => [
                'type' => Type::int()
            ],
        ];
    }
}
