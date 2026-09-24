<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'username',
        'password',
        'nama_lengkap',
        'nim_nik',
        'prodi_unit_id',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Jangan tambahkan 'password' => 'hashed' di sini
    public function prodiUnit()
    {
        return $this->belongsTo(ProdiUnit::class, 'prodi_unit_id');
    }

    public function pengajuanBerita()
    {
        return $this->hasMany(PengajuanBerita::class, 'user_id');
    }

    public function logAksi()
    {
        return $this->hasMany(LogAksiAdmin::class, 'admin_id');
    }
}