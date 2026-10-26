<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdiUnit extends Model
{
    use HasFactory;

    protected $table = 'prodi_unit';
    public $timestamps = false; // Tabel ini tidak menggunakan created_at & updated_at

    protected $fillable = [
        'nama_prodi_unit',
    ];

    // Relasi: Satu prodi/unit memiliki banyak user
    public function users()
    {
        return $this->hasMany(User::class, 'prodi_unit_id');
    }
}
