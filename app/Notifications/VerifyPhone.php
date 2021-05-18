<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\URL;

class VerifyPhone extends Notification
{
    public static ?\Closure $createUrlCallback;
    public static ?\Closure $toSmsCallback;

    public function via(mixed $notifiable):array|string
    {
        return ['nexmo'];
    }

    public function toNexmo($notifiable)
    {
        return (new NexmoMessage)->content('Alpha IT Centre Helpdesk Code: ' . $notifiable->phone_verification_code . '. Valid for ' . (config('app.default_sms_expiry')/60) .' minutes.');
    }
}
