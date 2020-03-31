<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssessmentApprovalUserArchive extends Model
{
    protected $fillable = [
        'assessment_approval_id', 'process_id','user_id',
    ];

    public function user() {
        return $this->belongsTo(User::class,'user_id','id')->withTrashed();
    }

}
