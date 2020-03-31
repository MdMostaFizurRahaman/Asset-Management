<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Workflow extends Model {

    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id', 'user_id', 'title', 'status', 'deleted_at', 'description',
    ];
    
    public function processes() {
        return $this->hasMany(Process::class)->orderBy('order', 'ASC')->with('users');
    }
    
    public function activeprocesses() {
        return $this->hasMany(Process::class)->where('status', 1)->orderBy('order', 'ASC')->with('users');
    }
}
