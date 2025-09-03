<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User, Role, Permission, Setting};
use Illuminate\Support\Facades\Hash;

// RoleController.php
class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->latest()->paginate(10);
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all()->groupBy('group');
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|unique:roles,name',
            'guard_name' => 'required|max:255',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        $role = Role::create([
            'name' => $request->name,
            'guard_name' => $request->guard_name,
        ]);

        if ($request->has('permissions')) {
            $role->permissions()->attach($request->permissions);
        }

        return redirect()->route('admin.roles.index')
                        ->with('success', 'Role berhasil ditambahkan!');
    }

    public function show(Role $role)
    {
        return view('admin.roles.show', compact('role'));
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all()->groupBy('group');
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|max:255|unique:roles,name,' . $role->id,
            'guard_name' => 'required|max:255',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        $role->update([
            'name' => $request->name,
            'guard_name' => $request->guard_name,
        ]);

        $role->permissions()->sync($request->permissions ?? []);

        return redirect()->route('admin.roles.index')
                        ->with('success', 'Role berhasil diperbarui!');
    }

    public function destroy(Role $role)
    {
        if ($role->users()->count() > 0) {
            return redirect()->route('admin.roles.index')
                            ->with('error', 'Role tidak dapat dihapus karena masih digunakan!');
        }

        $role->delete();

        return redirect()->route('admin.roles.index')
                        ->with('success', 'Role berhasil dihapus!');
    }
}