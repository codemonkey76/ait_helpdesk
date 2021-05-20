<?php

namespace App\Http\Controllers;

use App\Notifications\VerifyPhone;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PhoneVerificationNotificationController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {

        $request->user()->setPhoneVerificationCode();
        $request->user()->notify(new VerifyPhone);
        return redirect()->route('phone.verify.notice');
    }
}
