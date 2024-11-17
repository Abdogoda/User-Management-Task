<?php

namespace App\Http\Requests\Api\Role;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest{
    
    public function authorize(): bool{
        return true;
    }

    public function rules(): array{
        return [
            'name' => 'sometimes|string|unique:roles,name,'. $this->role->id,
            'permissions' => 'sometimes|array',
            'permissions.*' => 'required|exists:permissions,id',
        ];
    }
}