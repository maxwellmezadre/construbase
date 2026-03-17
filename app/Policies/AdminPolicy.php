<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\Authenticatable;

final class AdminPolicy
{
    use HandlesAuthorization;

    public function viewAny(Authenticatable $authUser): bool
    {
        return $authUser->can('ViewAny:Admin');
    }

    public function view(Authenticatable $authUser, Admin $admin): bool
    {
        return $authUser->can('View:Admin');
    }

    public function create(Authenticatable $authUser): bool
    {
        return $authUser->can('Create:Admin');
    }

    public function update(Authenticatable $authUser, Admin $admin): bool
    {
        return $authUser->can('Update:Admin');
    }

    public function delete(Authenticatable $authUser, Admin $admin): bool
    {
        return $authUser->can('Delete:Admin');
    }

    public function restore(Authenticatable $authUser, Admin $admin): bool
    {
        return $authUser->can('Restore:Admin');
    }

    public function forceDelete(Authenticatable $authUser, Admin $admin): bool
    {
        return $authUser->can('ForceDelete:Admin');
    }

    public function forceDeleteAny(Authenticatable $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Admin');
    }

    public function restoreAny(Authenticatable $authUser): bool
    {
        return $authUser->can('RestoreAny:Admin');
    }

    public function replicate(Authenticatable $authUser, Admin $admin): bool
    {
        return $authUser->can('Replicate:Admin');
    }

    public function reorder(Authenticatable $authUser): bool
    {
        return $authUser->can('Reorder:Admin');
    }
}
