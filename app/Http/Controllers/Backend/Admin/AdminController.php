<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Models\Admin;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Backend\Admin\StoreAdminRequest;
use App\Http\Requests\Backend\Admin\UpdateAdminRequest;

class AdminController extends Controller
{
    public function index()
    {
        $admins = Admin::with('permissions')->get();
        $permissions = Permission::all();

        return view('manager.admin.list_admin', compact('admins', 'permissions'));
    }



    public function store(StoreAdminRequest $request)
    {
        DB::transaction(function () use ($request) {

            $admin = Admin::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'status' => $request->has('status') ? 1 : 0,
            ]);

            if ($request->filled('permissions')) {
                $admin->permissions()->sync($request->permissions);
            }

            $admin->clearPermissionCache();
        });

        return redirect() ->route('admin.view')->with('success', 'Admin uğurla əlavə edildi.');
    }

    public function update(UpdateAdminRequest $request, $id)
    {
        DB::transaction(function () use ($request, $id) {

            $admin = Admin::findOrFail($id);

            $admin->update($request->validatedData());

            if ($request->filled('password')) {
                $admin->update([
                    'password' => Hash::make($request->password),
                ]);
            }

            $admin->permissions()->sync($request->permissions ?? []);

            $admin->clearPermissionCache();
        });

        return redirect()->route('admin.view')->with('success', 'Admin uğurla yeniləndi.');


    }


    public function destroy($id)
    {
        DB::transaction(function () use ($id) {

            $admin = Admin::findOrFail($id);

            // Permission əlaqələrini sil
            $admin->permissions()->detach();

            // Cache təmizlə (vacib)
            $admin->clearPermissionCache();

            // Admini sil
            $admin->delete();
        });

        return redirect()->route('admin.view')->with('success', 'Admin uğurla silindi.');


    }

}
