<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class PermissionController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission-list'), only:['index', 'data']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission-create'), only:['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission-edit'), only:['edit', 'update']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('permission-delete'), only:['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public $section = 'User';
    public $title = 'Permission';
    
    public function index()
    {
        return view('fitur.user.permission.index', [
            'section' => $this->section,
            'title' => $this->title,
            'table_id' => 'tb_permission',
        ]);
    }

    public function data(Request $request)
    {
        $data = Permission::orderBy('name', 'ASC')->get();
        return ResponseHelper::success($data, $this->title . ' retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'is_crud' => 'nullable',
            'data_id' => 'nullable|numeric',
        ]);
        
        if (isset($request->is_crud)) {
            // Jika CRUD aktif, buat multiple izin (list, create, edit, delete)
            $suffixes = ['-list', '-create', '-edit', '-delete'];
            $slug = Str::slug($request->name);

            $data = [];
            foreach ($suffixes as $suffix) {
                $data[] = Permission::create([
                    'name' => $slug . $suffix,
                    'guard_name' => 'web',
                ]);
            }
        } else {
            // Simpan atau perbarui satu izin biasa
            $data = Permission::updateOrCreate(
                ['id' => $request->data_id],
                [
                    'name' => $request->name,
                    'guard_name' => 'web',
                ]
            );
        }

        return ResponseHelper::success($data, 'Data ' . $this->title . ' saved successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = Permission::findOrFail($id);
        return ResponseHelper::success($data, $this->title . ' showing successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Permission::findOrFail($id);
        $data->delete();
        return ResponseHelper::success($data, $this->title . ' deleted successfully');
    }
}
