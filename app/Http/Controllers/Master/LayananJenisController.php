<?php

namespace App\Http\Controllers\Master;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\DokumenWajib;
use App\Models\LayananJenis;
use App\Models\LayananKategori;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class LayananJenisController extends Controller
{
    public static function middleware(): array  
    {
        return [
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('layanan-jenis-list'), only:['index', 'data']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('layanan-jenis-create'), only:['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('layanan-jenis-edit'), only:['edit', 'update']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('layanan-jenis-delete'), only:['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public $section = 'Master';
    public $title = 'Jenis Layanan';

    public function index()
    {
        $kategoris = LayananKategori::all()->pluck('name', 'id');
        $dokumenWajibs = DokumenWajib::all()->pluck('name', 'id');
        return view('fitur.master.layanan_jenis.index', [
            'section' => $this->section,
            'title' => $this->title,
            'table_id' => 'tb_jenis_layanan',
            'kategoris' => $kategoris,
            'dokumenWajibs' => $dokumenWajibs,
        ]);
    }

    public function data(Request $request)
    {
        $data = LayananJenis::with('layanan_kategori', 'dokumen_wajibs')
            ->when($request->layanan_kategori_id, function($query) use($request){
                $query->where('layanan_kategori_id', $request->layanan_kategori_id);
            })
            ->orderBy('name', 'ASC')->get();
        return ResponseHelper::success($data, $this->title . ' retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'layanan_kategori_id' => 'required',
            'dokumen_wajib_id.*' => 'required',
            'description' => 'nullable|string',
        ]);

        $data = LayananJenis::updateOrCreate(
            ['id' => $request->data_id],
            [
                'name' => $request->name, 
                'layanan_kategori_id' => $request->layanan_kategori_id, 
                'description' => $request->description
            ]
        );

        $data->dokumen_wajibs()->sync($request->dokumen_wajib_id);

        return ResponseHelper::success($data, $this->title . ' saved successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = LayananJenis::with('layanan_kategori', 'dokumen_wajibs')->findOrFail($id);
        return ResponseHelper::success($data, $this->title . ' showing successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = LayananJenis::findOrFail($id);
        $data->delete();
        return ResponseHelper::success($data, $this->title . ' deleted successfully');
    }
}