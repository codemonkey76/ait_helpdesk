<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Ticket;
use App\Models\User;
use App\Rules\Multiple;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class TicketJobController extends Controller
{
    public function store(Request $request, Ticket $ticket)
    {

        Gate::forUser($request->user())->authorize('create', Job::class);

        $validated = $request->validate([
            'date' => 'required|date_format:Y-m-d',
            'user_id' => [
                'required',
                Rule::in(User::permission('create job')->pluck('id'))
            ],
            'time_spent' => [
                'required',
                'numeric',
                new Multiple
            ],
            'content' => 'required|string'
        ]);

        $ticket->jobs()->create($validated);

        return redirect()->route('tickets.show', $ticket->id);
    }

    public function create(Request $request, Ticket $ticket): InertiaResponse
    {
        Gate::forUser($request->user())->authorize('create', Job::class);

        $agentOptions = User::permission('create job')->select('id', 'name')
            ->limit(500)
            ->get();

        $timeOptions = collect();
        for ($time=0;$time<300; $time+=config('app.defaults.min_job_time')) {
            $timeOptions->push((object)['id' => $time, 'name' => $this->formatTime($time)]);
        }

        return Inertia::render('Jobs/Create', compact('agentOptions', 'timeOptions', 'ticket'));
    }
    private function formatTime(int $time): string
    {
        $result = "";
        if ($time < 60 ) {
            return $time." minutes";
        }

        $result .= (string)intVal($time / 60) . ' hour(s)';
        $mod = ($time % 60);
        if ($mod > 0) {
            $result .= ' ' . $mod . ' minute(s)';
        }
        return $result;
    }
}
