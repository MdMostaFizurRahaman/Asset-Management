<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetVendorPermission extends Model
{
    protected $fillable = [
        'user_id', 'asset_id', 'vendor_id', 'permission_end_date',
    ];

    public function vendors() {
        return $this->belongsTo(VendorInfo::class,'vendor_id','id')->withTrashed();
    }
}
