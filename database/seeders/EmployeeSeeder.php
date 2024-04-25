<?php

namespace Database\Seeders;

use App\Models\Employee;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        for ($i=0; $i < 50; $i++){
            Employee::create([
                'name' => $faker->name,
                'email' =>$faker->unique('employees')->safeEmail(),
                'gender' => $faker->randomElement(['male', 'female', 'other']),
                'age' =>$faker->numberBetween(0,100),
                'user_id' => 1,
                'description' => $faker->sentence(4),
            ]);
        }
    }
}