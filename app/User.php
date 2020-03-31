<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laratrust\Traits\LaratrustUserTrait;
use App\Notifications\UserResetPasswordNotification;
use Illuminate\Support\Facades\Route;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes, LaratrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'status', 'email_verified_at', 'role_id', 'admin_id', 'client_id', 'user_id', 'phone', 'company_id', 'division_id', 'department_id', 'unit_id', 'office_location_id', 'designation_id',
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

    public function client() {
        return $this->belongsTo(Client::class,'client_id','id')->withTrashed();
    }

    public function company() {
        return $this->belongsTo(ClientCompany::class, 'company_id', 'id')->withTrashed();
    }

    public function division() {
        return $this->belongsTo(Division::class)->withTrashed();
    }

    public function department() {
        return $this->belongsTo(Department::class)->withTrashed();
    }

    public function unit() {
        return $this->belongsTo(Unit::class)->withTrashed();
    }

    public function designation() {
        return $this->belongsTo(Designation::class)->withTrashed();
    }

    public function officelocation() {
        return $this->belongsTo(OfficeLocation::class, 'office_location_id', 'id')->withTrashed();
    }

    public function sendPasswordResetNotification($token) {
        $subdomain = Route::input('subdomain');
        $this->notify(new UserResetPasswordNotification($subdomain, $token));
    }
    public function assets() {
        return $this->hasMany(Asset::class, 'assign_user', 'id')->where('status','1');
    }

}
