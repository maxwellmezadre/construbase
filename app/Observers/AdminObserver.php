<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Admin;
use Illuminate\Support\Facades\Cache;
use Psr\SimpleCache\InvalidArgumentException;

final class AdminObserver
{
    /**
     * Handle the Admin "created" event.
     */
    public function created(): void
    {
        try {
            Cache::delete('admins_count');
        } catch (InvalidArgumentException) {
        }
    }

    /**
     * Handle the Admin "updated" event.
     */
    public function updated(): void
    {
        //
    }

    /**
     * Handle the Admin "deleted" event.
     */
    public function deleted(): void
    {
        try {
            Cache::delete('admins_count');
        } catch (InvalidArgumentException) {
        }
    }

    /**
     * Handle the Admin "restored" event.
     */
    public function restored(): void
    {
        //
    }

    /**
     * Handle the Admin "force deleted" event.
     */
    public function forceDeleted(): void
    {
        //
    }
}
