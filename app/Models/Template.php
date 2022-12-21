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

    // public function surat(){
    //     return $this->belongsToMany(Surat::class);
    // }

    public function generate(){
        return $this->hasMany(Generate::class);
    }

    public function surat(){
        return $this->belongsToMany(Surat::class, 'generate', 'template_id', 'surat_id')->withPivot('content');
    }

    public function role(){
        return $this->belongsTo(Role::class);
    }

}
