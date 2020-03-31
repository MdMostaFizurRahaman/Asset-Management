<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssessmentService extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'service_id', 'assessment_id',
    ];

}
