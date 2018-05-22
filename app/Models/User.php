<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * The user model. Specifies the table name within the database
 * and the web apps' fillable values for inserts.
 * 
 * @author Michael Navarro
 */
class User extends Model {

    protected $table = 'users';
    protected $fillable = [
        'email',
        'groupid',
        'password',
    ];

    public function tasks() {
        return $this->hasMany('Task');
    }

}
