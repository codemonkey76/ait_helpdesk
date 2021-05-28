<?php

namespace App\Notifications;

use Codemonkey76\Plivo\PlivoChannel;
use Codemonkey76\Plivo\PlivoMessage;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Notification;


class VerifyPhone extends Notification
{
    public function via(mixed $notifiable): array|string
    {
        return [PlivoChannel::class];
    }

    public function toPlivo($notifiable)
    {
        $validity = config('app.defaults.sms_expiry') / 60;

        return (new PlivoMessage)
            ->content("Alpha IT Centre Helpdesk Code: {$notifiable->phone_verification_code}. Valid for {$validity} minutes.");
    }
    public function toNexmo($notifiable)
    {
        $validity = config('app.defaults.sms_expiry') / 60;

        return (new NexmoMessage)
            ->content("Alpha IT Centre Helpdesk Code: {$notifiable->phone_verification_code}. Valid for {$validity} minutes.");
    }
}
