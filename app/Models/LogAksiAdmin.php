<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogAksiAdmin extends Model
{
    use HasFactory;

    protected $table = 'log_aksi_admin';

    const UPDATED_AT = null;

    protected $fillable = [
        'pengajuan_id',
        'admin_id',
        'status_sebelumnya',
        'status_baru',
        'catatan',
    ];

    // Relasi: Log ini merujuk pada satu Pengajuan
    public function pengajuan()
    {
        return $this->belongsTo(PengajuanBerita::class, 'pengajuan_id');
    }

    // Relasi: Log ini dilakukan oleh satu Admin (User)
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
