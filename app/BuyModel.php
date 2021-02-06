<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BuyModel extends Model
{
    public $table = "buy";
    protected $fillable = [
        'cash_topup', 'cash_total'
    ];

    protected $hidden = [
        'remember_token',
    ];

}
