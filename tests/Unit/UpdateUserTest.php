<?php


namespace Tests\Unit;

use App\Models\City;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateUserTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    public function testUpdateUserName(): void
    {
        $user = factory(User::class)->create();
        $mockedUser = factory(User::class)->make();

        $graphql = <<<'GRAPHQL'
            mutation($input: UpdateUserInputType) {
              updateUser(input: $input) {
                id
                name
                surname
                email
                admin
              }
            }
            GRAPHQL;


        $input = ['input' => [
            'id' => $user->id,
            'name' => $mockedUser->name,
            'surname' => $mockedUser->surname,
            'email' => $mockedUser->email,
            'admin' => $mockedUser->admin,
        ]];

        $result = $this->graphql($graphql, [
            'expectErrors' => false,
            'variables' => $input,
        ]);

        $expectedResult = [
            'data' => [
                'updateUser' => [
                    'id' => $user->id,
                    'name' => $mockedUser->name,
                    'surname' => $mockedUser->surname,
                    'email' => $mockedUser->email,
                    'admin' => $mockedUser->admin,
                ],
            ],
        ];
        $this->assertSame($expectedResult, $result);
    }
}
