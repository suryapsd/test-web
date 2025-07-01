<?php

namespace App\Http\Controllers\Master;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\LayananKategori;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class LayananKategoriController extends Controller
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
    public $title = 'Kategori Layanan';

    public function index()
    {
        return view('fitur.master.layanan_kategori.index', [
            'section' => $this->section,
            'title' => $this->title,
            'table_id' => 'tb_kategori_layanan',
        ]);
    }

    public function data(Request $request)
    {
        $data = LayananKategori::orderBy('name', 'ASC')->get();
        return ResponseHelper::success($data, $this->title . ' retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $data = LayananKategori::updateOrCreate(
            ['id' => $request->data_id],
            [
                'name' => $request->name, 
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
        $data = LayananKategori::findOrFail($id);
        return ResponseHelper::success($data, $this->title . ' showing successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = LayananKategori::findOrFail($id);
        $data->delete();
        return ResponseHelper::success($data, $this->title . ' deleted successfully');
    }
}