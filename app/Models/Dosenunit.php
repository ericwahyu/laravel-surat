<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosenunit extends Model
{
    use HasFactory;
    protected $table = 'dosen_unit';
    protected $primarykey = 'id';
    protected $fillable = [];

}
