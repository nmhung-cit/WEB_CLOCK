<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class ShipmentDetails extends Model
{
    protected $primaryKey = 'id_shipment_details';
    protected $fillable = ['id_user','name','surname','phone_number','city_province','district','wards','address'];
}
