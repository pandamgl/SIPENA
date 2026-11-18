<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanBerita extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_berita';

    protected $fillable = [
        'user_id',
        'judul_berita',
        'kategori_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'narasi_berita',
        'link_dokumentasi',
        'kontak_person',
        'status',
        'link_publikasi',
    ];

    // Relasi: Pengajuan milik satu User (Pengaju)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi: Pengajuan memiliki satu Kategori Berita
    public function kategori()
    {
        return $this->belongsTo(KategoriBerita::class, 'kategori_id');
    }

    // Relasi: Pengajuan memiliki banyak rekam/log aksi admin
    public function logAksi()
    {
        return $this->hasMany(LogAksiAdmin::class, 'pengajuan_id');
    }

    // Relasi ke log aksi admin terbaru
    public function latestLogAksi()
    {
        return $this->hasOne(LogAksiAdmin::class, 'pengajuan_id')->latestOfMany();
    }

    // Accessor: Mengambil alasan reject dari log aksi admin terbaru yang berstatus Rejected
    public function getAlasanRejectAttribute()
    {
        if (!empty($this->attributes['catatan'])) {
            return $this->attributes['catatan'];
        }
        if (!empty($this->attributes['alasan_penolakan'])) {
            return $this->attributes['alasan_penolakan'];
        }
        $log = $this->logAksi()->where('status_baru', 'Rejected')->latest('id')->first();
        return $log ? $log->catatan : null;
    }
}
