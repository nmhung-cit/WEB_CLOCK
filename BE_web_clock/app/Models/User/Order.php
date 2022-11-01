<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected  $primaryKey = 'id_order';
    protected $fillable  = ['id_user','id_shipment_Details','note','status'];
}
