<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Collection;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

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
        return $this->belongsToMany(Disposisi::class, 'disposisi_user', 'disposisi_id', 'user_id');
    }

    public function catatan(){
        return $this->hasMany(Catatan::class);
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

    public function isUnitKerja(){
        $mahasiswa = Mahasiswa::where('user_id', $this->id)->get();
        $dosen = Dosen::where('user_id', $this->id)->get();

        if($mahasiswa->isNotEmpty()){
            foreach($mahasiswa as $id_maha){
                $unit_kerja[] = array($id_maha->unit_kerja->id, $id_maha->unit_kerja->nama);
                // $unit_kerja = array("User");
            }
        }elseif($dosen->isNotEmpty()){
            foreach($dosen as $id_dos){
                $unit_dosen = Dosenunit::where('dosen_id', $id_dos->id)->get();
                if($unit_dosen->isEmpty()){
                     $unit_kerja = array("User");
                }else{
                    foreach($unit_dosen as $unit){
                        $unit_kerja[] = array($unit->unit_kerja->id, $unit->unit_kerja->nama);
                    }
                }
            }
        }
        // dd($unit_kerja);
        return $unit_kerja;
    }

    public function isRole(){
        $mahasiswa = Mahasiswa::where('user_id', $this->id)->get();
        $dosen = Dosen::where('user_id', $this->id)->get();

        if($mahasiswa->isNotEmpty()){
            foreach($mahasiswa as $id_maha){
                $role_mahasiswa = RoleMahasiswa::where('mahasiswa_id', $id_maha->id)->get();
                if($role_mahasiswa->isEmpty()){
                    $role = array("User");
                }else{
                    foreach($role_mahasiswa as $roles){
                        $role[] = $roles->role->nama;
                    }
                }
            }
        }elseif($dosen->isNotEmpty()){
            foreach($dosen as $id_dos){
                $role_dosen = RoleDosen::where('dosen_id', $id_dos->id)->get();
                if($role_dosen->isEmpty()){
                     $role = array("User");
                }else{
                    foreach($role_dosen as $roles){
                        $role[] = $roles->role->nama;
                    }
                }
            }
        }
        // dd($role);
        return $role;
    }

    public function isAdmin(){
        $admin = $this->isRole();
        $data = count($admin);
        for($i = 0; $i < $data; $i++){
            if($admin[$i] === 'Admin'){
                return true;
                break;
            }
        }
        return false;
    }

    public function isPimpinan(){
        $pimpinan = $this->isRole();
        $data = count($pimpinan);

        for($i = 0; $i < $data; $i++){
            if($pimpinan[$i] === 'Pimpinan'){
                return true;
                break;
            }
        }
        return false;
    }

    public function isPengelola(){
        $pengelola = $this->isRole();
        $data = count($pengelola);

        for($i = 0; $i < $data; $i++){
            if($pengelola[$i] === 'Pengelola'){
                return true;
                break;
            }
        }
        return false;
    }

    public function isUser(){
        $user = $this->isRole();
        $data = count($user);

        for($i = 0; $i < $data; $i++){
            if($user[$i] === 'User'){
                return true;
                break;
            }
        }
        return false;
    }

    public function isFakultas(){
        $user = $this->isUnitKerja();
        $data = count($user);

        for($i = 0; $i < $data; $i++){
            if($user[$i][1] === 'Fakultas Teknik Elektro dan Teknologi Informasi'){
                return true;
                break;
            }
        }
        return false;
    }

    public function isInformatika(){
        $user = $this->isUnitKerja();
        $data = count($user);

        for($i = 0; $i < $data; $i++){
            if($user[$i][1] === 'Jurusan Teknik Informatika'){
                return true;
                break;
            }
        }
        return false;
    }

    public function isInformasi(){
        $user = $this->isUnitKerja();
        $data = count($user);

        for($i = 0; $i < $data; $i++){
            if($user[$i][1] === 'Jurusan Sistem Informasi'){
                return true;
                break;
            }
        }
        return false;
    }

    public function isElektro(){
        $user = $this->isUnitKerja();
        $data = count($user);

        for($i = 0; $i < $data; $i++){
            if($user[$i][1] === 'Jurusan Teknik Elektro'){
                return true;
                break;
            }
        }
        return false;
    }
}
