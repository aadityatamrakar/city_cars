<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $table = 'sessions';

    protected $fillable = ['user_id', 'ip_addr','client','operating_system', 'device', 'brand_name', 'model'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
