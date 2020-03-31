<?php

namespace App\Http\Controllers\client;

use App\Asset;
use App\AssetAssignLog;
use App\AssetAttachment;
use App\AssetCategory;
use App\AssetStatus;
use App\AssetTag;
use App\AssetSubCategory;
use App\AssetBrand;
use App\AssetService;
use App\AssetHardware;
use App\AssetVendorPermission;
use App\Department;
use App\ClientCompany;
use App\OfficeLocation;
use App\Division;
use App\Store;
use App\Unit;
use App\User;
use App\VendorEnlistment;
use App\VendorInfo;
use App\Workflow;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AssetController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index($subdomain, Request $request)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-assets-read'])) {
            $subcategories = [];
            $assets = Asset::where([['client_id', Auth::user()->client_id], ['archive', 0]]);

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

            $assets = $assets->with('category', 'subcategory', 'brand', 'company', 'department', 'division', 'unit', 'officelocation', 'store', 'assetstatus', 'tags', 'services', 'hardwares', 'workflow', 'attachments')->orderBy('created_at', 'DESC')->paginate(20);

            $categories = AssetCategory::where([['status', 1], ['public', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $brands = AssetBrand::where([['status', 1], ['public', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $statuses = AssetStatus::where('status', 1)->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $companies = ClientCompany::where([['client_id', Auth::user()->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $departments = Department::where([['client_id', Auth::user()->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $divisions = Division::where([['client_id', Auth::user()->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $units = Unit::where([['client_id', Auth::user()->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $locations = OfficeLocation::where([['client_id', Auth::user()->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $stores = Store::where([['client_id', Auth::user()->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $tags = AssetTag::where([['client_id', Auth::user()->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $services = AssetService::where([['status', 1], ['public', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $hardwares = AssetHardware::where([['status', 1], ['public', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $workflows = Workflow::where([['client_id', Auth::user()->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            return view('client.assets.index', compact('assets', 'subdomain', 'categories', 'subcategories', 'brands', 'statuses', 'companies', 'departments', 'divisions', 'units', 'locations', 'stores', 'tags', 'services', 'hardwares', 'workflows'));
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    public function create($subdomain)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-assets-create'])) {

            $categories = AssetCategory::where(function ($query) {
                $query->where('public', 1)->orWhere('user_id', Auth::user()->id);
            })->where('status', 1)->orderBy('title', 'ASC')->pluck('title', 'id')->all();

            $subcategories = $stores = [];

            if (old('category_id')) {
                $subcategories = AssetSubCategory::where('category_id', old('category_id'))->where(function ($query) {
                    $query->where('user_id', Auth::user()->id)->orWhere('public', 1);
                })->where('status', 1)->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            }

            $display = '';
            if (old('is_depreciation')) {
                $display = 1;
            }

            if (old('office_location_id')) {
                $stores = Store::where('office_location_id', old('office_location_id'))->where('client_id', Auth::user()->client_id)->where('status', 1)->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            }

            $brands = AssetBrand::where('status', 1)->where(function ($query) {
                $query->where('public', 1)->orWhere('user_id', Auth::user()->id);
            })->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $statuses = AssetStatus::where('status', 1)->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $companies = ClientCompany::where([['client_id', Auth::user()->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $departments = Department::where([['client_id', Auth::user()->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $divisions = Division::where([['client_id', Auth::user()->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $units = Unit::where([['client_id', Auth::user()->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $locations = OfficeLocation::where([['client_id', Auth::user()->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $tags = AssetTag::where([['client_id', Auth::user()->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $services = AssetService::where(function ($query) {
                $query->where('public', 1)->orWhere('user_id', Auth::user()->id);
            })->where('status', 1)->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $hardwares = AssetHardware::where(function ($query) {
                $query->where('public', 1)->orWhere('user_id', Auth::user()->id);
            })->where('status', 1)->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $workflows = Workflow::where([['client_id', Auth::user()->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            return view('client.assets.create', compact('subdomain', 'categories', 'subcategories', 'brands', 'statuses', 'companies', 'departments', 'divisions', 'units', 'locations', 'stores', 'tags', 'services', 'hardwares', 'workflows', 'display'));
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    public function store($subdomain, Request $request)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-assets-create'])) {

            $rules = [
                'title' => [
                    'required',
                    Rule::unique('assets')->where('client_id', Auth::user()->client_id)->whereNull('deleted_at'),
                ],
                'workflow_id' => 'required',
                'category_id' => 'required',
                'sub_category_id' => 'required',
                'brand_id' => 'required',
                'model' => 'required|max:255',
                'supplier' => 'required|max:255',
                'vendor' => 'required|max:255',
                'purchase_date' => 'required|date',
                'installation_date' => 'sometimes|nullable|date',
                'company_id' => 'required',
                'division_id' => 'required',
                'department_id' => 'required',
                'unit_id' => 'required',
                'office_location_id' => 'required',
                'store_id' => 'required',
                'status' => 'required',
                'purchase_value' => 'required|numeric',
                'depreciation_type' => 'required_if:is_depreciation,1',
                'depreciation_category' => 'required_if:is_depreciation,1',
                'depreciation_value' => [
                    'required_if:is_depreciation,1',
                    function ($attribute, $value, $fail) use ($request) {
                        if ($request->is_depreciation) {
                            if ($request->depreciation_type == 0 && $value > 100) {
                                return $fail('Depreciation value must be less than 100.');
                            } elseif ($request->depreciation_type == 1 && $value > $request->purchase_value) {
                                return $fail('Depreciation value must be less than or equal purchase value.');
                            }
                        }

                    }],
            ];

            $messages = [
                'workflow_id.required' => 'Please Select a workflow.',
                'category_id.required' => 'Please Select a category.',
                'sub_category_id.required' => 'Please Select a sub category.',
                'brand_id.required' => 'Please Select a brand name.',
                'company_id.required' => 'Please Select a company name.',
                'division_id.required' => 'Please Select a division.',
                'department_id.required' => 'Please Select a department.',
                'unit_id.required' => 'Please Select a unit.',
                'office_location_id.required' => 'Please Select an office location.',
                'store_id.required' => 'Please Select an store.',
                'depreciation_type.required_if' => 'The depreciation type field is required when is depreciation is checked.',
                'depreciation_category.required_if' => 'The depreciation category field is required when is depreciation is checked.',
                'depreciation_value.required_if' => 'The depreciation value field is required when is depreciation is checked.',

            ];

            $this->validate($request, $rules, $messages);

            $input = $request->all();

            if (!$request->has('is_depreciation')) {
                $input['is_depreciation'] = 0;
                $input['depreciation_type'] = null;
                $input['depreciation_category'] = null;
                $input['depreciation_value'] = null;
            }
            $input['user_id'] = Auth::user()->id;
            $input['client_id'] = Auth::user()->client_id;
            $input['current_purchase_value'] = $request->purchase_value;
            //dd($input);

            if ($request->file('image')) {
                $imagePath = Helper::uploadFile($request->file('image'), null, Config::get('constants.ASSET_IMAGE'));
                $input['image'] = $imagePath;
            }

            $asset = Asset::create($input);

            if ($request->get('tags')) {
                $asset->tags()->sync($request->get('tags'));
            }

            if ($request->get('services')) {
                $asset->services()->sync($request->get('services'));
            }

            if ($request->get('hardwares')) {
                $asset->hardwares()->sync($request->get('hardwares'));
            }

            $imagePath = Helper::generateQrCode($asset);

            $input['qr_code_image'] = $imagePath;
            $asset->update($input);

            //Asset Log
            $log['type'] = 1;
            $log['user_id'] = Auth::user()->id;
            $log['asset_id'] = $asset->id;
            $log['store_id'] = $asset->store_id;
            $log['note'] = $asset->note;
            $assignLog = AssetAssignLog::create($log);

            Session::flash('success', 'The Asset has been created');

            return redirect()->route('client.assets.index', $subdomain);

        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    public function show($subdomain, $id)
    {
        $asset = Asset::find($id);
        return view('client.assets.show', compact('asset', 'subdomain'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($subdomain, $id)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-assets-update'])) {
            $asset = Asset::find($id);
            $categories = AssetCategory::where(function ($query) {
                $query->where('public', 1)->orWhere('user_id', Auth::user()->id);
            })->where('status', 1)->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            if (old('category_id')) {
                $subcategories = AssetSubCategory::where('category_id', old('category_id'))->where(function ($query) {
                    $query->where('user_id', Auth::user()->id)->orWhere('public', 1);
                })->where('status', 1)->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            } else {
                $subcategories = AssetSubCategory::where('category_id', $asset->category_id)->where(function ($query) {
                    $query->where('user_id', Auth::user()->id)->orWhere('public', 1);
                })->where('status', 1)->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            }

            $brands = AssetBrand::where('status', 1)->where(function ($query) {
                $query->where('public', 1)->orWhere('user_id', Auth::user()->id);
            })->orderBy('title', 'ASC')->pluck('title', 'id')->all();

            $statuses = AssetStatus::where('status', 1)->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $companies = ClientCompany::where([['client_id', Auth::user()->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $departments = Department::where([['client_id', Auth::user()->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $divisions = Division::where([['client_id', Auth::user()->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $units = Unit::where([['client_id', Auth::user()->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $locations = OfficeLocation::where([['client_id', Auth::user()->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            if (old('office_location_id')) {
                $stores = Store::where('office_location_id', old('office_location_id'))->where('client_id', Auth::user()->client_id)->where('status', 1)->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            } else {
                $stores = Store::where('office_location_id', $asset->office_location_id)->where('client_id', Auth::user()->client_id)->where('status', 1)->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            }
            $tags = AssetTag::where([['client_id', Auth::user()->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $services = AssetService::where(function ($query) {
                $query->where('public', 1)->orWhere('user_id', Auth::user()->id);
            })->where('status', 1)->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $hardwares = AssetHardware::where(function ($query) {
                $query->where('public', 1)->orWhere('user_id', Auth::user()->id);
            })->where('status', 1)->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $workflows = Workflow::where([['client_id', Auth::user()->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            return view('client.assets.edit', compact('asset', 'subdomain', 'categories', 'subcategories', 'brands', 'statuses', 'companies', 'departments', 'divisions', 'units', 'locations', 'stores', 'tags', 'services', 'hardwares', 'workflows'));
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    /**
     * Update a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update($subdomain, Request $request, $id)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-assets-update'])) {
            $rules = [
                'title' => [
                    'required',
                    Rule::unique('assets')->where('client_id', Auth::user()->client_id)->whereNull('deleted_at')->ignore($id),
                ],
                'workflow_id' => 'required',
                'category_id' => 'required',
                'sub_category_id' => 'required',
                'brand_id' => 'required',
                'model' => 'required|max:255',
                'supplier' => 'required|max:255',
                'vendor' => 'required|max:255',
                'purchase_date' => 'required|date',
                'installation_date' => 'sometimes|nullable|date',
                'company_id' => 'required',
                'division_id' => 'required',
                'department_id' => 'required',
                'unit_id' => 'required',
                'office_location_id' => 'required',
                'store_id' => 'required',
                'status' => 'required',
                'purchase_value' => 'required|numeric',
                'depreciation_type' => 'required_if:is_depreciation,1',
                'depreciation_category' => 'required_if:is_depreciation,1',
                'depreciation_value' => [
                    'required_if:is_depreciation,1',
                    function ($attribute, $value, $fail) use ($request) {
                        if ($request->is_depreciation) {
                            if ($request->depreciation_type == 0 && $value > 100) {
                                return $fail('Depreciation value must be less than 100.');
                            } elseif ($request->depreciation_type == 1 && $value > $request->purchase_value) {
                                return $fail('Depreciation value must be less than or equal purchase value.');
                            }
                        }

                    }],
            ];

            $messages = [
                'workflow_id.required' => 'Please Select a workflow.',
                'category_id.required' => 'Please Select a category.',
                'sub_category_id.required' => 'Please Select a sub category.',
                'brand_id.required' => 'Please Select a brand name.',
                'company_id.required' => 'Please Select a company name.',
                'division_id.required' => 'Please Select a division.',
                'department_id.required' => 'Please Select a department.',
                'unit_id.required' => 'Please Select a unit.',
                'office_location_id.required' => 'Please Select an office location.',
                'store_id.required' => 'Please Select an store.',
                'depreciation_type.required_if' => 'The depreciation type field is required when is depreciation is checked.',
                'depreciation_category.required_if' => 'The depreciation category field is required when is depreciation is checked.',
                'depreciation_value.required_if' => 'The depreciation value field is required when is depreciation is checked.',
            ];

            $this->validate($request, $rules, $messages);

            $input = $request->all();
            $input['user_id'] = Auth::user()->id;

            if (!$request->has('is_depreciation')) {
                $input['is_depreciation'] = 0;
                $input['depreciation_type'] = null;
                $input['depreciation_category'] = null;
                $input['depreciation_value'] = null;
            }

            if ($request->file('image')) {
                $imagePath = Helper::uploadFile($request->file('image'), null, Config::get('constants.ASSET_IMAGE'));
                $input['image'] = $imagePath;
            }

            if (!$request->has('archive')) {
                $input['archive'] = 0;
            }


            $asset = Asset::find($id);
            $asset->update($input);

            if ($request->get('tags')) {
                $asset->tags()->sync($request->get('tags'));
            } else {
                $asset->tags()->sync([]);
            }

            if ($request->get('services')) {
                $asset->services()->sync($request->get('services'));
            } else {
                $asset->services()->sync([]);
            }

            if ($request->get('hardwares')) {
                $asset->hardwares()->sync($request->get('hardwares'));
            } else {
                $asset->hardwares()->sync([]);
            }
            //Asset Log
            if ($request->has('archive')) {
                $log['type'] = 10;
            } else {
                $log['type'] = 2;
            }

            $log['user_id'] = Auth::user()->id;
            $log['asset_id'] = $asset->id;
            $log['store_id'] = $asset->store_id;
            $assignLog = AssetAssignLog::create($log);

            //Qr Code Start
            $imagePath = Helper::generateQrCode($asset);

            $input['qr_code_image'] = $imagePath;
            $asset->update($input);

            if (1 <> 1) {
                $qrCode = QrCode::format('png')->size(600)->generate(Helper::generateQrCode($asset));

                $name = 'qr_' . $asset->id . '_' . Str::uuid() . '.png';
                $image = Image::make($qrCode)->fit(600, 600);

                //
                $qr_code_text_canvas = Image::canvas(600, 100);
                $qr_code_text_canvas->text(str_pad($asset->id, 6, '0', STR_PAD_LEFT), 160, 10, function ($font) {
                    $font->file(public_path('qr_font/Source_Sans_Pro/SourceSansPro-SemiBold.ttf'));
                    $font->size(90);
                    $font->valign('top');
                });


                $qr_merge_canvas = Image::canvas(600, 700);
                $qr_merge_canvas->insert($image);
                $qr_merge_canvas->insert($qr_code_text_canvas, 'bottom-left'); // add offset

                $imagePath = Helper::uploadFile(null, (string)$qr_merge_canvas->encode(), Config::get('constants.ASSET_QR_CODE_IMAGE'), $name);

                if ($qrCode && 1 <> 1) {
                    $imagePath = Helper::uploadFile(null, $qrCode, Config::get('constants.ASSET_QR_CODE_IMAGE'), null, null, '.png');
                    $input['qr_code_image'] = $imagePath;
                }
            }
            //End Qr Code

            Session::flash('success', 'The Asset has been updated');
            if ($asset->archive) {
                if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-assets-archive'])) {
                    return redirect()->route('client.assets.archive', $subdomain);
                } else {
                    return redirect()->route('client.assets.index', $subdomain);
                }
            } else {
                return redirect()->route('client.assets.index', $subdomain);
            }
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($subdomain, $id)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-assets-delete'])) {
            $asset = Asset::find($id);

            $asset->update([
                'user_id' => Auth::user()->id,
            ]);

            //Asset Log
            $log['type'] = 11;
            $log['user_id'] = Auth::user()->id;
            $log['asset_id'] = $asset->id;
            $log['store_id'] = $asset->store_id;

            $asset->delete();
            //Asset Log
            $assignLog = AssetAssignLog::create($log);

            Session::flash('success', 'The Asset has been deleted');
            return redirect()->back();
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    public function archive($subdomain, Request $request)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-assets-archive'])) {
            $subcategories = [];
            $assets = Asset::where([['client_id', Auth::user()->client_id], ['archive', 1]]);

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

            if ($request->company) {
                $assets->where('company_id', $request->company);
            }

            if ($request->division) {
                $assets->where('division_id', $request->division);
            }

            if ($request->workflow) {
                $assets->where('workflow_id', $request->workflow);
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

            $assets = $assets->with('category', 'subcategory', 'brand', 'company', 'department', 'division', 'unit', 'officelocation', 'store', 'assetstatus', 'tags', 'services', 'hardwares', 'workflow')->orderBy('created_at', 'DESC')->paginate(20);
            $categories = AssetCategory::where([['status', 1], ['public', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $brands = AssetBrand::where([['status', 1], ['public', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $statuses = AssetStatus::where('status', 1)->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $companies = ClientCompany::where([['client_id', Auth::user()->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $departments = Department::where([['client_id', Auth::user()->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $divisions = Division::where([['client_id', Auth::user()->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $units = Unit::where([['client_id', Auth::user()->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $locations = OfficeLocation::where([['client_id', Auth::user()->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $stores = Store::where([['client_id', Auth::user()->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $tags = AssetTag::where([['client_id', Auth::user()->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $services = AssetService::where([['status', 1], ['public', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $hardwares = AssetHardware::where([['status', 1], ['public', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            $workflows = Workflow::where([['client_id', Auth::user()->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();
            return view('client.assets.archive', compact('assets', 'subdomain', 'categories', 'subcategories', 'brands', 'statuses', 'companies', 'departments', 'divisions', 'units', 'locations', 'stores', 'tags', 'services', 'hardwares', 'workflows'));
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    public function subcategories($subdomain)
    {

        $subcategories = AssetSubCategory::where('category_id', $_POST['category_id'])->where(function ($query) {
            $query->where('user_id', Auth::user()->id)->orWhere('public', 1);
        })->where('status', 1)->orderBy('title', 'ASC')->pluck('title', 'id');

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

    // ajax request
    public function assetstore($subdomain)
    {
        $stores = Store::where('office_location_id', $_POST['office_location_id'])->where('client_id', Auth::user()->client_id)->where('status', 1)->orderBy('title', 'ASC')->pluck('title', 'id');

        $data = '<option value=""></option>';
        foreach ($stores as $key => $store) {
            $data .= '<option value="' . $key . '">' . $store . '</option>';
        }
        return $data;
    }

    /*
    *Asset Assign User Task
    */
    public function assignuser($subdomain, $id)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-assets-update'])) {
            $asset = Asset::findOrFail($id);
            if ($asset->assign_user == 0) {
                $users = User::where([['client_id', Auth::user()->client_id], ['office_location_id', $asset->office_location_id], ['status', 1]])->orderBy('name', 'ASC')->pluck('name', 'id')->all();
                return view('client.asset-assign-user.index', compact('asset', 'users', 'subdomain'));
            } else {
                Session::flash('warning', 'The Asset already has been Assigned');
                return redirect()->route('client.assets.index', $subdomain);
            }
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    public function assignuserstore($subdomain, Request $request, $id)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-assets-update'])) {
            $asset = Asset::findOrFail($id);
            $rules = [
                'assign_user' => 'required',

            ];

            $messages = [
                //
            ];

            $this->validate($request, $rules, $messages);
            if ($asset->assign_user == 0) {
                $input = $request->all();
                $input['user_id'] = Auth::user()->id;
                $asset->update($input);

                //Asset Log
                $log = $request->all();
                $log['type'] = 3;
                $log['user_id'] = Auth::user()->id;
                $log['asset_id'] = $asset->id;
                $log['store_id'] = $asset->store_id;
                $log['note'] = $request->assign_note;
                $assignLog = AssetAssignLog::create($log);

                Session::flash('success', 'The Asset has been Assigned');
                return redirect()->route('client.assets.index', $subdomain);
            } else {
                Session::flash('warning', 'The Asset already has been Assigned');
                return redirect()->route('client.assets.index', $subdomain);
            }

        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    public function returnaccept($subdomain, $id)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can('client-asset-return-approval-create')) {

            $asset = Asset::findOrFail($id);
            $assign_user = $asset->assign_user;
            $input['user_id'] = Auth::user()->id;
            $input['assign_user'] = 0;
            $input['accept_reject_status'] = 0;
            $asset->update($input);

            //Asset Log
            $log['type'] = 7;
            $log['user_id'] = Auth::user()->id;
            $log['asset_id'] = $asset->id;
            $log['assign_user'] = $assign_user;
            $log['accept_reject_status'] = 0;
            $log['is_return'] = 1;
            $log['store_id'] = $asset->store_id;
            $log['return_store_id'] = $asset->store_id;
            $assignLog = AssetAssignLog::create($log);
            Session::flash('success', 'The Asset Return has been Accepted');
            return redirect()->route('client.assets.index', $subdomain);

        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    public function returnreject($subdomain, $id)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can('client-asset-return-approval-create')) {
            $asset = Asset::findOrFail($id);
            return view('client.asset-assign-user.returnreject', compact('asset', 'subdomain'));
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    public function returnrejectstore($subdomain, $id, Request $request)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can('client-asset-return-approval-create')) {
            $asset = Asset::findOrFail($id);

            $messages = [

            ];

            $this->validate($request, [
                'reject_note' => 'required',
            ], $messages);

            $input['user_id'] = Auth::user()->id;
            $input['accept_reject_status'] = 1;
            $asset->update($input);

            //Asset Log
            $log['type'] = 8;
            $log['user_id'] = Auth::user()->id;
            $log['asset_id'] = $asset->id;
            $log['assign_user'] = $asset->assign_user;
            $log['accept_reject_status'] = 0;
            $log['store_id'] = $asset->store_id;
            $log['return_store_id'] = $asset->store_id;
            $log['note'] = $request->reject_note;
            $assignLog = AssetAssignLog::create($log);

            Session::flash('success', 'The Asset Return has been Rejected');
            return redirect()->route('client.assets.index', $subdomain);

        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    public function moveorder($subdomain, $id)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-assets-update'])) {
            $asset = Asset::findOrFail($id);
            if ($asset->assign_user == 0 && $asset->accept_reject_status == 0) {
                $locations = OfficeLocation::where([['client_id', Auth::user()->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();

                if (old('office_location_id')) {
                    $stores = Store::where('office_location_id', old('office_location_id'))->where(function ($query) {
                        $query->where('user_id', Auth::user()->id);
                    })->where('status', 1)->orderBy('title', 'ASC')->pluck('title', 'id')->all();
                } else {
                    $stores = Store::where('office_location_id', $asset->office_location_id)->where(function ($query) {
                        $query->where('user_id', Auth::user()->id);
                    })->where('status', 1)->orderBy('title', 'ASC')->pluck('title', 'id')->all();
                }
                return view('client.assets.moveorder', compact('asset', 'subdomain', 'locations', 'stores'));
            } else {
                Session::flash('warning', 'The Asset can not Move');
                return redirect()->route('client.assets.index', $subdomain);
            }
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    public function moveorderstore($subdomain, $id, Request $request)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-assets-update'])) {
            $asset = Asset::findOrFail($id);
            if ($asset->assign_user == 0 && $asset->accept_reject_status == 0) {
                $store_from = $asset->store_id;
                $messages = [

                ];
                $this->validate($request, [
                    'office_location_id' => 'required',
                    'store_id' => 'required',
                ], $messages);

                $input = $request->all();
                $input['user_id'] = Auth::user()->id;
                $asset->update($input);
                //Asset Log
                $log['type'] = 9;
                $log['user_id'] = Auth::user()->id;
                $log['asset_id'] = $asset->id;
                $log['store_from'] = $store_from;
                $log['store_to'] = $asset->store_id;
                $assignLog = AssetAssignLog::create($log);
                Session::flash('success', 'The Asset has been Moved to different Store');
                return redirect()->route('client.assets.index', $subdomain);
            } else {
                Session::flash('warning', 'The Asset can not Move');
                return redirect()->route('client.assets.index', $subdomain);
            }

        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    public function assetlogs($subdomain, $id)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-assets-show'])) {
            $asset = Asset::findOrFail($id);
            return view('client.assets.logs', compact('asset', 'subdomain'));
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    public function attachfile($subdomain, $id)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-assets-update'])) {

            $asset = Asset::findOrFail($id);
            $attachments = AssetAttachment::where('asset_id', $id)->with('users')->get();

            return view('client.assets.attachfile', compact('asset', 'attachments', 'subdomain'));
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    public function attachfilestore($subdomain, $id, Request $request)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-assets-update'])) {
            $asset = Asset::findOrFail($id);

            $messages = [

            ];
            $this->validate($request, [
                'title' => [
                    'required',
                    Rule::unique('asset_attachments')->where('asset_id', $id),
                ],
                'file' => 'required',
            ], $messages);

            $input['user_id'] = Auth::user()->id;
            $asset->update($input);

            //Asset File Attachment
            $attach = $request->all();
            $attach['user_id'] = Auth::user()->id;
            $attach['asset_id'] = $asset->id;

            if ($request->file('file')) {
                $filePath = Helper::uploadFile($request->file('file'), null, Config::get('constants.ASSET_ATTACHMENT'));
                $attach['filename'] = $filePath;
            }
            $attachment = AssetAttachment::create($attach);

            //Asset Log
            $log['type'] = 12;
            $log['user_id'] = Auth::user()->id;
            $log['asset_id'] = $asset->id;
            $log['note'] = $request->note;
            $assignLog = AssetAssignLog::create($log);

            Session::flash('success', 'The Asset File has been Attached');
            return redirect()->route('client.assets.index', $subdomain);

        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    public function attachmentdestroy($subdomain, $id)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can('client-attachment-delete')) {
            $attach = AssetAttachment::findOrFail($id);
            $asset = Asset::findOrFail($attach->asset_id);
            $asset->update([
                'user_id' => Auth::user()->id,
            ]);

            //Asset Log
            $log['type'] = 13;
            $log['user_id'] = Auth::user()->id;
            $log['asset_id'] = $asset->id;
            $log['note'] = 'The File "' . $attach->title . '" has been Deleted';
            $assignLog = AssetAssignLog::create($log);

            $attach->delete();
            Session::flash('success', 'The Asset File has been Deleted');
            return redirect()->back();
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    //Asset Permission to Vendor
    public function vendorpermission($subdomain, $id)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-asset-permission-create'])) {

            $asset = Asset::findOrFail($id);
            $enlist_vedor = VendorEnlistment::where([['client_id', Auth::user()->client_id], ['company_id', Auth::user()->company_id]])->pluck('vendor_id')->all();
            $permitted_vendors = AssetVendorPermission::with('vendors')->where('asset_id', $id)->get();
            $permitted_vendors_id = $permitted_vendors->pluck('vendor_id');
            $vendors = VendorInfo::whereIn('id', $enlist_vedor)->WhereNotIn('id', $permitted_vendors_id)->orderBy('name', 'ASC')->pluck('name', 'id')->all();


            return view('client.asset-vendor-permissions.index', compact('asset', 'vendors', 'permitted_vendors', 'subdomain'));
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    public function vendorpermissionstore($subdomain, $id, Request $request)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-asset-permission-create'])) {

            $messages = [

            ];
            $this->validate($request, [
                'vendor_id' => 'required',
            ], $messages);

            $vendors = $request->vendor_id;
            foreach ($vendors as $vendor) {
                $input['user_id'] = Auth::user()->id;
                $input['asset_id'] = $id;
                $input['vendor_id'] = $vendor;
                AssetVendorPermission::create($input);
            }

            Session::flash('success', 'The Asset Permission has been Created');
            return redirect()->back();
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    public function vendorpermissiondestroy($subdomain, $id)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can('client-asset-permission-delete')) {
            $vendor_permission = AssetVendorPermission::findOrFail($id);
            $vendor_permission->delete();
            Session::flash('success', 'The Asset Permission has been Deleted');
            return redirect()->back();
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    //Asset Permission time
    public function vendorpermissiontime($subdomain, $id)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-asset-permission-time-create'])) {

            $vendor = AssetVendorPermission::findOrFail($id);

            return view('client.asset-vendor-permissions.permissiontime', compact('vendor', 'subdomain'));
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    public function vendorpermissiontimestore($subdomain, $id, Request $request)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-asset-permission-time-create'])) {
            $vendor_permission = AssetVendorPermission::findOrFail($id);
            $messages = [

            ];
            $this->validate($request, [
                'permission_end_date' => 'required',
            ], $messages);

            $input = $request->all();
            $input['user_id'] = Auth::user()->id;

            $vendor_permission->update($input);

            Session::flash('success', 'The Permission time has been Created');
            return redirect()->route('client.assets.vendor.permission', [$subdomain, $vendor_permission->asset_id]);
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    public function permissiontimeremove($subdomain, $id)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-asset-permission-time-create'])) {
            $vendor_permission = AssetVendorPermission::findOrFail($id);
            $vendor_permission['permission_end_date'] = null;
            $vendor_permission->update();
            Session::flash('success', 'The Asset Permission time has been Unset');
            return redirect()->back();
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

//end class
}
