<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitKerja extends Model
{
    use HasFactory;
    protected $table = 'unit_kerja';
    protected $primarykey = 'id';
    protected $fillable = [];

    public function dosen(){
        return $this->belongsToMany(Dosen::class);
    }

    public function mahasiswa(){
        return $this->hasMany(Mahasiswa::class);
    }

}
