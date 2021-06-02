<?php

namespace App\Http\Controllers;

use App\Enums\TICKET_STATUS;
use App\Models\JobCard;
use App\Models\Ticket;
use App\Rules\Multiple;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class TicketJobCardController extends Controller
{
    public function store(Request $request, Ticket $ticket): RedirectResponse
    {
        Gate::forUser($request->user())->authorize('create', JobCard::class);

        $validated = $request->validate([
            'time_spent' => [
                'required',
                'numeric',
                new Multiple
            ],
            'content' => 'required'
        ]);

        $ticket->jobCard()->create($validated);

        return redirect()->route('tickets.show', $ticket->id);
    }

    public function create(Request $request, Ticket $ticket): InertiaResponse
    {
        Gate::forUser($request->user())->authorize('create', JobCard::class);

        $timeOptions = collect();
        for ($time=0;$time<300; $time+=config('app.defaults.min_job_time')) {
            $timeOptions->push((object)['id' => $time, 'name' => $this->formatTime($time)]);
        }
        return Inertia::render('JobCards/Create', compact('ticket', 'timeOptions'));
    }

    private function formatTime(int $time): string
    {
        $result = "";
        if ($time < 60 ) {
            return $time.' ' . Str::plural('minute', $time);
        }

        $result .= (string)intVal($time / 60) . ' ' . Str::plural('hour', intVal($time/60));
        $mod = ($time % 60);
        if ($mod > 0) {
            $result .= ' ' . $mod . ' ' . Str::plural('minute', $mod);
        }
        return $result;
    }
}
