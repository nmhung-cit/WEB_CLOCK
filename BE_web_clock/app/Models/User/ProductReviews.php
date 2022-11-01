<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class ProductReviews extends Model
{
    protected  $primaryKey = 'id_reviews';
    protected $fillable  = ['id_product','id_user','id_order','star','comment','feedback'];
}
