<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriBerita extends Model
{
    use HasFactory;

    protected $table = 'kategori_berita';
    public $timestamps = false;

    protected $fillable = [
        'nama_kategori',
    ];

    public function pengajuanBerita()
    {
        return $this->hasMany(PengajuanBerita::class, 'kategori_id');
    }
}
