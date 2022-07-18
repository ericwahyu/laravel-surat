<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catatan extends Model
{
    use HasFactory;
    protected $table = 'catatan';
    protected $primarykey = 'id';
    protected $fillable = [];

    public function surat(){
        return $this->belongsTo(Surat::class);
    }

    public function disposisi(){
        return $this->belongsTo(Disposisi::class);
    }
}
