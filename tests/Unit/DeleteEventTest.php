<?php


namespace Tests\Unit;


use App\Models\Event;
use Tests\TestCase;

class DeleteEventTest extends TestCase
{
    public function testDeleteEventById(): void
    {
        $event = factory(Event::class)->create();

        $graphql = <<<'GRAPHQL'
            mutation($event_id: Int) {
              deleteEvents(event_id: $event_id)
            }
            GRAPHQL;


        $input = ['event_id' => $event->id];

        $result = $this->graphql($graphql, [
            'expectErrors' => false,
            'variables' => $input,
        ]);

        $this->assertTrue($result['data']['deleteEvents']);
    }
}
