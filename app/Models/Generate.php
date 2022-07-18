<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Generate extends Model
{
    use HasFactory;
    protected $table = 'generate';
    protected $primarykey = 'id';
    protected $fillable = [];

    public function surat(){
        return $this->hasOne(Surat::class);
    }
}

