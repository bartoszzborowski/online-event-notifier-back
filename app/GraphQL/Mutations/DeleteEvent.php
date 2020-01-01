<?php

namespace App\GraphQL\Mutations;

use App\GraphQL\BaseMutation;
use App\Repository\UserRepository;
use GraphQL\Error\Error;
use GraphQL\Type\Definition\Type as GraphqlType;
use Rebing\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\Type;
use App\Models\Event;
use Tymon\JWTAuth\Facades\JWTAuth;

class DeleteEvent extends BaseMutation
{
    const MUTATION_NAME = 'deleteEvents';

    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        parent::__construct();
        $this->userRepository = $userRepository;
    }

    protected $attributes = [
        'name' => self::MUTATION_NAME
    ];

    public function type(): GraphqlType
    {
        return GraphqlType::boolean();
    }

    public function args(): array
    {
        return [
            ['name' => 'event_id', 'type' => Type::int()]
        ];
    }

    public function rules(array $args = []): array
    {
        return [
            'event_id' => ['required'],
        ];
    }

    public function resolve($root, $args)
    {
        /** @var Event $event */
        $event = Event::whereId($args['event_id'])->first();

        if ($event->user_id === $this->currentUser->id || $this->currentUser->getAdmin()) {
            try {
                return $event->delete();
            } catch (\Exception $e) {
                return new Error('Error during delete event');
            }
        }
        return new Error('Error:2 during delete event');
    }
}
