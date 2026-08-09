<?php

namespace Database\Factories;

use App\Domains\Students\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition(): array
    {
        $firstName = fake()->firstName();
        $lastName = fake()->lastName();
        $department = fake()->randomElement(['Mass Communication', 'Political Science', 'Law', 'Education', 'Accounting']);
        $level = fake()->randomElement(['100', '200', '300', '400', '500']);

        return [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'department' => $department,
            'level' => $level,
            'registration_number' => strtoupper('NACOS-' . fake()->unique()->numerify('####')),
            'status' => fake()->randomElement(['active', 'inactive', 'alumni']),
            'date_of_birth' => fake()->dateTimeBetween('-30 years', '-18 years')->format('Y-m-d'),
        ];
    }
}
