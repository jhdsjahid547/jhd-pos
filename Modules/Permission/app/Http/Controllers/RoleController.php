<?php

namespace Modules\Permission\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use SweetAlert2\Laravel\Swal;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Role::class);
        $activeRole = null;
        $rolePermissions = [];
        if(request()->has('id')) {
            $activeRole = Role::with('permissions')->find(request('id'));
            if ($activeRole) {
                $rolePermissions = $activeRole->permissions->pluck('id')->toArray();
            }
        }
        $roles = Role::all();
        $permissionGroups = Permission::query()
            ->orderBy('module')
            ->orderBy('section')
            ->orderBy('name')
            ->get()
            ->groupBy(['module', 'section']);

        return view('permission::role.index', [
            'roles' => $roles,
            'activeRole' => $activeRole,
            'rolePermissions' => $rolePermissions ?? [],
            'permissionGroups' => $permissionGroups,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Role $role, Request $request)
    {
        Gate::authorize('create', Role::class);
        $request->validate([
            'name' => 'required|unique:roles,name'
        ]);
        $role->create($request->except('_token'));
        alertSuccess('Role successfully created.');
        return back();
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        //return view('permission::show');
        $role = Role::findById($id);
        Gate::authorize('view', $role);
        return response()->json($role);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        Gate::authorize('update', $role);
        $validated = $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
        ]);
        $role->update($validated);
        alertSuccess('Role successfully updated.');
        return back();
    }
    /**
     * Update the role.
     */
    public function updateRolePermissions(Request $request, Role $role)
    {

        //$role = Role::find($roleId);
        Gate::authorize('assignPermissions', $role);
        $request->validate([
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id'
        ]);
        $existingPermissions = Permission::whereIn('id', $request->input('permissions', []))->pluck('id')->toArray();
        $role->syncPermissions($existingPermissions);
        alertSuccess('Permissions successfully updated.');
        return back();
        /*$permissionIds = array_map('intval', $request->input('permissions', []));
        $missingPermissions = array_diff($permissionIds, $existingPermissions);
        if (!empty($missingPermissions)) {
            alertError('Invalid permission IDs: ' . implode(', ', $missingPermissions));
        }*/
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        Gate::authorize('delete', $role);
        $role->delete();
        alertSuccess('Role successfully deleted.');
        return back();
    }
}
