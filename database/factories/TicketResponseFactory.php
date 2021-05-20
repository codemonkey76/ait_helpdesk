<?php

namespace Database\Factories;

use App\Models\TicketResponse;
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
            'content' => $this->faker->paragraph()
        ];
    }
}
