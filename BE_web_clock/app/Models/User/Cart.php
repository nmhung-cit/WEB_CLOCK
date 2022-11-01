<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected  $primaryKey = 'id_cart';
    protected $fillable  = ['id_product','content'];
}
