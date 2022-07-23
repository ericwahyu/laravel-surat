<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;
    protected $table = 'dosen';
    protected $primarykey = 'id';
    protected $fillable = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function unit_kerja(){
        return $this->belongsToMany(UnitKerja::class);
    }

}