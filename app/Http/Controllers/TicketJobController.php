<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTicketJobRequest;
use App\Http\Requests\UpdateTicketJobRequest;
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
    public function store(CreateTicketJobRequest $request, Ticket $ticket)
    {
        $ticket->jobs()->create($request->validated());

        return redirect()->route('tickets.show', $ticket->id);
    }

    public function edit(Request $request, Ticket $ticket, Job $job): InertiaResponse
    {
        Gate::forUser($request->user())->authorize('edit', $job);

        $agentOptions = User::permission('create job')->select('id', 'name')
            ->limit(500)
            ->get();

        $timeOptions = collect();
        for ($time=0;$time<config('app.defaults.max_job_time'); $time+=config('app.defaults.min_job_time')) {
            $timeOptions->push((object)['id' => $time, 'name' => $this->formatTime($time)]);
        }

        return Inertia::render('Jobs/Edit', compact('agentOptions', 'timeOptions', 'ticket', 'job'));
    }

    public function update(UpdateTicketJobRequest $request, Ticket $ticket, Job $job)
    {
        $job->update($request->validated());

        return redirect()->route('tickets.show', $ticket->id);
    }

    public function create(Request $request, Ticket $ticket): InertiaResponse
    {
        Gate::forUser($request->user())->authorize('create', Job::class);

        $agentOptions = User::permission('create job')->select('id', 'name')
            ->limit(500)
            ->get();

        $timeOptions = collect();
        for ($time=0;$time<config('app.defaults.max_job_time'); $time+=config('app.defaults.min_job_time')) {
            $timeOptions->push((object)['id' => $time, 'name' => $this->formatTime($time)]);
        }

        return Inertia::render('Jobs/Create', compact('agentOptions', 'timeOptions', 'ticket'));
    }

    public function destroy(Request $request, Ticket $ticket, Job $job)
    {
        Gate::forUser($request->user())->authorize('delete', $job);

        $job->delete();

        return redirect()->route('tickets.show', $ticket->id);
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
