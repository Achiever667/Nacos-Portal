<?php

namespace Database\Factories;

use App\Domains\Programs\Models\Program;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProgramFactory extends Factory
{
    protected $model = Program::class;

    public function definition(): array
    {
        $name = fake()->unique()->sentence(3);
        $department = fake()->randomElement(['Media', 'Technology', 'Business', 'Policy', 'Education']);
        $code = strtoupper(fake()->unique()->bothify('PRG###'));

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'code' => $code,
            'department' => $department,
            'overview' => fake()->paragraphs(3, true),
            'career_opportunities' => fake()->paragraphs(2, true),
            'is_active' => fake()->boolean(85),
        ];
    }
}
