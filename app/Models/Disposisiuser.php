<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disposisiuser extends Model
{
    use HasFactory;
    protected $table = 'disposisi_user';
    protected $primarykey = 'id';
    protected $fillable = [];

    public function response(){
        return $this->belongsTo(Response::class);
    }

    public function notifikasi(){
        return $this->belongsTo(Notifikasi::class);
    }
}
