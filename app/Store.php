<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'company_id', 'client_id', 'user_id', 'office_location_id', 'title', 'status', 'deleted_at',
    ];

    public function location()
    {
        return $this->belongsTo(OfficeLocation::class,'office_location_id','id')->withTrashed();
    }
}
