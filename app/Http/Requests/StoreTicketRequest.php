<?php

namespace App\Http\Requests;

use App\Models\Company;
use App\Models\Ticket;
use App\Rules\CompanyAssigned;
use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', Ticket::class);
    }

    public function rules(): array
    {
        return [
            'subject'    => 'required|string',
            'content'    => 'required|string',
            'company_id' => [
                'nullable',
                new CompanyAssigned(request()->user())
            ]
        ];
    }
}
