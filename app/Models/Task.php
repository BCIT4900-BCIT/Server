<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * The task model. Specifies the table name within the database
 * and the web apps' fillable values for inserts.
 * 
 * @author Michael Navarro
 */
class Task extends Model {

    protected $table = 'tasks';
    protected $fillable = [
        'email',
        'groupid',
        'description',
        'start',
        'end',
        'day',
        'alarm',
    ];

}
