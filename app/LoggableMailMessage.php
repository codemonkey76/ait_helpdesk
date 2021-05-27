<?php

namespace App;

use Illuminate\Notifications\Messages\MailMessage;

class LoggableMailMessage extends MailMessage
{
    public function bccIf($condition, $address, $name = null)
    {
        if ($condition) {
            return $this->bcc($address, $name);
        }

        return $this;
    }
}
