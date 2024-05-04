<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Http\Resources\RolesResource;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\DataTables\RolesDataTable;

class RoleController extends Controller
{
    public function index(RolesDataTable $dataTable){
        return $dataTable->render('roles.index');
    }

    public function show(Role $role){
        $permissions = Permission::get()->groupBy('group')->map(function ($permissions) {
            return $permissions->pluck('name')->unique()->toArray();
        });
        return view('roles.show', compact('role','permissions'));
    }

    public function create(){
        $permissions = Permission::get()->groupBy('group')->map(function ($permissions) {
            return $permissions->pluck('name')->unique()->toArray();
        });
        return view('roles.create', compact('permissions'));
    }

    public function store(RoleRequest $request){
        $role = Role::create($request->all());
        $role->syncPermissions(formatRequestPermissions($request->permissions));
        return response()->json([
            'success' => true,
            'message' => 'Role created successfully',
            'data' => new RolesResource($role)
        ], 201);
    }

    public function update(RoleRequest $request, Role $role){
        $role->update($request->all());
        $role->syncPermissions(formatRequestPermissions($request->permissions));
        return response()->json([
            'success' => true,
            'message' => 'Role updated successfully',
            'data' => new RolesResource($role)
        ], 200);
    }

    public function destroy(Role $role){
        if ($role->name === 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'You cannot delete the admin role'
            ], 403);
        }
        $role->delete();
        return response()->json([
            'success' => true,
            'message' => 'Role deleted successfully'
        ], 200);
    }
}
