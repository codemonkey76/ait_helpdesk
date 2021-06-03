<?php

namespace App\Notifications;

use Codemonkey76\Plivo\PlivoChannel;
use Codemonkey76\Plivo\PlivoMessage;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;


class VerifyPhone extends Notification
{
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
