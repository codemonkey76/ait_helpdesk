<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserCommunicationPreferencesController extends Controller
{
    public function update(Request $request)
    {
        $validated = $request->validateWithBag('updateCommunicationPreferences', [
            'comms_preference' => [
                'array',
                'required',
                function ($attribute, $value, $fail) use ($request) {
                    if (is_null($request->user()->phone_verified_at) && in_array('NotificationChannels\Twilio\TwilioChannel', $value)) {
                        $fail('Your phone has not been verified.');
                    }
                }
            ],
            'comms_preference.*' => ['in:NotificationChannels\Twilio\TwilioChannel,mail']
        ]);

        $request->user()->update($validated);

        return redirect()->route('profile.show');
    }
}
