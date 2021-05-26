<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Builder;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'ticket_id', 'type', 'subject_type', 'subject_id'];
    protected $with = ['subject'];

    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    public static function userFilter(Ticket $ticket, User $user): Collection
    {
        $activities = $ticket->activities()->latest()->get();

        if (!$user->hasPermissionTo('see private responses')) {
            $activities = $activities->filter(function ($activity) {
                if ($activity->subject_type == (new TicketResponse)->getMorphClass() && $activity->subject->private) {
                    return false;
                }

                return true;
            });
        }

        if (!$user->hasPermissionTo('see jobs')) {
            $activities = $activities->filter(function ($activity) {
                if ($activity->subject_type == (new Job)->getMorphClass()) {
                    return false;
                }

                return true;
            });
        }

        if (!$user->hasPermissionTo('see status changes')) {
            $activities = $activities->filter(function ($activity) {
                if ($activity->subject_type == (new TicketStatusChange)->getMorphClass()) {
                    return false;
                }

                return true;
            });
        }

        return $activities;
    }
}
