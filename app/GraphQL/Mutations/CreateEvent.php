<?php

namespace App\GraphQL\Mutations;
use App\Constants\GraphQL as GraphQLConstant;
use App\GraphQL\Types\Input\EventType as EventInputType;
use App\GraphQL\Types\Output\EventType;
use App\Repository\EventRepository;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type as GraphqlType;
use Rebing\GraphQL\Support\Mutation;
use Illuminate\Support\Arr;
use App\Models\Event;
use Carbon\Carbon;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\EventType as AppEventType;

class CreateEvent extends Mutation
{
    const MUTATION_NAME = 'createEvent';

    protected $eventRepository;

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

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
            ['name' => GraphQLConstant::INPUT_ARG_NAME, 'type' => GraphQL::type(EventInputType::TYPE_NAME)]
        ];
    }

    public function rules(array $args = []): array
    {
        $input = GraphQLConstant::INPUT_ARG_NAME . '.';

        return [
            $input . EventInputType::FIELD_NAME => ['required', 'email'],
            $input . EventInputType::FIELD_FEE => ['required'],
             // $input . EventInputType::FIELD_USER_ID => ['required'],  //becous we dont want to pass id in field, we take it from JWT Auth.
            $input . EventInputType::FIELD_EVENT_TYPE => ['required'],
            $input . EventInputType::FIELD_EVENT_DATE => ['required'],
            $input . EventInputType::FIELD_DESCRIPTION => ['required'],
            $input . EventInputType::FIELD_CITY_ID => ['required'],
            $input . EventInputType::FIELD_ADDRESS => ['required'],
        ];
    }

    public function resolve($root, $args)
    {

        $args = Arr::get($args, 'input');
        $args['user_id'] = JWTAuth::user()->id;
        $args['event_date'] = Carbon::createFromFormat('d-m-Y h:i:s', $args['event_date']);
        
        if($created = Event::create($args)){
            return $created;
        }else{
            throw new \Exception('Error during create event');

        }
    }
}
