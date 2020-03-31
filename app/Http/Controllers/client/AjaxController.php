<?php

namespace App\Http\Controllers\client;

use App\Asset;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller {

    public function __construct() {
        $this->middleware('auth:web');
    }

    public function getAssets(Request $request) {
        $allassets = Asset::where([['status', 1], ['user_id', Auth::user()->id]])->whereHas('assessments')->orderBy('title', 'ASC')->pluck('title', 'id')->all();
        $assets = Asset::where([['client_id', Auth::user()->client_id], ['archive', 0], ['workflow_id', $request->get('workflow')]])->pluck('title', 'id')->all();


        $modelData = '<option value="0">All</option>';
        if (isset($_POST['workflow']) && $_POST['workflow'] == 0) {
            foreach ($allassets as $key => $asset) {
                $modelData .= '<option value="' . $key . '">' . $asset . '</option>';
            }

        }else{
            foreach ($assets as $key => $asset) {
                $modelData .= '<option value="' . $key . '">' . $asset . '</option>';
            }

        }



        return $modelData;
    }

}
