<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class RoleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('role-list'), only:['index', 'data']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('role-create'), only:['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('role-edit'), only:['edit', 'update']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('role-delete'), only:['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public $section = 'User';
    public $title = 'Role';
    
    public function index()
    {
        return view('fitur.user.role.index', [
            'section' => $this->section,
            'title' => $this->title,
            'table_id' => 'tb_role',
        ]);
    }

    public function data(Request $request)
    {
        $data = Role::with('permissions')->get();
        return ResponseHelper::success($data, $this->title . ' retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            // Simpan atau perbarui data
            $data = Role::updateOrCreate(
                ['id' => $request->data_id],
                [
                    'name' => $request->name, 
                    'guard_name' => 'web', 
                ]
            );

            // Sinkronisasi permission
            $data->syncPermissions($request->permission_id);

            // Commit jika tidak ada error
            DB::commit();

            return ResponseHelper::success($data, 'Data ' . $this->title . ' saved successfully');
        } catch (\Exception $e) {
            // Rollback jika terjadi error
            DB::rollBack();
            return ResponseHelper::error('Terjadi kesalahan: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = Role::with('permissions')->findOrFail($id);
        return ResponseHelper::success($data, $this->title . ' showing successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Role::findOrFail($id);
        $data->delete();
        return ResponseHelper::success($data, $this->title . ' deleted successfully');
    }
}
