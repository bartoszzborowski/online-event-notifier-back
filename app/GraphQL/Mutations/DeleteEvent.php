<?php

namespace App\GraphQL\Mutations;

use App\Repository\UserRepository;
use GraphQL\Type\Definition\Type as GraphqlType;
use Rebing\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\Type;
use App\Models\Event;
use Tymon\JWTAuth\Facades\JWTAuth;

class DeleteEvent extends Mutation
{
    const MUTATION_NAME = 'deleteEvents';

    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
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
        // dd($event);
        if($event->user_id == JWTAuth::user()->id or JWTAuth::user()->getAdmin()){
        try {
            return $event->delete();
        } catch (\Exception $e) {
            throw new \Exception('Error during delete event');
        }
    }
        throw new \Exception('Error:2 during delete event');
    }
}
