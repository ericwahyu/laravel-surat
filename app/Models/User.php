<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'users';
    protected $primarykey = 'id';
    protected $fillable = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    // protected $hidden = [
    //     'password',
    //     'remember_token',
    // ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];

    public function disposisi(){
        return $this->belongsToMany(Disposisi::class);
    }

    public function dosen(){
        return $this->hasMany(Dosen::class);

    }

    public function mahasiswa(){
        return $this->hasMany(Mahasiswa::class);
    }

    public function riwayat(){
        return $this->hasMany(Riwayat::class);
    }

    public function isMahasiswa(){
        $mahasiswa = Mahasiswa::all();
        $unit_kerja = UnitKerja::all();

        foreach($mahasiswa as $cek_mahasiswa){
            if($cek_mahasiswa->user_id == $this->id){
                $mahasiswa_unitkerja = $cek_mahasiswa->unit_kerja_id;
                return $mahasiswa_unitkerja;
            }
        }
    }

    public function isAdmin(){
        $admin = $this->isMahasiswa();
        if($admin == 4){
            return true;
        }else{
            return false;
        }
    }

    public function isPengelola(){
        $pengelola = $this->isMahasiswa();
        if($pengelola == 2){
            return true;
        }else{
            return false;
        }
    }
}
