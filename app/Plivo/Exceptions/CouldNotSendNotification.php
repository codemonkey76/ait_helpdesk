<?php

namespace App\Plivo\Exceptions;

use Exception;
use JetBrains\PhpStorm\Pure;

class CouldNotSendNotification extends Exception
{
    #[Pure] public static function serviceRespondedWithAnError($response): static
    {
        return new static("Notification was not sent. Plivo responded with `{$response['status']}: {$response['response']['error']}`");
    }
}
