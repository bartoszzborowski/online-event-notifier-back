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
<<<<<<< HEAD
        $Event = Event::find($args['event_id'])->first();
        // dd($Event->first()->user_id);

        if($Event->user_id == JWTAuth::user()->id or JWTAuth::user()->getAdmin()){
            return $Event->delete();
        }else{
            throw new \Exception('Error:1 during delete event');
=======
        /** @var Event $event */
        $event = Event::whereId($args['event_id'])->first();

        try {
            $event->delete();
        } catch (\Exception $e) {
            throw new \Exception('Error during delete event');
>>>>>>> 0e515deffdbe02a046794131be106a8e137031a2
        }
        throw new \Exception('Error:2 during delete event');
    }
}
