<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class PromotionProduct extends Model
{
    protected $primaryKey = 'id_promotion';
    protected $fillable = ['id_products','promotion_price'];
}
