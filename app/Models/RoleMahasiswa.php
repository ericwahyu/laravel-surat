<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleMahasiswa extends Model
{
    use HasFactory;
    protected $table = 'role_mahasiswa';
    protected $primarykey = 'id';
    protected $fillable = [];

    public function role(){
        return $this->belongsTo(Role::class);
    }
}
