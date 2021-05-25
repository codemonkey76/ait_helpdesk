<?php

namespace App\Models;

use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Job extends Model
{
    use HasFactory;
    use RecordsActivity;

    protected $fillable = ['date', 'user_id', 'time_spent', 'content'];
    protected $with = ['user'];
    protected $appends = ['userName', 'timeSpentString', 'summary'];
    protected $dates = ['date'];
    protected $dateFormat = 'Y-m-d';


    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getUserNameAttribute()
    {
        return $this->user->name;
    }
    public function getTimeSpentStringAttribute()
    {
        return $this->formatTime($this->time_spent);
    }
    private function formatTime(int $time): string
    {
        $result = "";
        if ($time < 60 ) {
            return $time." minutes";
        }

        $result .= (string)intVal($time / 60) . ' ' . Str::plural('hour', intVal($time/60));
        $mod = ($time % 60);
        if ($mod > 0) {
            $result .= ' ' . $mod . ' minutes';
        }
        return $result;
    }
    public function getSummaryAttribute()
    {
        return sprintf('%s
%s

Agent: %s
Time: %s',
            $this->date->format('d/m/Y'),
            $this->content,
            $this->userName,
            $this->formatTime($this->time_spent)
        );
    }
}
