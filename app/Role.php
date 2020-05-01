<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $casts = [
        'created_at' => 'date:Y-m-d',
    ];

    protected $fillable = [
        'name',
    ];
}

