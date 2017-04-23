<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mailing extends Model
{
    protected $table='mailing';
    protected $fillable = ['title', 'report_id', 'cron_job', 'users', 'user_id'];

    public function report()
    {
        return $this->belongsTo('App\Report');
    }
}
