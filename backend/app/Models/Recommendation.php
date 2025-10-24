<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    use HasFactory;

    protected $fillable = [
        'aduan_id',
        'rt_id',
        'recommended_status',
        'notes',
        'approval_status',
        'approved_by',
        'admin_notes',
        'approved_at',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    // Relasi ke Aduan
    public function aduan()
    {
        return $this->belongsTo(Aduan::class);
    }

    // Relasi ke RT (User yang kirim rekomendasi)
    public function rt()
    {
        return $this->belongsTo(User::class, 'rt_id');
    }

    // Relasi ke Admin (User yang approve/reject)
    public function admin()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Accessor untuk status approval text
    public function getApprovalStatusTextAttribute()
    {
        return match($this->approval_status) {
            'pending' => 'Menunggu Persetujuan',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            default => 'Unknown'
        };
    }

    // Accessor untuk recommended status text
    public function getRecommendedStatusTextAttribute()
    {
        return match($this->recommended_status) {
            1 => 'Menunggu Konfirmasi',
            2 => 'Dalam Proses',
            3 => 'Selesai',
            default => 'Unknown'
        };
    }
}