<?php

namespace Database\Factories;

use App\Models\Job;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Job::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory()->create()->id,
            'ticket_id' => Ticket::factory()->create()->id,
            'content' => $this->faker->paragraph(),
            'time_spent' => ceil( mt_rand(1, 900) / 15 ) * 15,
            'date' => now()
        ];
    }
}
