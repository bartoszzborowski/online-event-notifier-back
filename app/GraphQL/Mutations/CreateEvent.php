<?php

namespace App\GraphQL\Mutations;
use App\Constants\GraphQL as GraphQLConstant;
use App\GraphQL\BaseMutation;
use App\GraphQL\Types\Input\EventType as EventInputType;
use App\GraphQL\Types\Output\EventType;
use App\Repository\EventRepository;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type as GraphqlType;
use Illuminate\Support\Arr;
use App\Models\Event;
use Carbon\Carbon;

class CreateEvent extends BaseMutation
{
    const MUTATION_NAME = 'createEvent';

    protected $isSecret = true;
    protected $eventRepository;

    public function __construct(EventRepository $eventRepository)
    {
        parent::__construct();
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
            $input . EventInputType::FIELD_NAME => ['required'],
            $input . EventInputType::FIELD_FEE => ['required'],
            $input . EventInputType::FIELD_EVENT_TYPE => ['required'],
            $input . EventInputType::FIELD_EVENT_DATE => ['required'],
            $input . EventInputType::FIELD_DESCRIPTION => ['required'],
            $input . EventInputType::FIELD_CITY_ID => ['required'],
            $input . EventInputType::FIELD_ADDRESS => ['required'],
            $input . EventInputType::FIELD_LAT => ['required'],
            $input . EventInputType::FIELD_LNG => ['required'],
        ];
    }

    public function resolve($root, $args)
    {
        $args = Arr::get($args, 'input');
        $args['user_id'] = $this->currentUser->id;
        $args['event_date'] = Carbon::createFromTimeString($args['event_date']);

        if($created = Event::create($args)){
            return $created;
        }else{
            throw new \Exception('Error:1 during create event');
        }
        throw new \Exception('Error:2 during create event');
    }
}
