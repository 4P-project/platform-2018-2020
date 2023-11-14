<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker\Factory::create();

        foreach (range(1, 20) as $index) {
            App\User::create([
                'type'    => $faker->numberBetween(0, 3),
                'wallet'  => '0x' . $faker->md5,
                'pub_key' => Hash::make($faker->word),
            ]);
        }
    }
}
