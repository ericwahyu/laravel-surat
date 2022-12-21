<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kode extends Model
{
    use HasFactory;
    protected $table = 'kode';
    protected $primarykey = 'id';
    protected $fillable = [];

    public function generate(){
        return $this->hasMany(Generate::class);
    }

    public function role(){
        return $this->belongsTo(Role::class);
    }
}
