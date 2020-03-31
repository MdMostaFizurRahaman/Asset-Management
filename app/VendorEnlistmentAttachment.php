<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorEnlistmentAttachment extends Model
{
    protected $fillable = [
        'user_id','vendor_enlistment_id','title', 'filename','note',
    ];
    public function users()
    {
        return $this->belongsTo(User::class,'user_id','id')->withTrashed();
    }
}
