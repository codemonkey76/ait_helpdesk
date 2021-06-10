<?php

namespace App\Traits;

use App\Notifications\VerifyPhone;
use Illuminate\Database\Eloquent\Model;

trait HasMustVerifyPhone
{
    public function hasVerifiedPhone(): bool
    {
        return ! is_null($this->phone_verified_at);
    }

    public function markPhoneAsVerified(): Model
    {
        return $this->forceFill([
            'phone_verified_at' => $this->freshTimestamp(),
            'phone_verification_code' => null,
            'phone_verification_expiry' => null
        ]);
    }
    public function clearPhoneVerificationStatus(): Model
    {
        return $this->forceFill([
            'phone_verified_at' => null,
            'phone_verification_code' => null,
            'phone_verification_expiry' => null
        ]);
    }

    public function sendPhoneVerificationNotification(): void
    {
        $this->notify(new VerifyPhone);
    }

    public function getPhoneForVerification(): string
    {
        return $this->phone;
    }

    public function setPhoneVerificationCode(): string
    {
        return $this->forceFill([
            'phone_verification_code' => sprintf("%06d", mt_rand(1, 999999)),
            'phone_verification_expiry' => now()->addSeconds(config('app.defaults.sms_expiry'))
        ])->save();
    }
}
