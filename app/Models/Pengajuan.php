<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengajuan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function pengajuan_details() {
        return $this->hasMany(PengajuanDetail::class);
    }

    public function layanan_jenis() {
        return $this->belongsTo(LayananJenis::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
