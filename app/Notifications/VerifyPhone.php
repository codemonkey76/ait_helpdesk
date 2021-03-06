<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;


class VerifyPhone extends Notification implements ShouldQueue
{
    use Queueable;

    public function via(mixed $notifiable): array|string
    {
        return [TwilioChannel::class];
    }

    public function toTwilio($notifiable)
    {
        $validity = config('app.defaults.sms_expiry') / 60;

        return (new TwilioSmsMessage)
            ->sender('AlphaIT')
            ->content("Alpha IT Centre Helpdesk Code: {$notifiable->phone_verification_code}. Valid for {$validity} minutes.");
    }
}
