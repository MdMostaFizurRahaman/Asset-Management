<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VendorEnlistment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'client_id', 'company_id', 'vendor_id','asset_permission', 'enlist_date', 'enlist_end_date', 'note', 'status','deleted_at'
    ];

    public function users() {
        return $this->belongsTo(User::class, 'user_id', 'id')->withTrashed();
    }
    public function clients() {
        return $this->belongsTo(Client::class)->withTrashed();
    }

    public function vendors() {
        return $this->belongsTo(VendorInfo::class, 'vendor_id', 'id')->withTrashed();
    }

    public function companies() {
        return $this->belongsTo(ClientCompany::class, 'company_id', 'id')->withTrashed();
    }
    public function attachments() {
        return $this->hasMany(VendorEnlistmentAttachment::class,'vendor_enlistment_id','id');
    }
}
