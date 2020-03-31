<?php

namespace App;

use Laratrust\Models\LaratrustTeam;

class Team extends LaratrustTeam{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'display_name', 'description',
    ];

}
