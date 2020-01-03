<?php
namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;

class DeleteUserTest extends TestCase
{
    public function testDeleteUserById(): void
    {
        $user = factory(User::class)->create();

        $graphql = <<<'GRAPHQL'
            mutation($usersId: Int) {
              deleteUsers(users_id: $usersId)
            }
            GRAPHQL;


        $input = ['usersId' => $user->id];

        $result = $this->graphql($graphql, [
            'expectErrors' => false,
            'variables' => $input,
        ]);

        $this->assertTrue($result['data']['deleteUsers']);
    }
}
