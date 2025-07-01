<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DokumenWajib extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    public $timestamps = false;
}
