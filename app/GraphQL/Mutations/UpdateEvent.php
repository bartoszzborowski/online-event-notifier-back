<?php

namespace App\GraphQL\Mutations;
use App\Constants\GraphQL as GraphQLConstant;
use App\GraphQL\Types\Input\UpdateEventType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use App\Models\Event;
use Illuminate\Support\Arr;
use Tymon\JWTAuth\Facades\JWTAuth;

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

    public function rules(array $args = []): array
    {
        $input = GraphQLConstant::INPUT_ARG_NAME . '.';

        return [
            $input . UpdateEventType::FIELD_ID => ['required'],
        ];
    }
    
    public function resolve($root, $args)
    {

        $args = Arr::get($args, 'input');
        $Event= Event::find($args['id']);
        if($Event->user_id == JWTAuth::user()->id or JWTAuth::user()->getAdmin()){
            return $Event->update($args); //tu cos musze zmienic aby nie wyrzucalo errora po dobrej zmianie
        }else{
            throw new \Exception('Error:1 during update event');
        }
        throw new \Exception('Error:2 during update event');
    }
}
