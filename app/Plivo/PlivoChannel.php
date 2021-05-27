<?php

namespace App\Plivo;

use App\Plivo\Exceptions\CouldNotSendNotification;
use Illuminate\Notifications\Notification;

class PlivoChannel
{
    protected Plivo $plivo;
    protected string $from;

    public function __construct(Plivo $plivo)
    {
        $this->plivo = $plivo;
        $this->from = $this->plivo->from();
    }

    public function send($notifiable, Notification $notification)
    {
        if (!$to = $notifiable->routeNotificationFor('plivo')) {
            return;
        }

        $message = $notification->toPlivo($notifiable);

        if (is_string($message)) {
            $message = new PlivoMessage($message);
        }


        $response = $this->plivo->messages->create($this->from, [$to], trim($message->content));

        if ($response->statusCode !== 202) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($response);
        }

        return $response;
    }
}
