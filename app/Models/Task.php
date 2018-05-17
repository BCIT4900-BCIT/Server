<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model {

    protected $table = 'tasks';
    protected $fillable = [
        'email',
        'groupid',
        'description',
        'start',
        'end',
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
        'saturday',
        'sunday',
        'alarm',
    ];

}
