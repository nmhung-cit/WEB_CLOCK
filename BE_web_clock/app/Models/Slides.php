<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slides extends Model
{
    protected  $primaryKey = 'id_slide';
    protected $fillable  = ['image'];
    public  $timestamps = false;
}
