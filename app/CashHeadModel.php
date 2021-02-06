<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CashHeadModel extends Model
{
    public $table = "cashhead";
    protected $fillable = [
        'cash_name', 'cash_amount',
    ];

    protected $hidden = [
        'remember_token',
    ];
}
