<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class CompanyApiController extends Controller
{
    public function index(): JsonResponse
    {
        return response()
            ->json(
                Company::all()
                    ->groupBy(fn($company) => (string) Str::of($company->name)
                        ->limit(1, '')
                        ->ucfirst()
                    )
            );
    }
}
