<?php

namespace Modules\Permission\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', User::class);
        $roles = Role::all();
        $employees = User::orderByRaw("id = ? desc", [Auth::id()])
            ->orderBy('created_at', 'desc')
            ->search('name')
            ->paginate(perPage())
            ->withQueryString();
        return view('permission::employee.index', [
            'roles' => $roles,
            'employees' => $employees
        ]);
    }

    /**
     * tt
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * GET User roles ids for matching id.
     */
    public function show($id)
    {
        $user = User::find($id);
        Gate::authorize('assignRole', $user);
        $userRoles = $user->roles->pluck('id')->toArray();
        return response()->json($userRoles);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('permission::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        Gate::authorize('assignRole', $user);
        $user->syncRoles($request->roles);
        alertSuccess('Roles successfully assigned.');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}

    public function changeStatus(Request $request, User $user)
    {
        Gate::authorize('changeStatus', $user);
        $user->status = !$user->status;
        $user->save();
        alertSuccess('Status successfully changed.');
        return back();
    }
}
