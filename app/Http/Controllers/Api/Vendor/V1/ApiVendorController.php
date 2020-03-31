<?php

namespace App\Http\Controllers\Api\Vendor\V1;

use App\Assessment;
use App\AssessmentAccessory;
use App\AssessmentService;
use App\Asset;
use App\AssetVendorPermission;
use App\Client;
use App\Helpers\Helper;
use App\VendorEnlistment;
use App\VendorInfo;
use App\Workflow;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;

class ApiVendorController extends Controller
{
    public function commonSync(Request $request)
    {

        return response()->json(
            [
                'error' => 0,
                'errorMsg' => '',
                'data' => [
                    'imagePath' => env('CDN_URL'),
                ],
                'time' => Carbon::now()->getTimestamp(),
            ]
        );

    }

    public function login(Request $request)
    {
        $messages = [
            //
        ];

        $validator = Validator::make($request->all(), [
            'username' => [
                'required',
                'regex:/^[a-zA-Z0-9]+@{1}[a-zA-Z0-9]+$/',
            ],
            'password' => 'required'
        ], $messages);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $data = [
                'error' => 1,
                'errorMsg' => implode(', ', $errors),
                'data' => NULL,
            ];
            return response()->json($data);
        }

        $user_arr = explode("@", $request->username);

        $vendor_info = VendorInfo::where('vendor_id', $user_arr[1])->first();
        if ($vendor_info) {
            if (Auth::guard('vendor')->attempt(['username' => $user_arr[0], 'password' => $request->password, 'vendor_info_id' => $vendor_info->id, 'status' => 1])) {

                $vendor = Auth::guard('vendor')->user();
                return response()->json(
                    [
                        'error' => 0,
                        'errorMsg' => '',
                        'data' => [
                            'vendor' => $vendor->makeVisible('api_token')->toArray(),
                            'vendor_info' => $vendor->vendorInfo()->first()->toArray(),
                        ]
                    ]
                );
            }

            return response()->json(
                [
                    'error' => 1,
                    'errorMsg' => 'User name or Password Error.',
                    'data' => null,
                ]
            );

        } else {
            return response()->json(
                [
                    'error' => 1,
                    'errorMsg' => 'User name or Password Error.',
                    'data' => null,
                ]
            );
        }

    }

    /**
     * update Password
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePassword(Request $request)
    {

        $vendorUser = Auth::guard('vendor-api')->user();

        $messages = [
            'old_password.required' => 'Current password is required',
            'old_password.old_password' => 'Current password is wrong',
            'password.required' => 'New Password is required',
            'password.confirmed' => 'New Passwords does not match',
            'password.min' => 'New Password must be at least 6 char long',
            'password.max' => 'New Password can be maximum 200 char long',
            'password_confirmation.required' => 'Password confirmation field is required',
        ];

        $validator = Validator::make($request->all(), [
            'old_password' => 'required|old_password:' . $vendorUser->password,
            'password' => 'required|confirmed|min:6|max:255',
        ], $messages);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();

            $errorStr = implode(', ', $errors);

            $data = [
                'error' => 1,
                'errorMsg' => $errorStr,
                'data' => null,
            ];
            return response()->json($data);
        }

        $vendorUser['password'] = bcrypt($request->get('password'));
        $vendorUser->save();

        return response()->json(
            [
                'error' => 0,
                'errorMsg' => 'Password has been updated',
            ]
        );
    }
    //Asset Info
    public function assetInfo(Request $request)
    {

        if (Auth::guard('vendor-api')->user()->hasRole('admin') || Auth::guard('vendor-api')->user()->can(['vendor-assessments-read'])) {

            $messages = [
                //
            ];

            $validator = Validator::make($request->all(), [
                'asset_number' => 'required',
                'client_id' => 'required',
            ], $messages);

            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                $data = [
                    'error' => 1,
                    'errorMsg' => implode(', ', $errors),
                    'data' => NULL,
                ];
                return response()->json($data);
            }

            // validate exist or not
            $assetIfo = Asset::where('client_id', $request->client_id)->where('asset_number', $request->asset_number)->get()->first();
            //dd($assetIfo->id);
            if (!$assetIfo) {
                return response()->json(
                    [
                        'error' => 1,
                        'errorMsg' => 'ASSET NUMBER / CLIENT MISMATCH',
                        'data' => NULL,
                    ]
                );
            }

            // Vendor enlistment check
            $vendor_enlistments = VendorEnlistment::where('vendor_id', Auth::guard('vendor-api')->user()->vendor_info_id)->get();
            $client_ids = $vendor_enlistments->pluck('client_id')->all();

            if (!in_array($request->client_id, $client_ids)) {
                return response()->json(
                    [
                        'error' => 1,
                        'errorMsg' => 'YOU ARE UNAUTHORIZED TO ACCESS THIS ASSET',
                        'data' => NULL,
                    ]
                );
            }

            // Get Related Data if exist
            $assessments = Assessment::where([['asset_id', $assetIfo->id], ['status', 2]]);

            //Checking Asset permission
            $asset_permission = $vendor_enlistments->where('client_id', $request->client_id)->where('status', 1)->pluck('asset_permission')->first();

            if (!$asset_permission) {
                return response()->json(
                    [
                        'error' => 1,
                        'errorMsg' => 'YOU ARE UNAUTHORIZED TO ACCESS THIS ASSET',
                        'data' => NULL,
                    ]
                );
            }

            if ($asset_permission == 0) {
                return response()->json(
                    [
                        'error' => 1,
                        'errorMsg' => 'YOU ARE UNAUTHORIZED TO ACCESS THIS ASSET',
                        'data' => NULL,
                    ]
                );
            } else if ($asset_permission == 2) {
                $permitted_assets_id = AssetVendorPermission::where('vendor_id', Auth::guard('vendor-api')->user()->vendor_info_id)->where('permission_end_date', null)->orWhere('permission_end_date', '>=', Carbon::today())->get()->pluck('asset_id')->all();

                if (!in_array($assetIfo->id, $permitted_assets_id)) {
                    return response()->json(
                        [
                            'error' => 1,
                            'errorMsg' => 'YOU ARE UNAUTHORIZED TO ACCESS THIS ASSET',
                            'data' => NULL,
                        ]
                    );
                }

            }

            if ($request->has('time')) {
                $time = Carbon::createFromTimestamp($request->get('time'));
                $assessments = $assessments->where('updated_at', '>', $time);
            }
            //used accessories and services
            $assessmentAccessories = $assessmentServices = [];
            if ($assessments->count()) {
                $assessmentAccessories = AssessmentAccessory::whereIn('assessment_id', $assessments->pluck('id')->all())->get()->toArray();
                $assessmentServices = AssessmentService::whereIn('assessment_id', $assessments->pluck('id')->all())->get()->toArray();
            }

            return response()->json(
                [
                    'error' => 0,
                    'errorMsg' => '',
                    'data' => [
                        'assets' => $assetIfo->toArray(),
                        'asset_brands' => $assetIfo->brand->toArray(),
                        'asset_hardwares' => $assetIfo->hardwares->makeHidden('pivot')->toArray(),
                        'asset_services' => $assetIfo->services->makeHidden('pivot')->toArray(),
                        'assessments' => $assessments->get()->toArray(),
                        'assessment_accessories' => $assessmentAccessories,
                        'assessment_services' => $assessmentServices,
                    ],
                    'time' => Carbon::now()->getTimestamp(),
                ]
            );


        } else {
            return response()->json(
                [
                    'error' => 1,
                    'errorMsg' => 'YOU ARE UNAUTHORIZED TO ACCESS',
                    'data' => NULL,
                ]
            );
        }

    }

    //Client wise Assessment Create
    public function assessmentCreate(Request $request)
    {
        if (Auth::guard('vendor-api')->user()->hasRole('admin') || Auth::guard('vendor-api')->user()->can(['vendor-assessments-create'])) {

            $messages = [
                'asset_number.required' => 'The Asset number field is required.',
                'client_id.required' => 'The Client id field is required.',
            ];

            $validator = Validator::make($request->all(), [
                'asset_number' => 'required',
                'client_id' => 'required',
            ], $messages);

            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                $data = [
                    'error' => 1,
                    'errorMsg' => implode(', ', $errors),
                    'data' => NULL,
                ];
                return response()->json($data);
            }

            // validate exist or not
            $assetIfo = Asset::where('client_id', $request->client_id)->where('asset_number', $request->asset_number)->get()->first();
            //dd($assetIfo->id);
            if (!$assetIfo) {
                return response()->json(
                    [
                        'error' => 1,
                        'errorMsg' => 'ASSET NUMBER / CLIENT MISMATCH',
                        'data' => NULL,
                    ]
                );
            }

            // Vendor enlistment check
            $vendor_enlistments = VendorEnlistment::where('vendor_id', Auth::guard('vendor-api')->user()->vendor_info_id)->get();
            $client_ids = $vendor_enlistments->pluck('client_id')->all();

            if (!in_array($request->client_id, $client_ids)) {
                return response()->json(
                    [
                        'error' => 1,
                        'errorMsg' => 'YOU ARE UNAUTHORIZED TO CREATE ASSESSMENT',
                        'data' => NULL,
                    ]
                );
            }

            //Check Other input fields
            $messages = [
                'required_days.required' => 'Please input how many days you required.',
                'required_days.integer' => 'Required days must be integer.',
                'cost.required' => 'Please input cost you demand.',
                'cost.numeric' => 'Costing must be numeric value.',
                'instrument.services.required_without' => 'Please select at least one service if you not select any accessory.',
                'instrument.accessories.required_without' => 'Please select at least one accessories if you not select any service.',
            ];

            $validator = Validator::make($request->all(), [
                'required_days' => 'required|integer',
                'cost' => 'required|numeric',
//                'instrument.services' => 'required_without:instrument.accessories',
//                'instrument.accessories' => 'required_without:instrument.services'

            ], $messages);

            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                $data = [
                    'error' => 1,
                    'errorMsg' => implode(', ', $errors),
                    'data' => NULL,
                ];
                return response()->json($data);
            }
            //Get Corresponding services and hardware of related asset
            $assetServices = $assetIfo->services->pluck('id')->all();
            $assetAccessories = $assetIfo->hardwares->pluck('id')->all();
            //validate services and hardware of related input
            $instrument = $request->get('instrument');
            $diffServices = $diffAccessories = [];
            if ($instrument && array_key_exists('services', $instrument)) {
                $diffServices = array_diff($instrument['services'], $assetServices);
            }
            if ($instrument && array_key_exists('accessories', $instrument)) {
                $diffAccessories = array_diff($instrument['accessories'], $assetAccessories);
            }

            if ($diffServices || $diffAccessories) {
                return response()->json([
                    'data' => [
                        'error' => 1,
                        'errorMsg' => 'Input services / accessories not exist in this asset collection.',
                        'data' => '',
                    ],
                ]);
            }

            //Checking Asset permission
            $asset_permission = $vendor_enlistments->where('client_id', $request->client_id)->where('status', 1)->pluck('asset_permission')->first();

            if (!$asset_permission) {
                return response()->json(
                    [
                        'error' => 1,
                        'errorMsg' => 'YOU ARE UNAUTHORIZED TO CREATE ASSESSMENT',
                        'data' => NULL,
                    ]
                );
            }
            if ($asset_permission == 0) {
                return response()->json(
                    [
                        'error' => 1,
                        'errorMsg' => 'YOU ARE UNAUTHORIZED TO CREATE ASSESSMENT',
                        'data' => NULL,
                    ]
                );
            } else if ($asset_permission == 2) {

                $permitted_assets_id = AssetVendorPermission::where('vendor_id', Auth::guard('vendor-api')->user()->vendor_info_id)->where('permission_end_date', null)->orWhere('permission_end_date', '>=', Carbon::today())->get()->pluck('asset_id')->all();

                if (!in_array($assetIfo->id, $permitted_assets_id)) {
                    return response()->json(
                        [
                            'error' => 1,
                            'errorMsg' => 'YOU ARE UNAUTHORIZED TO CREATE ASSESSMENT',
                            'data' => NULL,
                        ]
                    );
                }

            }

            // Create an Assessment
            $input = $request->except(['asset_number', 'client_id']);
            $input['asset_id'] = $assetIfo->id;
            $input['vendor_id'] = Auth::guard('vendor-api')->user()->vendor_info_id;
            $input['workflow_id'] = $assetIfo->workflow_id;
            $workflow = Workflow::find($input['workflow_id']);
            $input['total_steps'] = $workflow->activeprocesses->count();
            $input['current_steps'] = $workflow->activeprocesses->first()->id;
            $input['submit_date'] = Carbon::now()->format('Y-m-d');
            $input['status'] = 0;
            $assessment = Assessment::create($input);

            // insert Assessment Service
            if (!empty($instrument['services'])) {
                $services = [];
                foreach ($instrument['services'] as $service) {
                    $services[] = AssessmentService::updateOrCreate([
                        'assessment_id' => $assessment->id,
                        'service_id' => $service,
                    ], [
                            'assessment_id' => $assessment->id,
                            'service_id' => $service,
                        ]
                    );
                }

                AssessmentService::where('assessment_id', $assessment->id)->whereNotIn('service_id', collect($services)->pluck('service_id')->all())->delete();
            }

            // insert Assessment Accessory
            if (!empty($instrument['accessories'])) {
                $accessories = [];
                foreach ($instrument['accessories'] as $accessory) {
                    $accessories[] = AssessmentAccessory::updateOrCreate([
                        'assessment_id' => $assessment->id,
                        'accessory_id' => $accessory,
                    ], [
                            'assessment_id' => $assessment->id,
                            'accessory_id' => $accessory,
                        ]
                    );
                }

                AssessmentAccessory::where('assessment_id', $assessment->id)->whereNotIn('accessory_id', collect($accessories)->pluck('accessory_id')->all())->delete();
            }

            //Start workflow and email notification
            Helper::startWorkflowSendEmail($assessment->id);
            //Return Data
            return response()->json(
                [
                    'error' => 0,
                    'errorMsg' => '',
                    'data' => [
                        'assessment' => Assessment::where('id', $assessment->id)->first()->toArray(),
                        'asset' => Asset::where('id', $assessment->asset_id)->first()->toArray(),
                    ],
                ]
            );

        } else {
            return response()->json(
                [
                    'error' => 1,
                    'errorMsg' => 'YOU ARE UNAUTHORIZED TO ACCESS',
                    'data' => NULL,
                ]
            );
        }
    }

    //Client wise Assessment List
    public function assessmentList(Request $request)
    {
        if (Auth::guard('vendor-api')->user()->hasRole('admin') || Auth::guard('vendor-api')->user()->can(['vendor-assessments-read'])) {

            // Vendor enlistment check
            $vendor_enlistment = VendorEnlistment::where('vendor_id', Auth::guard('vendor-api')->user()->vendor_info_id)->where('client_id', $request->client_id)->first();

            if (!$vendor_enlistment) {
                return response()->json(
                    [
                        'error' => 1,
                        'errorMsg' => 'YOU ARE UNAUTHORIZED TO ACCESS ASSETS',
                        'data' => NULL,
                    ]
                );
            }

            $assessments = Assessment::where('vendor_id', Auth::guard('vendor-api')->user()->vendor_info_id)->whereHas('asset', function ($query) use ($request) {
                return $query->where('client_id', $request->client_id);
            })->orderBy('created_at', 'DESC');

            if ($request->has('time')) {
                $time = Carbon::createFromTimestamp($request->get('time'));
                $assessments = $assessments->withTrashed()->where('updated_at', '>', $time);
            }

            return response()->json(
                [
                    'error' => 0,
                    'errorMsg' => '',
                    'data' => [
                        'assessmentlist' => $assessments->get()->toArray(),
                    ],
                    'time' => Carbon::now()->getTimestamp(),
                ]
            );


        } else {
            return response()->json(
                [
                    'error' => 1,
                    'errorMsg' => 'YOU ARE UNAUTHORIZED TO ACCESS',
                    'data' => NULL,
                ]
            );
        }
    }
}
