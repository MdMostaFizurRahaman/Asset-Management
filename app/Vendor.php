<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laratrust\Traits\LaratrustUserTrait;
use App\Notifications\VendorResetPasswordNotification;

class Vendor extends Authenticatable {

    use Notifiable, SoftDeletes, LaratrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email','username', 'password', 'status', 'email_verified_at','vendor_info_id','role_id', 'admin_id', 'deleted_at','api_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role() {
        return $this->belongsTo(Role::class);
    }
    public function vendorInfo() {
        return $this->belongsTo(VendorInfo::class);
    }

    public function sendPasswordResetNotification($token) {
        $this->notify(new VendorResetPasswordNotification($token));
    }

}
