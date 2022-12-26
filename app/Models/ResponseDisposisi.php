<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponseDisposisi extends Model
{
    use HasFactory;
    protected $table = 'response_disposisi';
    protected $primarykey = 'id';
    protected $fillable = [];

    public function response(){
        return $this->belongsTo(Response::class);
    }
}
