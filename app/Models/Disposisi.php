<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disposisi extends Model
{
    use HasFactory;
    protected $table = 'disposisi';
    protected $primarykey = 'id';
    protected $fillable = [];

    public function surat(){
        return $this->belongsTo(Surat::class);
    }

    public function user(){
        return $this->belongsToMany(User::class, 'disposisi_user', 'disposisi_id', 'user_id');
    }
}
