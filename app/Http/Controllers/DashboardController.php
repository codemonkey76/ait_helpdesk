<?php

namespace App\Http\Controllers;

use App\Enums\TICKET_STATUS;
use App\Models\Job;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class DashboardController extends Controller
{
    public function index(Request $request): InertiaResponse
    {
        $stats = [];

        if ($request->user()->can('view billable hours')) {
            $stats['billable_hours'] = Job::whereBetween('date', [
                now()->subDays(config('app.defaults.report_days')),
                now()
            ])
                ->get()
                ->groupBy('userName')
                ->map(fn($jobs, $key) => (object) [
                    'name'  => $key,
                    'total' => $jobs->sum('time_spent') / 60
                ]);
        }

        if ($request->user()->can('view count of billable tickets')) {
            $stats['billable_tickets'] = Ticket::where('status_id', TICKET_STATUS::BILLING)->count();
        }

        if ($request->user()->can('view ticket creation rate')) {
            $stats['ticket_creation_rate'] = round(Ticket::where('created_at', '>',
                    now()->subDays(config('app.defaults.report_days')))->count() / config('app.defaults.report_days'),
                1);;
        }

        if ($request->user()->can('view count of open tickets')) {
            $stats['open_tickets'] = Ticket::where('status_id', TICKET_STATUS::OPEN)->count();
        }


        return Inertia::render('Dashboard', compact('stats'));
    }
}
