<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserCommunicationPreferencesController extends Controller
{
    public function update(Request $request)
    {
        $validated = $request->validate([
            'comms_preference' => 'array|required',
            'comms_preference.*' => 'in:NotificationChannels\Twilio\TwilioChannel,mail'
        ]);

        $request->user()->update($validated);

        return route('profile.show');
    }
}
