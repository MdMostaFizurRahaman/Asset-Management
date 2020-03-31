<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetAssignLog extends Model
{
    protected $fillable = [
        'type','user_id', 'asset_id', 'assign_user','accept_reject_status', 'is_return', 'note','store_id','return_store_id','store_from','store_to',
    ];

    public function actionUser(){
        return $this->belongsTo(User::class,'user_id','id')->withTrashed();
    }
    public function assignUser(){
        return $this->belongsTo(User::class,'assign_user','id')->withTrashed();
    }
    public function returnStore(){
        return $this->belongsTo(Store::class,'return_store_id','id')->withTrashed();
    }
    public function store(){
        return $this->belongsTo(Store::class,'store_id','id')->withTrashed();
    }
    public function storeFrom(){
        return $this->belongsTo(Store::class,'store_from','id')->withTrashed();
    }
    public function storeTo(){
        return $this->belongsTo(Store::class,'store_to','id')->withTrashed();
    }
}
