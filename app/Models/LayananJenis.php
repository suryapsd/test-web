<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LayananJenis extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    public $timestamps = false;

    public function layanan_kategori() {
        return $this->belongsTo(LayananKategori::class);
    }

    public function dokumen_wajibs()
    {
        return $this->belongsToMany(DokumenWajib::class, 'layanan_jenis_dokumen_wajib');
    }
}
