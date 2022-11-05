<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keperluan extends Model
{
    use HasFactory;
    protected $table = 'keperluan';
    protected $primarykey = 'id';
    protected $fillable = [];

    public function generate(){
        return $this->hasMany(Generate::class);
    }
}
