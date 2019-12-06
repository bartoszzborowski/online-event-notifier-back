<?php

namespace App\GraphQL\Types\Input;

use GraphQL\Type\Definition\Type;

class UpdateCityType extends EventType
{
    const TYPE_NAME = 'UpdateUserInputType';

    const FIELD_ID = 'id';

    protected $inputObject = true;

    protected $attributes = [
        'name' => self::TYPE_NAME
    ];

    public function fields(): array
    {
        $parentFields = parent::fields();
        $updateType = [self::FIELD_ID => [
            'type' => Type::string()
        ]];
        return array_merge($updateType, $parentFields);
    }
}
