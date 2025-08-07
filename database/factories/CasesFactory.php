<?php

namespace Database\Factories;

use App\Models\Cases;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cases>
 */
class CasesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Models\Cases>
     */
    protected $model = Cases::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statuses = ['open', 'in_progress', 'closed', 'archived'];
        $priorities = ['low', 'medium', 'high', 'critical'];
        $categories = ['theft', 'assault', 'fraud', 'traffic', 'domestic', 'drug', 'cybercrime', 'other'];

        return [
            'case_number' => 'CASE-' . fake()->unique()->numerify('######'),
            'title' => fake()->sentence(4),
            'description' => fake()->paragraphs(3, true),
            'status' => fake()->randomElement($statuses),
            'priority' => fake()->randomElement($priorities),
            'category' => fake()->randomElement($categories),
            'location' => fake()->address(),
            'incident_date' => fake()->dateTimeBetween('-1 year', 'now'),
            'assigned_officer_id' => User::factory(),
            'created_by' => User::factory(),
            'evidence_files' => null,
        ];
    }

    /**
     * Indicate that the case is open.
     */
    public function open(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'open',
        ]);
    }

    /**
     * Indicate that the case is high priority.
     */
    public function highPriority(): static
    {
        return $this->state(fn (array $attributes) => [
            'priority' => 'high',
        ]);
    }
}