<?php

use Illuminate\Database\Seeder;

class CitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cityList = ['Warszawa', 'Kraków', 'Wrocław', 'Poznań', 'Lublin', 'Katowice'];
        foreach ($cityList as $item) {
            \App\Models\City::create([
                'name' => $item,
                'slug' => \Illuminate\Support\Str::slug($item)
            ]);
        }
    }
}
