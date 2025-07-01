<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use Spatie\Permission\Models\Role;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('account-list'), only:['index', 'data']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('account-create'), only:['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('account-edit'), only:['edit', 'update']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('account-delete'), only:['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public $section = 'User';
    public $title = 'Account';
    
    public function index()
    {
        $roles = Role::pluck('name', 'name');
        return view('fitur.user.account.index', [
            'section' => $this->section,
            'title' => $this->title,
            'table_id' => 'tb_account',
            'roles' => $roles,
        ]);
    }

    public function data(Request $request)
    {
        $data = User::with('roles')->get();
        return ResponseHelper::success($data, $this->title . ' retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'roles_id' => 'required',
            'email' => 'required|string|email|unique:users,email,' . $request->data_id,
            'password' => $request->data_id ? 'nullable|string|min:6' : 'required|string|min:6',
        ]);

        // Data untuk disimpan
        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        // Jika password diisi, hash sebelum disimpan
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        // Simpan atau perbarui data
        $user = User::updateOrCreate(['id' => $request->data_id], $data);
        $user->syncRoles($request->roles_id);

        return ResponseHelper::success($user, 'Data ' . $this->title . ' saved successfully');
    }

    public function updateStatus(Request $request, $id)
    {
        // Simpan Data
        $data = User::find($id)->update(['isAktif' => $request->status]);
        return ResponseHelper::success($data, $this->title . ' change status successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = User::findOrFail($id);
        return ResponseHelper::success($data, $this->title . ' showing successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = User::findOrFail($id);
        $data->delete();
        return ResponseHelper::success($data, $this->title . ' deleted successfully');
    }
}
