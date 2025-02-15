<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\DoctorModality;
use App\Models\Doctor;

use App\Traits\GeneralFunctionTrait;

class DoctorSeeder extends Seeder
{
    use GeneralFunctionTrait;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 50; $i++) {
            $name = $faker->name;
            $email = $faker->email;
            $user = $this->insertUserData($name, $email, 'Doctor');

            $roleUser = $this->insertRoleUserData($user->id, 4);

            $doctor = new Doctor();
            $doctor->name = $name;
            $doctor->email = $email;
            $doctor->phone_number = $faker->phoneNumber;
            $doctor->user_id = $user->id;
            $doctor->save();

            $modalityes = $this->generateRandomNumbers();
            foreach($modalityes as $modality){
                $docModality = new DoctorModality();
                $docModality->doctor_id = $doctor->id;
                $docModality->modality_id = $modality;
                $docModality->save();
            }
        }
    }

    private function generateRandomNumbers(): array{
        // Determine the random count of numbers to generate (2 to 4)
        $count = rand(2, 4);
        
        // Generate unique numbers between 1 and 5
        $numbers = [];
        while (count($numbers) < $count) {
            $randomNumber = rand(1, 5);
            if (!in_array($randomNumber, $numbers)) {
                $numbers[] = $randomNumber;
            }
        }
    
        return $numbers;
    }
}
