<?php

use Illuminate\Database\Seeder;

class UsersKycTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker\Factory::create();

        foreach (range(1, 20) as $index) {
            App\UserKyc::create([
                'user_id'                => $index,
                'status'                 => $faker->numberBetween(0, 3),
                'first_name'             => $faker->firstName,
                'last_name'              => $faker->lastName,
                'address'                => $faker->streetAddress,
                'postal_code'            => $faker->postcode,
                'city'                   => $faker->city,
                'country_code'           => $faker->countryCode,
                'has_temporary_address'  => false,
                'address_temporary'      => '',
                'postal_code_temporary'  => '',
                'city_temporary'         => '',
                'country_temporary_code' => '',
                'nationality_code'       => $faker->countryCode,
                'birth'                  => $faker->date(),
                'place_of_birth'         => $faker->city,
                'file'                   => $faker->word . $faker->fileExtension,
                'file_back'              => $faker->word . $faker->fileExtension,
                'issue_date'             => $faker->date(),
                'issue_expiration_date'  => $faker->date(),
                'issuer_name'            => $faker->word,
                'document_id'            => $faker->numberBetween(1000000, 9999999),
                'document_type'          => $faker->numberBetween(1, 3),
                'email'                  => $faker->email,
                'phone_number'           => $faker->phoneNumber,
                'tax_number'             => $faker->numberBetween(1000000, 99999999),
                'message'                => $faker->text(),
            ]);
        }
    }
}
