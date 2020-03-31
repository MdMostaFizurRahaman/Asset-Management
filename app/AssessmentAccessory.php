<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssessmentAccessory extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'accessory_id', 'assessment_id',
    ];

}
