<?php


namespace Tests\Unit;

use App\Models\Event;
use App\Models\EventType;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateEventTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    public function testUpdateEventName(): void
    {
        $event = factory(Event::class)->create();
        $mockedEvent = factory(Event::class)->make();

        $graphql = <<<'GRAPHQL'
            mutation($input: UpdateEventInputType) {
              updateEvent(input: $input) {
                id
                event_type
                address
                name
                description
                fee
                lat
                lng
              }
            }
            GRAPHQL;


        $input = ['input' => [
            'id' => $event->id,
            'name' => $mockedEvent->name,
        ]];

        $result = $this->graphql($graphql, [
            'expectErrors' => false,
            'variables' => $input,
        ]);

        $expectedResult = [
            'data' => [
                'updateEvent' => [
                    'id' => $event->id,
                    'event_type' => EventType::whereId($event->event_type)->get()->first()->name,
                    'address' => $event->address,
                    'name' => $mockedEvent->name,
                    'description' => $event->description,
                    'fee' => (string)$event->fee,
                    'lat' => round($event->lat, 2),
                    'lng' => round($event->lng, 2)
                ],
            ],
        ];
        $this->assertSame($expectedResult, $result);
    }
}
