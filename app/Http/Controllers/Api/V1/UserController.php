<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Role\AssignRoleRequest;
use App\Http\Requests\Api\User\StoreUserRequest;
use App\Http\Requests\Api\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller{
    
    public function index(){
        Gate::authorize('viewAny', User::class);

        return UserResource::collection(User::all());
    }

    public function show(User $user){
        Gate::authorize('viewAny', $user);
        
        return response()->json(new UserResource($user->load('roles')));
    }

    public function store(StoreUserRequest $request){
        Gate::authorize('create', User::class);

        $user = User::create($request->validated());
        if($request->filled('roles')){
            $user->roles()->sync($request->roles);
        }
        
        return response()->json(new UserResource($user->load('roles')), 201);
    }

    public function update(UpdateUserRequest $request, User $user){
        Gate::authorize('update', $user);
        
        $user->update($request->except('roles'));
        if($request->filled('roles')){
            $user->roles()->sync($request->roles);
        }

        return response()->json(new UserResource($user->load('roles')));
    }

    public function destroy(User $user){
        Gate::authorize('delete', $user);

        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }

}