<?php

namespace App\Http\Controllers\admin;

use App\Asset;
use App\AssetBrand;
use App\AssetCategory;
use App\AssetHardware;
use App\AssetService;
use App\AssetStatus;
use App\AssetSubCategory;
use App\AssetTag;
use App\Client;
use App\ClientCompany;
use App\Department;
use App\Division;
use App\OfficeLocation;
use App\Store;
use App\Unit;
use App\Workflow;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-asset-read'])) {
            $subcategories = [];
            $assets = Asset::where('archive', 0);

            if ($request->title) {
                $assets->where('title', 'LIKE', '%' . $request->title . '%');
            }

            if ($request->category_id) {
                $assets->where('category_id', $request->category_id);
                $subcategories = AssetSubCategory::where([['category_id', $request->category_id], ['status', 1], ['public', 1]])->pluck('title', 'id')->all();
            }

            if ($request->sub_category_id) {
                $assets->where('sub_category_id', $request->sub_category_id);
            }

            if ($request->brand) {
                $assets->where('brand_id', $request->brand);
            }

            if ($request->model) {
                $assets->where('model', 'LIKE', '%' . $request->model . '%');
            }

            if ($request->supplier) {
                $assets->where('supplier', 'LIKE', '%' . $request->supplier . '%');
            }

            if ($request->purchase_from) {
                $assets->where('purchase_date', '>=', $request->purchase_from);
            }

            if ($request->purchase_to) {
                $assets->where('purchase_date', '<=', $request->purchase_to);
            }

            if ($request->installation_from) {
                $assets->where('installation_date', '>=', $request->installation_from);
            }

            if ($request->installation_to) {
                $assets->where('installation_date', '<=', $request->installation_to);
            }

            if ($request->guarantee) {
                if ($request->guarantee == 101) {
                    $assets->where('guarantee', 0);
                } else {
                    $assets->where('guarantee', $request->guarantee);
                }
            }
            if ($request->client) {
                $assets->where('client_id', $request->client);
            }
            if ($request->company) {
                $assets->where('company_id', $request->company);
            }

            if ($request->workflow) {
                $assets->where('workflow_id', $request->workflow);
            }

            if ($request->division) {
                $assets->where('division_id', $request->division);
            }

            if ($request->department) {
                $assets->where('department_id', $request->department);
            }

            if ($request->location) {
                $assets->where('office_location_id', $request->location);
            }

            if ($request->store) {
                $assets->where('store_id', $request->store);
            }

            if ($request->status) {
                $assets->where('status', $request->status);
            }

            if ($request->get('tag')) {
                $assets->whereHas('tags', function ($query) use ($request) {
                    $query->where('asset_tag_id', $request->get('tag'));
                });
            }

            if ($request->get('service')) {
                $assets->whereHas('services', function ($query) use ($request) {
                    $query->where('asset_service_id', $request->get('service'));
                });
            }

            if ($request->get('hardware')) {
                $assets->whereHas('hardwares', function ($query) use ($request) {
                    $query->where('asset_hardware_id', $request->get('hardware'));
                });
            }

            $assets = $assets->with('category', 'subcategory', 'brand', 'client', 'company', 'department', 'division', 'unit', 'officelocation', 'store', 'assetstatus', 'tags', 'services', 'hardwares', 'workflow')->orderBy('created_at', 'DESC')->paginate(20);

            $categories = AssetCategory::where([['status', 1], ['public', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $brands = AssetBrand::where([['status', 1], ['public', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $statuses = AssetStatus::where('status', 1)->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $clients = Client::where('status', 1)->orderBy('name', 'ASC')->pluck('name', 'id')->all();
            $companies = ClientCompany::where('status', 1)->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $departments = Department::where('status', 1)->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $divisions = Division::where('status', 1)->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $units = Unit::where('status', 1)->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $locations = OfficeLocation::where('status', 1)->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $stores = Store::where('status', 1)->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $tags = AssetTag::where('status', 1)->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $services = AssetService::where([['status', 1], ['public', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $hardwares = AssetHardware::where([['status', 1], ['public', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $workflows = Workflow::where('status', 1)->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            return view('admin.assets.index', compact('assets', 'categories', 'subcategories', 'brands', 'statuses', 'clients', 'companies', 'departments', 'divisions', 'units', 'locations', 'stores', 'tags', 'services', 'hardwares', 'workflows'));
        } else {
            return view('error.admin-unauthorised');
        }
    }
    public function archive(Request $request)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-asset-read'])) {
            $subcategories = [];
            $assets = Asset::where('archive', 1);

            if ($request->title) {
                $assets->where('title', 'LIKE', '%' . $request->title . '%');
            }

            if ($request->category_id) {
                $assets->where('category_id', $request->category_id);
                $subcategories = AssetSubCategory::where([['category_id', $request->category_id], ['status', 1], ['public', 1]])->pluck('title', 'id')->all();
            }

            if ($request->sub_category_id) {
                $assets->where('sub_category_id', $request->sub_category_id);
            }

            if ($request->brand) {
                $assets->where('brand_id', $request->brand);
            }

            if ($request->model) {
                $assets->where('model', 'LIKE', '%' . $request->model . '%');
            }

            if ($request->supplier) {
                $assets->where('supplier', 'LIKE', '%' . $request->supplier . '%');
            }

            if ($request->purchase_from) {
                $assets->where('purchase_date', '>=', $request->purchase_from);
            }

            if ($request->purchase_to) {
                $assets->where('purchase_date', '<=', $request->purchase_to);
            }

            if ($request->installation_from) {
                $assets->where('installation_date', '>=', $request->installation_from);
            }

            if ($request->installation_to) {
                $assets->where('installation_date', '<=', $request->installation_to);
            }

            if ($request->guarantee) {
                if ($request->guarantee == 101) {
                    $assets->where('guarantee', 0);
                } else {
                    $assets->where('guarantee', $request->guarantee);
                }
            }
            if ($request->client) {
                $assets->where('client_id', $request->client);
            }

            if ($request->company) {
                $assets->where('company_id', $request->company);
            }

            if ($request->workflow) {
                $assets->where('workflow_id', $request->workflow);
            }

            if ($request->division) {
                $assets->where('division_id', $request->division);
            }

            if ($request->department) {
                $assets->where('department_id', $request->department);
            }

            if ($request->location) {
                $assets->where('office_location_id', $request->location);
            }

            if ($request->store) {
                $assets->where('store_id', $request->store);
            }

            if ($request->status) {
                $assets->where('status', $request->status);
            }

            if ($request->get('tag')) {
                $assets->whereHas('tags', function ($query) use ($request) {
                    $query->where('asset_tag_id', $request->get('tag'));
                });
            }

            if ($request->get('service')) {
                $assets->whereHas('services', function ($query) use ($request) {
                    $query->where('asset_service_id', $request->get('service'));
                });
            }

            if ($request->get('hardware')) {
                $assets->whereHas('hardwares', function ($query) use ($request) {
                    $query->where('asset_hardware_id', $request->get('hardware'));
                });
            }

            $assets = $assets->with('category', 'subcategory', 'brand', 'client', 'company', 'department', 'division', 'unit', 'officelocation', 'store', 'assetstatus', 'tags', 'services', 'hardwares', 'workflow')->orderBy('created_at', 'DESC')->paginate(20);

            $categories = AssetCategory::where([['status', 1], ['public', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $brands = AssetBrand::where([['status', 1], ['public', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $statuses = AssetStatus::where('status', 1)->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $clients = Client::where('status', 1)->orderBy('name', 'ASC')->pluck('name', 'id')->all();
            $companies = ClientCompany::where('status', 1)->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $departments = Department::where('status', 1)->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $divisions = Division::where('status', 1)->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $units = Unit::where('status', 1)->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $locations = OfficeLocation::where('status', 1)->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $stores = Store::where('status', 1)->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $tags = AssetTag::where('status', 1)->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $services = AssetService::where([['status', 1], ['public', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $hardwares = AssetHardware::where([['status', 1], ['public', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $workflows = Workflow::where('status', 1)->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            return view('admin.assets.archive', compact('assets', 'categories', 'subcategories', 'brands', 'statuses', 'clients', 'companies', 'departments', 'divisions', 'units', 'locations', 'stores', 'tags', 'services', 'hardwares', 'workflows'));
        } else {
            return view('error.admin-unauthorised');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-asset-read'])){
            $asset = Asset::findOrFail($id);
            return view('admin.assets.show', compact('asset'));
    }else {
        return view('error.admin-unauthorised');
    }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function subcategories()
    {

        $subcategories = AssetSubCategory::where('category_id', $_POST['category_id'])->where('status', 1)->orderBy('title', 'ASC')->pluck('title', 'id');

        $data = '<option value=""></option>';

        if (isset($_POST['index'])) {
            if (isset($_POST['includeAll']) && $_POST['includeAll'] == 1) {
                $data = '<option value="0">All</option>';
            }
        } else {
            if (isset($_POST['includeAll']) && $_POST['includeAll'] == 1) {
                $data = '<option value="">Choose an option</option>';
            }
        }
        foreach ($subcategories as $key => $subcategory) {
            $data .= '<option value="' . $key . '">' . $subcategory . '</option>';
        }

        return $data;
    }
}
