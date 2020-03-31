<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkflowLog extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id', 'user_id', 'title', 'status', 'description', 'workflow_id', 'action_user_id',
    ];

}
