<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserPolicy{

    public function viewAny(User $user): bool{
        return $user->hasPermission(PermissionEnum::VIEW_USER->value);
    }

    public function view(User $user, User $model): bool{
        return $user->hasPermission(PermissionEnum::VIEW_USER->value) || $user->id === $model->id;
    }

    public function create(User $user): bool{
        return $user->hasPermission(PermissionEnum::CREATE_USER->value);
    }

    public function update(User $user, User $model): bool{
        return $user->hasPermission(PermissionEnum::EDIT_USER->value) || $user->id === $model->id;
    }

    public function delete(User $user, User $model): bool{
        return $user->hasPermission(PermissionEnum::DELETE_USER->value) || $user->id === $model->id;
    }
}