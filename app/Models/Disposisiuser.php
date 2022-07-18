<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disposisiuser extends Model
{
    use HasFactory;
    protected $table = 'disposisi_user';
    protected $primarykey = 'id';
    protected $fillable = [];
}
