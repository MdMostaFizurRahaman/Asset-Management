<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Process extends Model {

    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id', 'user_id', 'workflow_id', 'title', 'type', 'minimum_no', 'process_type', 'description', 'status', 'order', 'deleted_at',
    ];

    public function workflow() {
        return $this->belongsTo(Workflow::class)->withTrashed();
    }

    public function users() {
        return $this->hasMany(ProcessUser::class)->with('attachuser');
    }

}
