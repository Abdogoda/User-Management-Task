<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Role\StoreRoleRequest;
use App\Http\Requests\Api\Role\UpdateRoleRequest;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller{

    public function index(){
        Gate::authorize('viewAny', Role::class);
        
        return RoleResource::collection(Role::all());
    }

    public function show(Role $role){
        Gate::authorize('view', $role);
        
        return new RoleResource($role->load('permissions'));
    }

    public function store(StoreRoleRequest $request){
        Gate::authorize('create', Role::class);

        $role = Role::create(['name' => $request->name]);
        if($request->filled('permissions')){
            $role->permissions()->sync($request->permissions);
        }
        
        return response()->json(new RoleResource($role->load('permissions')), 201);
    }

    public function update(UpdateRoleRequest $request, Role $role){
        Gate::authorize('update', $role);

        $role->update($request->except('permissions'));
        if($request->filled('permissions')){
            $role->permissions()->sync($request->permissions);
        }
        
        return response()->json(new RoleResource($role->load('permissions')));
    }

    public function destroy(Role $role){
        Gate::authorize('delete', $role);

        $role->delete();
        return response()->json(['message' => 'Role Deleted']);
    }

}