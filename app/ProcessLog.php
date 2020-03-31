<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProcessLog extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id', 'user_id', 'workflow_id', 'process_id', 'title', 'type', 'minimum_no', 'process_type', 'description', 'status', 'order', 'process_id', 'action_user_id',
    ];
}
