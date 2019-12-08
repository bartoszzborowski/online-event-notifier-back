<?php

namespace App\GraphQL\Types\Input;

use App\Models\User;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;
use App\GraphQL\Type\Enum\CityTypeEnum;

class UserType extends GraphQLType
{
    const TYPE_NAME = 'UserInputType';

    const FIELD_EMAIL = 'email';
    const FIELD_PASSWORD = 'password';
    const FIELD_NAME = 'name';
    const FIELD_SURNAME= 'surname';
    const FIELD_BASE_CITY = 'base_city';
    const FIELD_ADMIN = 'admin';

    protected $inputObject = true;

    protected $attributes = [
        'name' => self::TYPE_NAME,
        'model' => User::class,
    ];

    public function fields(): array
    {
        return [
            self::FIELD_EMAIL => [
                'type' => Type::string()
            ],
            self::FIELD_PASSWORD => [
                'type' => Type::string()
            ],
            self::FIELD_NAME => [
                'type' => Type::string()
            ],
            self::FIELD_SURNAME => [
                'type' => Type::string()
            ],
            self::FIELD_BASE_CITY => [
                // 'type' => Type::int()
                'type' => GraphQL::type(CityTypeEnum::TYPE_NAME)
            ],
            self::FIELD_ADMIN => [
                'type' => Type::boolean()
            ],
        ];
    }
}
