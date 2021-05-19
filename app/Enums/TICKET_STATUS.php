<?php

namespace App\Enums;

abstract class TICKET_STATUS
{
    const PENDING = 1;
    const OPEN = 2;
    const WAITING = 3;
    const BILLING = 4;
    const CLOSED = 5;
}
