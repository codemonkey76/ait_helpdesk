<?php

namespace App\Console\Commands;

use App\Enums\TICKET_STATUS;
use App\Models\Ticket;
use Illuminate\Console\Command;

class CloseAbandondedTickets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tickets:auto-close';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Close abandoned tickets';

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
        Ticket::where('pending_closure', true)->each(function ($ticket) {
            if ($ticket->updated_at->diffInHours(now()) > config('app.defaults.notification_hours')) {
                if ($ticket->jobs()->count === 0) {
                    $ticket->update(['status_id' => TICKET_STATUS::CLOSED]);
                    return;
                }

                $ticket->update(['status_id' => TICKET_STATUS::BILLING]);
            }
        });
        return 0;
    }
}
