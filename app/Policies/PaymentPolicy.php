<?php

namespace App\Policies;

use App\Models\Payment;
use App\Models\User;

class PaymentPolicy
{
    private function isAdmin(User $user): bool
    {
        return $user->role === 'admin' && $user->status === 'active';
    }

    public function viewAny(User $user): bool
    {
        return $this->isAdmin($user);
    }

    public function view(User $user, Payment $payment): bool
    {
        return $this->isAdmin($user);
    }

    public function create(User $user): bool
    {
        return $this->isAdmin($user);
    }

    public function update(User $user, Payment $payment): bool
    {
        return $this->isAdmin($user);
    }

    /**
     * تایید دستی پرداخت: فقط اگر pending باشد.
     */
    public function verify(User $user, Payment $payment): bool
    {
        return $this->isAdmin($user) && $payment->status === 'pending';
    }

    /**
     * بازگشت وجه: فقط اگر success و refunded_at خالی باشد.
     */
    public function refund(User $user, Payment $payment): bool
    {
        return $this->isAdmin($user) && $payment->isRefundable();
    }

    public function delete(User $user, Payment $payment): bool
    {
        // پرداخت موفق قابل حذف نیست
        return $this->isAdmin($user) && ! $payment->isSuccessful();
    }

    public function restore(User $user, Payment $payment): bool
    {
        return $this->isAdmin($user);
    }

    public function forceDelete(User $user, Payment $payment): bool
    {
        return $this->isAdmin($user) && ! $payment->isSuccessful();
    }
}
