<?php

namespace Database\Factories;

use App\Models\Member;
use App\Models\Result;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email' => $this->faker->unique()->safeEmail,
        ];
    }

    /**
     * Sets the associated results for the participant
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(
            fn(Member $member) => Result::factory(random_int(1, 3))->create(['member_id' => $member->id])
        );
    }
}
