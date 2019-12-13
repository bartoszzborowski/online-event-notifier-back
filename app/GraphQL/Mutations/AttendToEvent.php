<?php

namespace App\GraphQL\Mutations;

use App\Constants\Database;
use App\GraphQL\BaseMutation;
use App\GraphQL\Types\Output\EventMemberType;
use App\Models\Event;
use App\Models\EventMember;
use App\Repository\EventRepository;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\DB;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type as GraphqlType;
use Illuminate\Support\Arr;

class AttendToEvent extends BaseMutation
{
    const MUTATION_NAME = 'attendToEvent';

    protected $isSecret = false;
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
        return GraphQL::type(EventMemberType::TYPE_NAME);
    }

    public function args(): array
    {
        return [
            ['name' => 'event_id', 'type' => Type::int()],
            ['name' => 'user_id', 'type' => Type::int()]
        ];
    }

    public function rules(array $args = []): array
    {
        return [
            'event_id' => ['required'],
            'user_id' => ['required'],
        ];
    }

    public function resolve($root, $args)
    {
        $eventId = Arr::get($args, 'event_id');
        $userId = Arr::get($args, 'user_id');

        $result = DB::table(Database::EVENT_MEMBERS)
            ->where('event_id', '=', $eventId)
            ->where('user_id', '=', $userId)
            ->get();

        $event = Event::whereId($eventId)->get()->first();

        if($event->user_id === $userId) {
            throw new \Exception("Can't attend to your own event");
        }

        if($result->isNotEmpty()) {
            throw new \Exception('The user is already registered for the event');
        }

        $eventMember = new EventMember();
        $eventMember->user_id = $userId;
        $eventMember->event_id = $eventId;

        if ($eventMember->save()) {
            return $eventMember;
        } else {
            throw new \Exception('Error during create event member');
        }
    }
}
