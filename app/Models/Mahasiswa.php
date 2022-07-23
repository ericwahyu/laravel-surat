<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;
    protected $table = 'mahasiswa';
    protected $primarykey = 'id';
    protected $fillable = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function unit_kerja(){
        return $this->belongsTo(UnitKerja::class);
    }



}
