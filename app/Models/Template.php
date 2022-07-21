<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;
    protected $table = 'template';
    protected $primarykey = 'id';
    protected $fillable = [];

    public function surat(){
        return $this->belongsToMany(Surat::class);
    }

}
