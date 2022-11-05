<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Generate extends Model
{
    use HasFactory;
    protected $table = 'generate';
    protected $primarykey = 'id';
    protected $fillable = [];

    public function pihak(){
        return $this->hasMany(PihakTTD::class);
    }

    public function template(){
        return $this->belongsTo(Template::class);
    }

    public function keperluan(){
        return $this->belongsTo(Keperluan::class);
    }


}

