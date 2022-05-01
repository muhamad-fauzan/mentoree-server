<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
class mentor extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'nama_depan',
        'nama_belakang',
        'email',
        'password',
        'alamat',
        'pekerjaan',
        'id_bidang',
        'latar_belakang',
        'tarif',
        'pendidikan',
    ];
    
    
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}

