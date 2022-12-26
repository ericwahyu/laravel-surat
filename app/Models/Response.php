<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    use HasFactory;
    protected $table = 'response';
    protected $primarykey = 'id';
    protected $fillable = [];

    public function disposisiUser(){
        return $this->hasMany(Disposisiuser::class);
    }

    public function responseDisposisi(){
        return $this->hasMany(ResponseDisposisi::class);
    }
}
