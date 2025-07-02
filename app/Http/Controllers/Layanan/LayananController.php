<?php

namespace App\Http\Controllers\Layanan;

use App\Models\Pengajuan;
use App\Models\DokumenWajib;
use App\Models\LayananJenis;
use Illuminate\Http\Request;
use App\Helpers\UploadHelper;
use App\Helpers\ResponseHelper;
use App\Models\LayananKategori;
use App\Models\PengajuanDetail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class LayananController extends Controller
{
    public static function middleware(): array  
    {
        return [
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('pengajuan-list'), only:['index', 'data']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('pengajuan-create'), only:['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('pengajuan-edit'), only:['edit', 'update']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('pengajuan-delete'), only:['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public $section = 'Layanan';
    public $title = 'Pengajuan';

    public function index()
    {
        $kategoris = LayananKategori::all()->pluck('name', 'id');
        $jenis = LayananJenis::all()->pluck('name', 'id');
        $dokumenWajibs = DokumenWajib::all()->pluck('name', 'id');
        return view('fitur.layanan.pengajuan.index', [
            'section' => $this->section,
            'title' => $this->title,
            'table_id' => 'tb_jenis_layanan',
            'kategoris' => $kategoris,
            'jenis' => $jenis,
            'dokumenWajibs' => $dokumenWajibs,
        ]);
    }

    public function data(Request $request)
    {
        $data = Pengajuan::with('pengajuan_details', 'layanan_jenis', 'layanan_jenis.layanan_kategori', 'layanan_jenis.dokumen_wajibs', 'user')->get();
        return ResponseHelper::success($data, $this->title . ' retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dokumenIds = array_keys($request->file('file') ?? []);

        $dokumenWajibs = DokumenWajib::whereIn('id', $dokumenIds)->get()->keyBy('id');

        $rules = [
            'name' => 'required|string|max:255',
            'nik' => 'required|string|max:20',
            'layanan_kategori_id' => 'required|exists:layanan_kategoris,id',
            'layanan_jenis_id' => 'required|exists:layanan_jenis,id',
            'description' => 'nullable|string|max:1000',
            'file' => 'required|array',
        ];

        $messages = [];

        foreach ($dokumenIds as $id) {
            $mime = $dokumenWajibs[$id]->type !== 'all' ? $dokumenWajibs[$id]->type : 'jpg,jpeg,png,pdf';
            $rules["file.$id"] = "required|file|mimes:$mime|max:2048";
            $messages["file.$id.mimes"] = "Dokumen '{$dokumenWajibs[$id]->name}' harus berupa file dengan format: " . str_replace(',', ', ', $mime) . '.';
            $messages["file.$id.max"] = "Ukuran maksimum untuk dokumen '{$dokumenWajibs[$id]->name}' adalah 2MB.";
        }

        Validator::make($request->all(), $rules, $messages)->validate();

        DB::beginTransaction();
        try {
            $isNew = empty($request->data_id);
            $pengajuan = Pengajuan::updateOrCreate(
                ['id' => $request->data_id],
                [
                    'user_id' => Auth::id(),
                    'layanan_jenis_id' => $request->layanan_jenis_id,
                    'description' => $request->description,
                    'status' => 'pending',
                    'nomor_registrasi' => $isNew ? 'REG-' . now()->format('YmdHis') . rand(100, 999) : Pengajuan::find($request->data_id)?->nomor_registrasi,
                ]
            );

            foreach ($request->file('file') as $dokumen_id => $file) {
                $path = UploadHelper::update($file, uniqid(), 'uploads/pengajuan_details/', null);

                PengajuanDetail::updateOrCreate(
                    [
                        'pengajuan_id' => $pengajuan->id,
                        'dokumen_wajib_id' => $dokumen_id,
                    ],
                    [
                        'path' => $path,
                    ]
                );
            }

            DB::commit();

            return ResponseHelper::success($pengajuan, $this->title . ' saved successfully');

        } catch (\Throwable $e) {
            DB::rollBack();
            return ResponseHelper::error('Terjadi kesalahan saat menyimpan pengajuan.', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = Pengajuan::findOrFail($id);
        return ResponseHelper::success($data, $this->title . ' showing successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Pengajuan::findOrFail($id);
        $data->delete();
        return ResponseHelper::success($data, $this->title . ' deleted successfully');
    }
}