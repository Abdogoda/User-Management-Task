<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest{
    
    public function authorize(): bool{
        return true;
    }

    public function rules(): array{
        return [
            'name' => 'sometimes',
            'email' => 'sometimes|email|unique:users,email,'.$this->user->id,
            'password' => 'sometimes|min:6',
            'roles' => 'sometimes|array',
            'roles.*' => 'required|exists:roles,id',
        ];
    }
}