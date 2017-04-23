<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'reports';

    protected $fillable = ['type', 'title', 'table', 'headers', 'columns', 'query', 'params', 'user_id'];
}
