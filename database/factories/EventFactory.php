<?php

/** @var Factory $factory */

use App\Models\Event;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Event::class, static function (Faker $faker) {
    return [
        'address' => $faker->address,
        'user_id' => \App\Models\User::whereAdmin(true)->first()->id,
        'city_id' => \App\Models\City::offset(0)->limit(1)->get()->first()->id,
        'description' => $faker->text,
        'event_date' => $faker->date('Y-m-d'),
        'event_type' => \App\Models\EventType::offset(0)->limit(1)->get()->first()->id,
        'fee' => $faker->randomFloat(2),
        'name' => $faker->title,
        'lat' => $faker->latitude,
        'lng' => $faker->longitude
    ];
});
