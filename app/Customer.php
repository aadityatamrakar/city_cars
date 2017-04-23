<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';

    protected $fillable = ['name', 'email', 'mobile1', 'mobile2', 'city', 'dob', 'pincode', 'address', 'autocard', 'user_id'];

    protected $dates = ['dob'];

    public function vehicles()
    {
        return $this->hasMany('App\Vehicle');
    }

    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }
}
