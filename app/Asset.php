<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
{

    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'client_id', 'user_id', 'category_id', 'sub_category_id', 'brand_id', 'company_id', 'division_id', 'department_id', 'unit_id', 'office_location_id', 'store_id', 'archive', 'model', 'specification', 'supplier', 'vendor', 'purchase_date', 'installation_date', 'guarantee', 'status', 'deleted_at', 'image', 'workflow_id', 'assign_user', 'note', 'accept_reject_status', 'asset_number', 'purchase_value', 'is_depreciation', 'depreciation_type', 'depreciation_category', 'depreciation_value', 'current_purchase_value', 'qr_code_image',
    ];


    public function getFormattedIdAttribute()
    {
//        return str_pad($this->id,5,'0',STR_PAD_LEFT);
        return str_pad($this->asset_number, 5, '0', STR_PAD_LEFT);
    }

    public function tags()
    {
        return $this->belongsToMany(AssetTag::class)->withPivot('id')->whereNull('deleted_at');
    }

    public function category()
    {
        return $this->belongsTo(AssetCategory::class, 'category_id', 'id')->withTrashed();
    }

    public function client()
    {
        return $this->belongsTo(Client::class)->withTrashed();
    }

    public function workflow()
    {
        return $this->belongsTo(Workflow::class)->withTrashed();
    }

    public function subcategory()
    {
        return $this->belongsTo(AssetSubCategory::class, 'sub_category_id', 'id')->withTrashed();
    }

    public function brand()
    {
        return $this->belongsTo(AssetBrand::class)->withTrashed();
    }

    public function company()
    {
        return $this->belongsTo(ClientCompany::class)->withTrashed();
    }

    public function division()
    {
        return $this->belongsTo(Division::class)->withTrashed();
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function officelocation()
    {
        return $this->belongsTo(OfficeLocation::class, 'office_location_id', 'id')->withTrashed();
    }

    public function store()
    {
        return $this->belongsTo(Store::class)->withTrashed();
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class)->withTrashed();
    }

    public function assessments()
    {
        return $this->hasMany(Assessment::class);
    }

    public function attachments()
    {
        return $this->hasMany(AssetAttachment::class, 'asset_id', 'id');
    }

    public function assetstatus()
    {
        return $this->belongsTo(AssetStatus::class, 'status', 'id')->withTrashed();
    }

    public function services()
    {
        return $this->belongsToMany(AssetService::class)->withPivot('id')->whereNull('deleted_at');
    }

    public function hardwares()
    {
        return $this->belongsToMany(AssetHardware::class)->withPivot('id')->whereNull('deleted_at');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'assign_user', 'id')->withTrashed();
    }

    public function logs()
    {
        return $this->hasMany(AssetAssignLog::class)->orderBy('id', 'ASC')->with('actionUser', 'assignUser', 'returnStore', 'store', 'storeFrom', 'storeTo');
    }

}
