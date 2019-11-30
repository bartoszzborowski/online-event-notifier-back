<?php

namespace App\GraphQL\Types\Output;

use App\Models\Event;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Auth;
use Rebing\GraphQL\Support\Type as GraphQLType;

class EventType extends GraphQLType
{
    const TYPE_NAME = 'EventType';

    protected $attributes = [
        'name' => self::TYPE_NAME,
        'model' => Event::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The id of the user',
            ],
            'email' => [
                'type' => Type::string(),
                'description' => 'The email of user',
                'privacy' => function (array $args): bool {
                    return $args['id'] == Auth::id();
                }
            ],
            'token' => [
                'type' => Type::string(),]
        ];
    }
}
