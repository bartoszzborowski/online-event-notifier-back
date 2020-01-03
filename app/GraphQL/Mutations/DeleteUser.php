<?php

namespace App\GraphQL\Mutations;

use App\GraphQL\BaseMutation;
use App\Models\User;
use App\Repository\UserRepository;
use Carbon\Carbon;
use GraphQL\Error\Error;
use GraphQL\Type\Definition\Type as GraphqlType;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Hash;

class DeleteUser extends BaseMutation
{
    const MUTATION_NAME = 'deleteUsers';

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
            ['name' => 'users_id', 'type' => Type::int()]
        ];
    }

    public function rules(array $args = []): array
    {
        return [
            'users_id' => ['required'],
        ];
    }

    public function resolve($root, $args)
    {
        /** @var User $user */
        $user = User::whereId($args['users_id'])->first();
        if($user->id === $this->currentUser->id || $this->currentUser->getAdmin()){
              $user->update([
                    'name' =>'Usuniety',
                    'surname' => 'Usuniety',
                    'email' => 'Usuniety@'.Carbon::now()->toDateTimeString().'.pl',
                    'base_city' => $user->base_city,
                    'admin'=> 0,
                    'password' => Hash::make('usuniety123'),
                  ]
              );

            try {
                $user->delete();
                return true;
            } catch (\Exception $e) {
                return false;
            }
        }else{
            return new Error('Error:1 during delete user');
        }
    }
}
