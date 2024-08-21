<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Study extends Model
{
    use HasFactory;

    protected $fillable = ['npm', 'nama', 'prodi', 'kode_mk', 'nama_mk', 'sks', 'huruf', 'tahun', 'fakultas'];

    public $timestamps = false;
}
