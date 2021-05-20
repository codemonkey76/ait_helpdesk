<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Multiple implements Rule
{
    public function passes($attribute, $value): bool
    {
        return !($value % config('app.defaults.min_job_time'));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be a multiple of ' . config('app.defaults.min_job_time') . '.';
    }
}
