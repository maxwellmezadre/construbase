<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\Authenticatable;

final class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(Authenticatable $authUser): bool
    {
        return $authUser->can('ViewAny:User');
    }

    public function view(Authenticatable $authUser, User $user): bool
    {
        return $authUser->can('View:User');
    }

    public function create(Authenticatable $authUser): bool
    {
        return $authUser->can('Create:User');
    }

    public function update(Authenticatable $authUser, User $user): bool
    {
        return $authUser->can('Update:User');
    }

    public function delete(Authenticatable $authUser, User $user): bool
    {
        return $authUser->can('Delete:User');
    }

    public function restore(Authenticatable $authUser, User $user): bool
    {
        return $authUser->can('Restore:User');
    }

    public function forceDelete(Authenticatable $authUser, User $user): bool
    {
        return $authUser->can('ForceDelete:User');
    }

    public function forceDeleteAny(Authenticatable $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:User');
    }

    public function restoreAny(Authenticatable $authUser): bool
    {
        return $authUser->can('RestoreAny:User');
    }

    public function replicate(Authenticatable $authUser, User $user): bool
    {
        return $authUser->can('Replicate:User');
    }

    public function reorder(Authenticatable $authUser): bool
    {
        return $authUser->can('Reorder:User');
    }
}
