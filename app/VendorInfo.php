<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VendorInfo extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'address', 'phone', 'email', 'secondary_email', 'vendor_web_url', 'vendor_id', 'contact_person_name', 'contact_person_phone', 'contact_person_secondary_phone', 'contact_person_email', 'status', 'admin_id', 'deleted_at',
    ];

    public function roles() {
        return $this->hasMany(Role::class, 'user_id', 'id')->where('type', 3);
    }

    public function vendorExistence() {
        return $this->hasMany(VendorEnlistment::class, 'vendor_id', 'id');
    }

}
