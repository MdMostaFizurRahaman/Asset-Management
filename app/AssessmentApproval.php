<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class AssessmentApproval extends Model {

    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'process_id', 'assessment_id', 'status', 'type', 'deleted_at',
    ];

    public function process() {
        return $this->belongsTo(Process::class)->withTrashed();
    }

    public function assessment() {
        return $this->belongsTo(Assessment::class)->withTrashed();
    }

    public function approvalusers() {
        return $this->hasMany(AssessmentApprovalUser::class, 'assessment_approval_id', 'id');
    }
    public function approvaluserarchive() {
        return $this->hasMany(AssessmentApprovalUserArchive::class, 'assessment_approval_id', 'id')->with('user');
    }
    public function userapproved() {
        return $this->belongsTo(AssessmentApprovalUser::class, 'id', 'assessment_approval_id')->where('user_id', Auth::user()->id)->where('status', 1);
    }

    public function userreject() {
        return $this->belongsTo(AssessmentApprovalUser::class, 'id', 'assessment_approval_id')->where('user_id', Auth::user()->id)->where('status', 2);
    }

}
