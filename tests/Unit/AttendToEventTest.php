<?php


namespace Tests\Unit;


use App\GraphQL\Type\Enum\CityTypeEnum;
use App\GraphQL\Type\Enum\EventTypeEnum;
use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Tests\TestCase;

class AttendToEventTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    public function testAttendToEvent(): void
    {
        $event = factory(Event::class)->create();
        $user = factory(User::class)->create();
        $graphql = <<<'GRAPHQL'
            mutation($userId: Int, $eventId: Int) {
              attendToEvent(event_id: $eventId, user_id: $userId) {
                user_id
                event_id
              }
            }
            GRAPHQL;

        $input = [
            'eventId' => $event->id,
            'userId' => $user->id
        ];

        $result = $this->graphql($graphql, [
            'expectErrors' => false,
            'variables' => $input,
        ]);

        $expectedResult = [
            'data' => [
                'attendToEvent' => [
                    'user_id' => $user->id,
                    'event_id' => $event->id
                ]
            ]
        ];

        $this->assertSame($expectedResult, $result);
    }
}
