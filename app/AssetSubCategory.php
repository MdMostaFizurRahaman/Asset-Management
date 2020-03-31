<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetSubCategory extends Model {

    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'admin_id', 'client_id', 'category_id', 'title', 'public', 'status', 'deleted_at', 'user_id',
    ];
    
    public function category() {
        return $this->belongsTo(AssetCategory::class)->withTrashed();
    }

}
