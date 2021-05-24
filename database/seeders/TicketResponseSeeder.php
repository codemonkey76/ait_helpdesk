<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Team;
use App\Models\Ticket;
use App\Models\TicketResponse;
use Illuminate\Database\Seeder;


class TicketResponseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $agents = Role::whereName('agent')->first()->users->pluck('id');

        Ticket::each(function ($ticket) use ($agents) {
            // simulate a back and forth conversation.

            $team = Team::find($ticket->current_team_id);
            $responder = $team->users()->whereIn('users.id', $agents)->inRandomOrder()->first();
            if (!is_null($responder)) { // Only respond if there is an actual agent in this team.
                TicketResponse::factory()->create([
                'user_id' => $responder->id,
                'ticket_id' => $ticket->id
                ]);
            }


            // Respond from the owner of the ticket
            TicketResponse::factory()->create([
                'user_id' => $ticket->user_id,
                'ticket_id' => $ticket->id
            ]);


        });
    }
}
