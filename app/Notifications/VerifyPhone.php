<?php

namespace App\Notifications;


use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Notification;


class VerifyPhone extends Notification
{
    public function via(mixed $notifiable): array|string
    {
        return ['nexmo'];
    }

    public function toNexmo($notifiable)
    {
        $validity = config('app.defaults.sms_expiry') / 60;

        return (new NexmoMessage)
            ->content("Alpha IT Centre Helpdesk Code: {$notifiable->phone_verification_code}. Valid for {$validity} minutes.");
    }
}
