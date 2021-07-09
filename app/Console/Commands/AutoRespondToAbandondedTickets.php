<?php

namespace App\Console\Commands;

use App\Enums\TICKET_STATUS;
use App\Models\Ticket;
use Illuminate\Console\Command;

class AutoRespondToAbandondedTickets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tickets:auto-respond';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto-respond to abandoned tickets';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Ticket::where('status_id', TICKET_STATUS::WAITING)->where('pending_closure', false)->each(function($ticket) {
            if ($ticket->dueForClose()) {
                $days = $ticket->latestResponse()->created_at->diffInDays(now());
                $hours = config('app.defaults.notification_hours');
                $ticket->responses()->create([
                    'user_id' => 1000,
                    'content' => "<p>Your ticket #{$ticket->id} has been awaiting your response for {$days} days, this ticket will be auto-closed in {$hours} hours. Please visit this ticket in the helpdesk and add any further information requested.</p>"
                ]);
                $ticket->update(['pending_closure' => true]);
            }
        });
        return 0;
    }
}
