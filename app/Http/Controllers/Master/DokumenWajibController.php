<?php

namespace App\Http\Controllers\Master;

use App\Helpers\EnumHelper;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\DokumenWajib;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class DokumenWajibController extends Controller
{
    public static function middleware(): array  
    {
        return [
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('layanan-kategori-list'), only:['index', 'data']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('layanan-kategori-create'), only:['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('layanan-kategori-edit'), only:['edit', 'update']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('layanan-kategori-delete'), only:['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public $section = 'Master';
    public $title = 'Dokumen Wajib';

    public function index()
    {
        $types = EnumHelper::getEnumValues('dokumen_wajibs', 'type');
        return view('fitur.master.dokumen_wajib.index', [
            'section' => $this->section,
            'title' => $this->title,
            'table_id' => 'tb_dokumen_wajib',
            'types' => $types,
        ]);
    }

    public function data(Request $request)
    {
        $data = DokumenWajib::orderBy('name', 'ASC')->get();
        return ResponseHelper::success($data, $this->title . ' retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $data = DokumenWajib::updateOrCreate(
            ['id' => $request->data_id],
            [
                'name' => $request->name, 
                'type' => $request->type, 
                'description' => $request->description
            ]
        );

        return ResponseHelper::success($data, $this->title . ' saved successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = DokumenWajib::findOrFail($id);
        return ResponseHelper::success($data, $this->title . ' showing successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = DokumenWajib::findOrFail($id);
        $data->delete();
        return ResponseHelper::success($data, $this->title . ' deleted successfully');
    }
}