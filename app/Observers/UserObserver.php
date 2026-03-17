<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Psr\SimpleCache\InvalidArgumentException;

final class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(): void
    {
        try {
            Cache::delete('users_count');
        } catch (InvalidArgumentException) {
        }
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(): void
    {
        try {
            Cache::delete('users_count');
        } catch (InvalidArgumentException) {
        }
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(): void
    {
        //
    }
}
