<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aduan extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'deskripsi',
        'images',
        'status',
        'tanggal',
        'nama_pengadu',
    ];
}
