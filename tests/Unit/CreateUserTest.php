<?php


namespace Tests\Unit;

use App\Models\City;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    public function testUpdateEventName(): void
    {
        $user = factory(User::class)->make();

        $graphql = <<<'GRAPHQL'
            mutation($input: UserInputType) {
              createUser(input: $input) {
                name,
                surname,
                admin,
                email
              }
            }
            GRAPHQL;


        $input = ['input' => [
            'name' => $user->name,
            'surname' => $user->surname,
            'email' => $user->email,
            'password' => $user->password,
            'base_city' => City::whereId($user->base_city)->first()->slug,
            'admin' => $user->admin,
        ]];

        $result = $this->graphql($graphql, [
            'expectErrors' => false,
            'variables' => $input,
        ]);

        $expectedResult = [
            'data' => [
                'createUser' => [
                    'name' => $user->name,
                    'surname' => $user->surname,
                    'admin' => $user->admin,
                    'email' => $user->email,
                ],
            ],
        ];
        $this->assertSame($expectedResult, $result);
    }
}
