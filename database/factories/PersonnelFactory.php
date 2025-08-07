<?php

namespace Database\Factories;

use App\Models\Personnel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Personnel>
 */
class PersonnelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Models\Personnel>
     */
    protected $model = Personnel::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $ranks = ['officer', 'sergeant', 'lieutenant', 'captain', 'major', 'chief'];
        $statuses = ['active', 'inactive', 'suspended', 'retired'];
        $departments = [
            'Patrol Division',
            'Criminal Investigation Division',
            'Traffic Division',
            'Community Relations',
            'Internal Affairs',
            'SWAT Team',
            'K-9 Unit',
            'Narcotics Division'
        ];
        $genders = ['male', 'female', 'other'];

        return [
            'badge_number' => fake()->unique()->numerify('####'),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'rank' => fake()->randomElement($ranks),
            'department' => fake()->randomElement($departments),
            'status' => fake()->randomElement($statuses),
            'hire_date' => fake()->dateTimeBetween('-20 years', '-1 year'),
            'address' => fake()->address(),
            'birth_date' => fake()->dateTimeBetween('-65 years', '-21 years'),
            'gender' => fake()->randomElement($genders),
            'emergency_contact_name' => fake()->name(),
            'emergency_contact_phone' => fake()->phoneNumber(),
            'documents' => null,
            'notes' => fake()->optional()->paragraph(),
        ];
    }

    /**
     * Indicate that the personnel is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
        ]);
    }

    /**
     * Indicate that the personnel is an officer.
     */
    public function officer(): static
    {
        return $this->state(fn (array $attributes) => [
            'rank' => 'officer',
        ]);
    }
}