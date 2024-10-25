<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use DB;
use App\Models\User;
use App\Models\role_user;
use App\Traits\GeneralFunctionTrait;

class patientDataSeeder extends Seeder
{
    use GeneralFunctionTrait;
    /**
     * Run the database seeds.
     */
    public function run(): void{
        $faker = Faker::create('en_IN'); // Using Indian locale for names
        $userImage =  asset('images/default.png');
        for ($i = 0; $i < 100; $i++) { // Adjust the loop count as needed
            $firstName = $faker->firstName;
            $lastName = $faker->lastName;
            $email = $faker->safeEmail;
            $mobile = $this->formatMobileNumber($faker->mobileNumber);
            $user = new User;
            $user->name = $firstName . ' ' . $lastName;
            $user->email = $email;
            $user->password = Hash::make($this->generateRandomPassword(5));
            $user->mobile_number = $mobile;
            $user->user_image = $userImage;
            $user->save();

            $role_user = new role_user;
            $role_user->role_id = 7;
            $role_user->user_id = $user->id;
            $role_user->save();
            
            DB::table('patients')->insert([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'full_name' => $firstName . ' ' . $lastName,
                'email' => $email,
                'mobile_number' => $mobile,
                'date_of_birth' => $faker->date(),
                'gender' => $faker->randomElement(['male', 'female']),
                'address' => $faker->address,
                'city' => $faker->city,
                'state' => $faker->state,
                'country' => $faker->country,
                'postal_code' => $faker->postcode,
                'notes' => $faker->text,
                'created_at' => now(),
                'updated_at' => now(),
                'user_id' => $user->id
            ]);
        }
    }
}
