<?php

namespace Database\Factories;

use App\Enums\TICKET_STATUS;
use App\Models\Ticket;
use App\Models\TicketStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Ticket::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'subject'   => $this->faker->sentence(),
            'content'   => $this->faker->paragraph(),
            'status_id' => TicketStatus::factory()->create()->id,
            'user_id'   => User::factory()->create()->id
        ];
    }

    public function statusOpen()
    {
        return $this->state(function (array $attributes) {
            return [
                'status_id' => TICKET_STATUS::OPEN
            ];
        });
    }
}
