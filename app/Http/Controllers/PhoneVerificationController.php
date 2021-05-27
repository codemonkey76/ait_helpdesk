<?php

namespace App\Http\Controllers;

use App\Rules\Expired;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PhoneVerificationController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        info($request->all());
        $request->validate([
            'phone_verification_code' => [
                'required',
                Rule::in($request->user()->phone_verification_code),
                new Expired($request->user()->phone_verification_expiry)
            ]
        ]);

        $request->user()->markPhoneAsVerified();

        return redirect()->route('profile.show');
    }
}
