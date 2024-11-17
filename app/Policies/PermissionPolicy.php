<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\User;

class PermissionPolicy{

    public function viewAny(User $user): bool{
        return $user->hasPermission(PermissionEnum::VIEW_PERMISSION->value);
    }
}