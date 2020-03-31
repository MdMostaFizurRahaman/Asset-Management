<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assessment extends Model
{

    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'asset_id', 'status', 'deleted', 'deleted_at', 'vendor_id', 'workflow_id', 'total_steps', 'current_steps', 'required_days', 'submit_date', 'cost', 'note',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class)->withTrashed();
    }

    public function vendor()
    {
        return $this->belongsTo(VendorInfo::class,'vendor_id','id')->withTrashed();
    }

    public function workflow()
    {
        return $this->belongsTo(Workflow::class)->withTrashed();
    }

    public function services()
    {
        return $this->hasMany(AssessmentService::class);
    }

    public function accessories()
    {
        return $this->hasMany(AssessmentAccessory::class);
    }

    public function currentstep()
    {
        return $this->belongsTo(Process::class, 'current_steps', 'id')->withTrashed();
    }

    public function approvals()
    {
        return $this->hasMany(AssessmentApproval::class);
    }

}
