<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\Role;
use App\Models\User;

class RolePolicy{
    
    public function viewAny(User $user): bool{
        return $user->hasPermission(PermissionEnum::VIEW_ROLE->value);
    }

    public function view(User $user, Role $role): bool{
        return $user->hasPermission(PermissionEnum::VIEW_ROLE->value);
    }

    public function create(User $user): bool{
        return $user->hasPermission(PermissionEnum::CREATE_ROLE->value);
    }

    public function update(User $user, Role $role): bool{
        return $user->hasPermission(PermissionEnum::EDIT_ROLE->value);
    }

    public function delete(User $user, Role $role): bool{
        return $user->hasPermission(PermissionEnum::DELETE_ROLE->value);
    }
}