<?php

namespace App;

use Laratrust\Models\LaratrustRole;

class Role extends LaratrustRole {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'display_name', 'description', 'type', 'user_id',
    ];

}
