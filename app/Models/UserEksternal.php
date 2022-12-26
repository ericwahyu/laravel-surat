<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEksternal extends Model
{
    use HasFactory;
    protected $table = 'user_eksternal';
    protected $primarykey = 'id';
    protected $fillable = [];
}
