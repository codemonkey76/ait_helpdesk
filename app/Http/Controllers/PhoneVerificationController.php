<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PhoneVerificationController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        $request->validate([
            'phone_verification_code' => [
                'required',
                Rule::in($request->user()->phone_verification_code),
                function ($attribute, $value, $fail) use ($request) {
                    if (now()->gt($request->user()->phone_verification_expiry)) {
                        $fail($attribute.' has expired, try again.');
                    }
                }]
            ]);

        $request->user()->markPhoneAsVerified();

        return redirect()->route('profile.show');
    }
}
