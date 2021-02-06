<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Product extends Model
{
    public $table = "product";
    protected $fillable = [
        'product_name', 'product_price', 'product_amount',
    ];

    protected $hidden = [
        'remember_token',
    ];
}
