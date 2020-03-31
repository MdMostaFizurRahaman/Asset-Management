<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProcessUser extends Model {

    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'attachuser_id', 'user_id', 'delete_user_id', 'process_id', 'deleted_at', 'description',
    ];

    public function attachuser() {
        return $this->belongsTo(User::class, 'attachuser_id', 'id')->withTrashed();
    }

}
