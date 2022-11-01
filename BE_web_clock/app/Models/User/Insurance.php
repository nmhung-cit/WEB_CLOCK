<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    protected  $primaryKey = 'id_insurances';
    protected $fillable  = ['id_product','content'];
    public $timestamps = false;
}