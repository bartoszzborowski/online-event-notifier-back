<?php

namespace App\GraphQL\Mutations;
use App\Constants\GraphQL as GraphQLConstant;
use App\GraphQL\BaseMutation;
use App\GraphQL\Types\Input\UpdateEventType;
use App\GraphQL\Types\Output\EventType;
use GraphQL\Type\Definition\Type as GraphqlType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use App\Models\Event;
use Illuminate\Support\Arr;

class UpdateEvent extends BaseMutation
{
    const MUTATION_NAME = 'updateEvent';

    protected $attributes = [
        'name' => self::MUTATION_NAME
    ];

    public function type(): GraphqlType
    {
        return GraphQL::type(EventType::TYPE_NAME);
    }

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
<<<<<<< HEAD
        $Event= Event::findOrFail($args['id']);
        if($Event->user_id == JWTAuth::user()->id or JWTAuth::user()->getAdmin()){
            return $Event->update($args); //tu cos musze zmienic aby nie wyrzucalo errora po dobrej zmianie
=======
        /** @var Event $event */
        $event= Event::find($args['id']);
        if($event->update($args)){
             $event->update($args);
             $event->refresh();
             return $event;
>>>>>>> 0e515deffdbe02a046794131be106a8e137031a2
        }else{
            throw new \Exception('Error:1 during update event');
        }
        throw new \Exception('Error:2 during update event');
    }
}
