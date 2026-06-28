<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Support\Rbac;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(Request $request): View
    {
        abort_unless($request->user()->can('role.read'), 403);

        $roles = Role::withCount('users')->orderBy('name')->get();

        return view('roles.index', compact('roles'));
    }

    public function show(Request $request, string $role): View
    {
        abort_unless($request->user()->can('role.read'), 403);

        $role = Role::with('users.village', 'permissions')->findOrFail($role);
        $matrix = Rbac::matrix()[$role->code->value] ?? [];

        return view('roles.show', compact('role', 'matrix'));
    }
}
