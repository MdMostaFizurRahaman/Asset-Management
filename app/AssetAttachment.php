<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetAttachment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','asset_id','title', 'filename','note',
    ];
    public function users()
    {
        return $this->belongsTo(User::class,'user_id','id')->withTrashed();
    }
}
