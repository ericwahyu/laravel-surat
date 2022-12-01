<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Format extends Model
{
    use HasFactory;
    protected $table = 'format';
    protected $primarykey = 'id';
    protected $fillable = [];
    public $incrementing = false;

    public function keperluan(){
        return $this->hasMany(Keperluan::class);
    }
}
