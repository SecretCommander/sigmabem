<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kegiatan extends Model
{
    protected $table = 'Kegiatan';
    protected $primaryKey = 'ID_Kegiatan';
    public $timestamps = false;

    protected $fillable = [
        'Nama_Kegiatan',
        'Deskripsi_Kegiatan',
        'Tanggal_Pelaksanaan',
        'Jenis_RAB',
        'ID_Pengguna',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
