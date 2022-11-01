<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class ProductDetails extends Model
{
    protected $primaryKey = 'id_productDetail';
    protected $fillable = ['id_product','batery','material','material_glass',
    'glass_size','glass_shape','waterproof_lever','color','origin'];
}
