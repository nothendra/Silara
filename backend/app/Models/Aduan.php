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
        'foto',
        'status',
        'tanggal',
        'user_id',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessor untuk nama status
    public function getStatusTextAttribute()
    {
        return match ($this->status) {
            1 => 'Pending',
            2 => 'Dalam Proses',
            3 => 'Selesai',
            default => 'Unknown'
        };
    }

    //Accessor untuk URL foto
    public function getFotoUrlAttribute()
    {
        return $this->foto ? asset('storage/' . $this->foto) : null;
    }
    public function recommendations()
    {
        return $this->hasMany(Recommendation::class);
    }
}