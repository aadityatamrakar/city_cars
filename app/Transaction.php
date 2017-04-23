<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';

    protected $fillable = ['vehicle_id','transaction_type','amount','mobile','rating', 'remark', 'transaction_date', 'customer_id', 'user_id'];

    protected $dates = ['transaction_date'];

    public function vehicle()
    {
        return $this->belongsTo('App\Vehicle');
    }

    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }
}
