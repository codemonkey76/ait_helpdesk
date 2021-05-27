<?php

namespace App\Http\Requests;

use App\Models\Job;
use App\Models\User;
use App\Rules\Multiple;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class CreateTicketJobRequest extends FormRequest
{

    public function authorize(): bool
    {
        return $this->user()->can('create', Job::class);
    }

    public function rules(): array
    {
        return [
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
        ];
    }
}
