<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PihakTTD extends Model
{
    use HasFactory;
    protected $table = 'pihak_ttd';
    protected $primarykey = 'id';
    protected $fillable = [];

    public function generate(){
        return $this->belongsTo(Generate::class);
    }
}
