<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Contracts\Auth\Authenticatable;

final class ProductPolicy
{
    use HandlesAuthorization;

    public function viewAny(Authenticatable $authUser): bool
    {
        return $authUser->can('ViewAny:Product');
    }

    public function view(Authenticatable $authUser): bool
    {
        return $authUser->can('View:Product');
    }

    public function create(Authenticatable $authUser): bool
    {
        return $authUser->can('Create:Product');
    }

    public function update(Authenticatable $authUser): bool
    {
        return $authUser->can('Update:Product');
    }

    public function delete(Authenticatable $authUser): bool
    {
        return $authUser->can('Delete:Product');
    }

    public function restore(Authenticatable $authUser): bool
    {
        return $authUser->can('Restore:Product');
    }

    public function forceDelete(Authenticatable $authUser): bool
    {
        return $authUser->can('ForceDelete:Product');
    }

    public function forceDeleteAny(Authenticatable $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Product');
    }

    public function restoreAny(Authenticatable $authUser): bool
    {
        return $authUser->can('RestoreAny:Product');
    }

    public function replicate(Authenticatable $authUser): bool
    {
        return $authUser->can('Replicate:Product');
    }

    public function reorder(Authenticatable $authUser): bool
    {
        return $authUser->can('Reorder:Product');
    }
}
