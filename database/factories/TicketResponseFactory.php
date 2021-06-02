<?php

namespace Database\Factories;

use App\Models\Ticket;
use App\Models\TicketResponse;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketResponseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TicketResponse::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'content' => $this->faker->paragraph(),
            'ticket_id' => Ticket::factory()->create()->id,
            'user_id' => User::factory()->create()->id
        ];
    }
}
