<?php

namespace App\GraphQL\Mutations;
use App\Constants\GraphQL as GraphQLConstant;
use App\GraphQL\Types\Input\UpdateEventType;
use Rebing\GraphQL\Support\Facades\GraphQL;

class UpdateEvent extends CreateEvent
{
    const MUTATION_NAME = 'updateEvent';

    protected $attributes = [
        'name' => self::MUTATION_NAME
    ];

    public function args(): array
    {
        return [
            ['name' => GraphQLConstant::INPUT_ARG_NAME, 'type' => GraphQL::type(UpdateEventType::TYPE_NAME)]
        ];
    }

    public function resolve($root, $args)
    {

        throw new \Exception('Error login');
    }
}
