<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Riwayat extends Model
{
    use HasFactory;
    protected $table = 'riwayat';
    protected $primarykey = 'id';
    protected $fillable = [];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
