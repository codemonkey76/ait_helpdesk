<?php

namespace App\Contracts;

interface MustVerifyPhone
{
    public function hasVerifiedPhone(): bool;

    public function markPhoneAsVerified(): bool;

    public function sendPhoneVerificationNotification(): void;

    public function getPhoneForVerification(): string;
}
