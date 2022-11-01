<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected  $primaryKey = 'id_news';
    protected $fillable  = ['image','content','title'];
}
