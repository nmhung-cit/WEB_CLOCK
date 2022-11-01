<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class imageProduct extends Model
{
    protected  $primaryKey = 'id_image';
    protected $fillable  = ['id_product','images','descriptions'];
    public  $timestamps = false;
}
