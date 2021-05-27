<?php

namespace App\Rules;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class Expired implements Rule
{
    private Carbon $expiry;

    public function __construct(Carbon $expiry)
    {
        $this->expiry = $expiry;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return now()->lt($this->expiry);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute has expired, try again.';
    }
}
