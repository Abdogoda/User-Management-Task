<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PermissionResource;
use App\Models\Permission;
use Illuminate\Support\Facades\Gate;

class PermissionController extends Controller{
    
    public function index(){
        Gate::authorize('viewAny', Permission::class);

        return PermissionResource::collection(Permission::all());
    }
}