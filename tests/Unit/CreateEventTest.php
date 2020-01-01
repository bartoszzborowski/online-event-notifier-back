<?php


namespace Tests\Unit;


use App\GraphQL\Type\Enum\CityTypeEnum;
use App\GraphQL\Type\Enum\EventTypeEnum;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Tests\TestCase;

class CreateEventTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    public function testCreateEvent(): void
    {
        $graphql = <<<'GRAPHQL'
            mutation($input: EventInputType) {
              createEvent(input: $input) {
                event_type
                address
                city_id
                name
                description
                fee
                event_date
                lat
                lng
              }
            }
            GRAPHQL;

        $cityType = GraphQL::objectType(CityTypeEnum::class, [
            'name' => 'CityType',
        ]);

        $eventType = GraphQL::objectType(EventTypeEnum::class, [
            'name' => 'EventType',
        ]);

        $address = $this->faker->address;
        $description = $this->faker->text;
        $date = Carbon::now();
        $fee = $this->faker->randomFloat(5);
        $lat = $this->faker->latitude;
        $lng =  $this->faker->longitude;
        $name =  $this->faker->title;

        $input = ['input' => [
            'address' => $address,
            'city_id' => $cityType->getValues()[0]->name,
            'description' => $description,
            'event_date' => $date,
            'event_type' => $eventType->getValues()[0]->name,
            'fee' => $fee,
            'name' => $name,
            'lat' => $lat,
            'lng' => $lng
        ]];

        $result = $this->graphql($graphql, [
            'expectErrors' => false,
            'variables' => $input,
        ]);

        $expectedResult = [
            'data' => [
                'createEvent' => [
                    'event_type' => $eventType->getValues()[0]->name,
                    'address' => $address,
                    'city_id' => $cityType->getValues()[0]->name,
                    'name' => $name,
                    'description' => $description,
                    'fee' => (string)$fee,
                    'event_date' => $date->toDateTimeString(),
                    'lat' => $lat,
                    'lng' => $lng
                ],
            ],
        ];
        $this->assertSame($expectedResult, $result);
    }
}
