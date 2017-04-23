<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $table = 'vehicles';

    protected $fillable = ['reg_no', 'chassis_no', 'engine_no', 'model', 'variant',
        'mfgyear', 'mi', 'insurance', 'warranty', 'warranty_exp', 'amc', 'amc_exp', 'customer_id',
        'finance', 'fuel', 'user_id'];

    protected $dates = ['amc_exp', 'warranty_exp'];

    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }

    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }
}
