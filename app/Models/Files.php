<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Files extends Model
{
    use HasFactory;
    protected $table = 'file';
    protected $primarykey = 'id';
    protected $fillable = [];

    public function surat(){
        return $this->belongsTo(Surat::class);
    }
}
