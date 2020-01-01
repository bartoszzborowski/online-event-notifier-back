<?php

namespace App\GraphQL\Mutations;
use App\Constants\GraphQL as GraphQLConstant;
use App\GraphQL\BaseMutation;
use App\GraphQL\Types\Input\UpdateEventType;
use App\GraphQL\Types\Output\EventType;
use Carbon\Carbon;
use GraphQL\Error\Error;
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
        /** @var Event $event */
        $event = Event::find($args['id']);
        if(!empty($args['event_date'])) {
            $args['event_date'] = Carbon::parse($args['event_date'])->setTimezone('UTC')->format('Y-m-d H:i:s');
        }

        if($event->update($args)){
             $event->update($args);
             $event->refresh();
             return $event;
        }else{
            return new Error('Error:1 during update event');
        }
    }
}
