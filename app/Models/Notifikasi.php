<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    use HasFactory;
    protected $table = 'notifikasi';
    protected $primarykey = 'id';
    protected $fillable = [];

    public function disposisiUser(){
        return $this->belongsTo(Disposisiuser::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}
