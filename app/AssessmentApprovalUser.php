<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssessmentApprovalUser extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'assessment_approval_id', 'user_id', 'status', 'note', 'ip',
    ];
    
    public function user() {
        return $this->belongsTo(User::class)->withTrashed();
    }
}
