<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleDosen extends Model
{
    use HasFactory;
    protected $table = 'role_dosen';
    protected $primarykey = 'id';
    protected $fillable = [];

    public function role(){
        return $this->belongsTo(Role::class);
    }
}
