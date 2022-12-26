<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jenis extends Model
{
    use HasFactory;
    protected $table = 'jenis';
    protected $primarykey = 'id';
    protected $fillable = [];

    public function surat(){
        return $this->hasMany(Surat::class);
    }
}
