<?php

namespace App\Policies;

use App\Models\Cart\Order;
use App\Models\User;

class OrderPolicy
{
    /**
<<<<<<< HEAD
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Order $order): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Order $order): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Order $order): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Order $order): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Order $order): bool
    {
        return false;
=======
     * آیا کاربر ادمین فعال است؟
     */
    private function isAdmin(User $user): bool
    {
        return $user->role === 'admin' && $user->status === 'active';
    }

    public function viewAny(User $user): bool
    {
        return $this->isAdmin($user);
    }

    public function view(User $user, Order $order): bool
    {
        return $this->isAdmin($user);
    }

    public function create(User $user): bool
    {
        return $this->isAdmin($user);
    }

    public function update(User $user, Order $order): bool
    {
        return $this->isAdmin($user);
    }

    public function delete(User $user, Order $order): bool
    {
        // سفارش دارای پرداخت موفق قابل حذف نیست
        return $this->isAdmin($user)
            && ! $order->successfulPayment()->exists();
    }

    public function restore(User $user, Order $order): bool
    {
        return $this->isAdmin($user);
    }

    public function forceDelete(User $user, Order $order): bool
    {
        // حذف دائمی فقط اگر پرداخت موفق نباشد
        return $this->isAdmin($user)
            && ! $order->successfulPayment()->exists();
>>>>>>> a96f8e3 (complateforCartshoping)
    }
}
