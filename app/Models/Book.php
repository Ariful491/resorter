<?php

namespace App\Models;

use App\Models\Backend\Resort;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    public function  resort(){
        return $this->belongsTo(Resort::class);
    }
}
