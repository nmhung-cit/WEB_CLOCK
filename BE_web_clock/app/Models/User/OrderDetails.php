<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    protected  $primaryKey = 'id_orderdetails';
    protected $fillable  = ['id_order','id_product','color','totalmoneys','quantity'];
}
