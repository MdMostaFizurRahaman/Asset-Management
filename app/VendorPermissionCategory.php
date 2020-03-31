<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VendorPermissionCategory extends Model {

    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'status', 'deleted_at', 'admin_id',
    ];

    public function permissions() {
        return $this->belongsToMany(Permission::class)->withPivot('id');
    }

}
