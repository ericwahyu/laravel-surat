<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    use HasFactory;
    protected $table = 'surat';
    protected $primarykey = 'id';
    protected $fillable = [];

    public function jenis(){
        return $this->belongsTo(Jenis::class);
    }

    public function generate(){
        return $this->belongsTo(Generate::class);
    }

    public function disposisi(){
        return $this->hasMany(Disposisi::class);
    }

    public function catatan(){
        return $this->hasMany(Catatan::class);
    }
}
