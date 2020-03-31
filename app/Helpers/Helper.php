<?php

/**
 * Created by Netbeans.
 * User: Annanovas
 * Date: 12/07/18
 */

namespace App\Helpers;

use App\Assessment;
use App\AssessmentAccessory;
use App\AssessmentApprovalUserArchive;
use App\Asset;
use App\AssetHardware;
use App\AssetService;
use App\AssetStatus;
use App\Mail\WaitingForApproval;
use App\ProcessUser;
use App\User;
use App\Workflow;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\AssessmentApproval;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Helper
{
    /*
     * this function is used for showing the status label
     * @return ACTIVE_STATUSES
     */

    public static function activeStatuslabel($activeStatus)
    {
        if ($activeStatus == 1) {
            return '<span class="label label-success">' . Config::get('constants.ACTIVE_STATUSES')[$activeStatus] . '</span>';
        } elseif ($activeStatus == 0) {
            return '<span class="label label-warning">' . Config::get('constants.ACTIVE_STATUSES')[$activeStatus] . '</span>';
        } else {
            return '<span class="label label-default">Undefined</span>';
        }
    }

    public static function assetStatusBg($colorCode)
    {
        return '<span class="label" style="background:' . $colorCode . '">' . $colorCode . '</span>';
    }

    public static function assetStatusLabel($id)
    {
        $status = AssetStatus::where('id', $id)->withTrashed()->first();
        if ($status) {
            return '<span class="label" style="background:' . $status->color_code . '">' . $status->title . '</span>';
        } else {
            return '<span class="label label-default">No Status</span>';
        }
    }

    public static function assetAssignStatusLabel($assignStatus)
    {
        if ($assignStatus == 0) {
            return '<span class="label label-success">' . Config::get('constants.ASSET_ASSIGN_STATUSES')[$assignStatus] . '</span>';
        } else if ($assignStatus == 1) {
            return '<span class="label label-primary">' . Config::get('constants.ASSET_ASSIGN_STATUSES')[$assignStatus] . '</span>';

        } else if ($assignStatus == 2) {
            return '<span class="label label-danger">' . Config::get('constants.ASSET_ASSIGN_STATUSES')[$assignStatus] . '</span>';

        } else if ($assignStatus == 3) {
            return '<span class="label label-warning">' . Config::get('constants.ASSET_ASSIGN_STATUSES')[$assignStatus] . '</span>';

        } else {
            return '<span class="label label-warning">No Status</span>';
        }
    }

    public static function assetAssignType($inputData)
    {
        if ($inputData == 0) {
            return '<span class="label label-primary">' . Config::get('constants.ASSET_STORE_TYPE')[$inputData] . '</span>';
        } else {
            return '<span class="label label-success">User</span>';
        }
    }

    public static function activeAssessmentStatuslabel($activeStatus)
    {
        if ($activeStatus == 1) {
            return '<span class="label label-success">' . Config::get('constants.ACTIVE_ASSESSMENT_STATUSES')[$activeStatus] . '</span>';
        }
        if ($activeStatus == 2) {
            return '<span class="label label-primary">' . Config::get('constants.ACTIVE_ASSESSMENT_STATUSES')[$activeStatus] . '</span>';
        }
        if ($activeStatus == 3) {
            return '<span class="label label-danger">' . Config::get('constants.ACTIVE_ASSESSMENT_STATUSES')[$activeStatus] . '</span>';
        } else {
            return '<span class="label label-warning">' . Config::get('constants.ACTIVE_ASSESSMENT_STATUSES')[$activeStatus] . '</span>';
        }
    }

    public static function activeArchivelabel($activeStatus)
    {
        if ($activeStatus == 1) {
            return '<span class="label label-success">' . Config::get('constants.ARCHIVE_STATUSES')[$activeStatus] . '</span>';
        } else {
            return '<span class="label label-warning">' . Config::get('constants.ARCHIVE_STATUSES')[$activeStatus] . '</span>';
        }
    }

    public static function activeAssessmentApproval($activeStatus)
    {
        return Config::get('constants.ASSESSMENT_APPROVAL_STATUSES')[$activeStatus];
    }

    public static function activePublicTypes($activeStatus)
    {
        if ($activeStatus == 1) {
            return '<span class="label label-success">' . Config::get('constants.ACTIVE_PUBLIC_TYPES')[$activeStatus] . '</span>';
        } else {
            return '<span class="label label-warning">' . Config::get('constants.ACTIVE_PUBLIC_TYPES')[$activeStatus] . '</span>';
        }
    }

    public static function activeAssessmentTypes($activeStatus)
    {
        if ($activeStatus == 1) {
            return '<span class="label label-success">' . Config::get('constants.ACTIVE_ASSESSMENT_TYPES')[$activeStatus] . '</span>';
        } else {
            return '<span class="label label-primary">' . Config::get('constants.ACTIVE_ASSESSMENT_TYPES')[$activeStatus] . '</span>';
        }
    }

    public static function activeClientStatuslabel($activeStatus)
    {
        if ($activeStatus == 1) {
            return '<span class="label label-success">' . Config::get('constants.ACTIVE_CLIENT_STATUSES')[$activeStatus] . '</span>';
        } else if ($activeStatus == 2) {
            return '<span class="label label-primary">' . Config::get('constants.ACTIVE_CLIENT_STATUSES')[$activeStatus] . '</span>';
        } else if ($activeStatus == 3) {
            return '<span class="label label-danger">' . Config::get('constants.ACTIVE_CLIENT_STATUSES')[$activeStatus] . '</span>';
        } else {
            return '<span class="label label-warning">' . Config::get('constants.ACTIVE_CLIENT_STATUSES')[$activeStatus] . '</span>';
        }
    }

    public static function activeVendorInfoStatusLabel($activeStatus)
    {
        if ($activeStatus == 1) {
            return '<span class="label label-success">' . Config::get('constants.ACTIVE_VENDOR_STATUSES')[$activeStatus] . '</span>';
        } else if ($activeStatus == 2) {
            return '<span class="label label-primary">' . Config::get('constants.ACTIVE_VENDOR_STATUSES')[$activeStatus] . '</span>';
        } else if ($activeStatus == 3) {
            return '<span class="label label-danger">' . Config::get('constants.ACTIVE_VENDOR_STATUSES')[$activeStatus] . '</span>';
        } else {
            return '<span class="label label-warning">' . Config::get('constants.ACTIVE_VENDOR_STATUSES')[$activeStatus] . '</span>';
        }
    }

    public static function vendorAssetStatusLabel($status)
    {
        if ($status == 0) {
            return '<span class="label label-default">' . Config::get('constants.ASSET_PERMISSION_TYPES')[$status] . '</span>';
        } else if ($status == 1) {
            return '<span class="label label-success">' . Config::get('constants.ASSET_PERMISSION_TYPES')[$status] . '</span>';
        } else if ($status == 2) {
            return '<span class="label label-primary">' . Config::get('constants.ASSET_PERMISSION_TYPES')[$status] . '</span>';
        } else {
            return '<span class="label label label-danger"></span>';
        }
    }

    public static function activeProcessNotCompleteLabel($activeStatus)
    {
        return Config::get('constants.PROCESS_NOT_COMPLETE_TYPES')[$activeStatus];
    }

    public static function activeProcessTypes($activeStatus)
    {
        return Config::get('constants.PROCESS_TYPES')[$activeStatus];
    }

    public static function assetStage($type)
    {
        return Config::get('constants.ASSET_STAGE_STATUSES')[$type];
    }

    public static function assetStageIconBg($type)
    {
        return '<span class="info-box-icon ' . Config::get('constants.ASSET_STAGE_BG')[$type] . '"><i class="fa ' . Config::get('constants.ASSET_STAGE_ICON')[$type] . '"></i></span>';
    }

    public static function menuIsActive($routeNames)
    {
        $currentRoute = Route::currentRouteName();

        if (in_array($currentRoute, $routeNames)) {
            return 'active';
        }
    }

    public static function urlSlug($string)
    {

        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

        return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
    }

    /*
     * this function will Upload any file to S3 or local disk
     * pass file or base64sting
     * pass destination folderPath with slash added in last
     * if fileName not provided , ans automatic file name will be generated with segmented folder with year & month
     * @return string Image Name With Segmented Folder
     */

    public static function uploadFile($file = null, $base64string = null, $destinationPath, $fileName = null, $disk = null, $extension = null)
    {
        if (!$disk) {
            $disk = env('DISK_TYPE');
        }
        if (!$fileName) {
            if ($file) {
                $fileName = Carbon::now()->format('Y') . '/' . Carbon::now()->format('m') . '/' . uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
            } else {
                if ($extension) {
                    $fileName = Carbon::now()->format('Y') . '/' . Carbon::now()->format('m') . '/' . uniqid() . '_' . time() . $extension;
                } else {
                    $fileName = Carbon::now()->format('Y') . '/' . Carbon::now()->format('m') . '/' . uniqid() . '_' . time() . '.jpg';
                }
            }
        }

        if ($file) {
            $imagePath = Storage::disk($disk)->putFileAs($destinationPath, $file, $fileName, 'public');

            return $imagePath;
        } elseif ($base64string) {
            $imagePath = Storage::disk($disk)->put($destinationPath . '/' . $fileName, $base64string, 'public');

            return $destinationPath . '/' . $fileName;
        } else {
            return null;
        }
    }

    public static function storagePath($filePath)
    {
        return env('CDN_URL') . '/' . $filePath;
    }

    public static function pendingassessments()
    {

        $approvals = AssessmentApproval::whereHas('approvalusers', function ($query) {
            $query->where('user_id', Auth::user()->id);
        })->pluck('id')->all();

        $assessments = AssessmentApproval::whereNotIn('id', $approvals)->where('status', 1)->whereHas('process.users', function ($query) {
            $query->where('attachuser_id', Auth::user()->id);
        })->get();
        return $assessments;
    }

    public static function accessories($id)
    {
        $name = AssetHardware::findOrFail($id)->title;
        return '<span class="label label-warning">' . $name . '</span>';
    }

    public static function services($id)
    {
        $name = AssetService::findOrFail($id)->title;
        return '<span class="label label-success">' . $name . '</span>';
    }

    public static function depreciation($value)
    {
        if ($value == 1) {
            return '<span class="label label-success">Yes</span>';
        } else {
            return '<span class="label label-default">No</span>';
        }
    }

    public static function depreciationType($value)
    {
        if ($value === 0) {
            return '<span class="label label-primary">' . Config::get('constants.DEPRECIATION_TYPE')[$value] . '</span>';
        }
        if ($value === 1) {
            return '<span class="label label-success">' . Config::get('constants.DEPRECIATION_TYPE')[$value] . '</span>';
        } else {
            return '';
        }
    }

    public static function depreciationCategory($status)
    {
        if ($status === 0) {
            return '<span class="label label-primary">' . Config::get('constants.DEPRECIATION_CATEGORY')[$status] . '</span>';
        } else if ($status === 1) {
            return '<span class="label label-success">' . Config::get('constants.DEPRECIATION_CATEGORY')[$status] . '</span>';
        } else {
            return '';
        }

    }



    public static function generateQrCode(Asset $asset, $returnOnly=false){
        $data = [];

        $data['assetId'] = $asset->formattedId;
        $data['assetIdentifier'] = str_pad($asset->id,6,'0',STR_PAD_LEFT);
        $data['assetClientId'] = $asset->client->id;
        $data['assetTitle'] = $asset->title;
        $data['time'] = Carbon::now()->timestamp;

        if($returnOnly){
            return $data;
        }

        $jsonData = json_encode($data);

        $qrCode = QrCode::format('png')->size(600)->generate($jsonData);

        $name = Carbon::now()->format('Y') . '/' . Carbon::now()->format('m') . '/' . 'QR_' . Config::get('constants.ASSET_ID_PREFIX') . $asset->formattedId . '_' . $asset->id . '_' . Str::uuid() . '.png';
        $image = Image::make( $qrCode )->fit(600, 600);

        //
        $qr_code_text_canvas = Image::canvas(600, 100);
        $qr_code_text_canvas->text( $asset->formattedId .':'. str_pad($asset->client->id,3,'0', STR_PAD_LEFT) , 100, 10, function($font) {
            $font->file( public_path('qr_font/Source_Sans_Pro/SourceSansPro-SemiBold.ttf'));
            $font->size(90);
//            $font->color('#fdf6e3');
//            $font->align('center');
            $font->valign('top');
//            $font->angle(45);
        });


        $qr_merge_canvas = Image::canvas(600, 700);
        $qr_merge_canvas->insert($image);
        $qr_merge_canvas->insert($qr_code_text_canvas, 'bottom'); // add offset

        $imagePath = Helper::uploadFile(null, (string) $qr_merge_canvas->encode(), Config::get('constants.ASSET_QR_CODE_IMAGE') , $name);

        return $imagePath;
        //dd($data);
    }

    public static function startWorkflowSendEmail($id)
    {

        $assessment = Assessment::find($id);

        $workflow = Workflow::find($assessment->workflow_id);

        $assessment_approval = AssessmentApproval::create([
            'process_id' => $workflow->activeprocesses->first()->id,
            'assessment_id' => $id,
            'status' => 1,
            'type' => 0,
        ]);
        $activeprocess = $workflow->activeprocesses->first();
        if ($activeprocess) {
            foreach ($activeprocess->users as $user) {
                AssessmentApprovalUserArchive::create([
                    'assessment_approval_id' => $assessment_approval->id,
                    'user_id' => $user->attachuser_id,
                ]);
            }
        }

        $assessment['status'] = 1;
        $assessment->update();

        //send emails
        $processUserIds = ProcessUser::where('process_id', $assessment->current_steps)->pluck('attachuser_id', 'attachuser_id');

        if ($processUserIds) {
            $processUsers = User::whereIn('id', $processUserIds)->get();
            foreach ($processUsers as $processUser) {
                Mail::to($processUser->email)->queue(new WaitingForApproval($processUser, $assessment_approval->id));
            }
        }
        //send emails

    }


}
