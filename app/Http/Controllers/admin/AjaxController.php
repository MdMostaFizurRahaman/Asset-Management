<?php

namespace App\Http\Controllers\admin;

use App\Asset;
use App\VendorInfo;
use App\Workflow;
use App\Unit;
use App\OfficeLocation;
use App\Designation;
use App\Department;
use App\Division;
use App\ClientCompany;
use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AjaxController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function getAssets(Request $request)
    {
        $assets = Asset::where([['client_id', $request->get('client')], ['archive', 0], ['workflow_id', $request->get('workflow')]])->pluck('title', 'id')->all();


        if (isset($_POST['includeAll']) && $_POST['includeAll'] == 1) {
            $modelData = '<option value="0">All</option>';
        }

        foreach ($assets as $key => $asset) {
            $modelData .= '<option value="' . $key . '">' . $asset . '</option>';
        }

        return $modelData;
    }

    public function getWorkflows(Request $request)
    {
        $workflows = Workflow::where('client_id', $request->get('client'))->pluck('title', 'id')->all();


        if (isset($_POST['includeAll']) && $_POST['includeAll'] == 1) {
            $modelData = '<option value="0">All</option>';
        }

        foreach ($workflows as $key => $workflow) {
            $modelData .= '<option value="' . $key . '">' . $workflow . '</option>';
        }

        return $modelData;
    }

    public function getClientRoles()
    {
        $models = Role::where([['type', $_POST['type']], ['user_id', $_POST['client_id']]])->pluck('display_name', 'id');
        if (isset($_POST['listAll']) && $_POST['listAll'] == 1) {
            if (isset($_POST['includeAll']) && $_POST['includeAll'] == 1) {
                $modelData = '<option value="0">All</option>';
            }
        } else {
            if (isset($_POST['includeAll']) && $_POST['includeAll'] == 1) {
                $modelData = '<option value="">Choose an option</option>';
            }
        }
        foreach ($models as $key => $model) {
            $modelData .= '<option value="' . $key . '">' . $model . '</option>';
        }

        return $modelData;
    }
    public function getVendorRoles()
    {
        $models = Role::where([['type', $_POST['type']], ['user_id', $_POST['vendor_info_id']]])->pluck('display_name', 'id');
        if (isset($_POST['listAll']) && $_POST['listAll'] == 1) {
            if (isset($_POST['includeAll']) && $_POST['includeAll'] == 1) {
                $modelData = '<option value="0">All</option>';
            }
        } else {
            if (isset($_POST['includeAll']) && $_POST['includeAll'] == 1) {
                $modelData = '<option value="">Choose an option</option>';
            }
        }
        foreach ($models as $key => $model) {
            $modelData .= '<option value="' . $key . '">' . $model . '</option>';
        }

        return $modelData;
    }

    public function getCompanies(Request $request)
    {
        $models = ClientCompany::where([['client_id', $request->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();

        if (isset($_POST['listAll']) && $_POST['listAll'] == 1) {
            if (isset($_POST['includeAll']) && $_POST['includeAll'] == 1) {
                $modelData = '<option value="0">All</option>';
            }
        } else {
            if (isset($_POST['includeAll']) && $_POST['includeAll'] == 1) {
                $modelData = '<option value="">Choose an option</option>';
            }
        }
        foreach ($models as $key => $model) {
            $modelData .= '<option value="' . $key . '">' . $model . '</option>';
        }

        return $modelData;
    }

    public function getDivisions(Request $request)
    {
        $models = Division::where([['client_id', $request->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();

        if (isset($_POST['listAll']) && $_POST['listAll'] == 1) {
            if (isset($_POST['includeAll']) && $_POST['includeAll'] == 1) {
                $modelData = '<option value="0">All</option>';
            }
        } else {
            if (isset($_POST['includeAll']) && $_POST['includeAll'] == 1) {
                $modelData = '<option value="">Choose an option</option>';
            }
        }
        foreach ($models as $key => $model) {
            $modelData .= '<option value="' . $key . '">' . $model . '</option>';
        }

        return $modelData;
    }

    public function getDepartments(Request $request)
    {
        $models = Department::where([['client_id', $request->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();

        if (isset($_POST['listAll']) && $_POST['listAll'] == 1) {
            if (isset($_POST['includeAll']) && $_POST['includeAll'] == 1) {
                $modelData = '<option value="0">All</option>';
            }
        } else {
            if (isset($_POST['includeAll']) && $_POST['includeAll'] == 1) {
                $modelData = '<option value="">Choose an option</option>';
            }
        }
        foreach ($models as $key => $model) {
            $modelData .= '<option value="' . $key . '">' . $model . '</option>';
        }

        return $modelData;
    }

    public function getDesignations(Request $request)
    {
        $models = Designation::where([['client_id', $request->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();

        if (isset($_POST['listAll']) && $_POST['listAll'] == 1) {
            if (isset($_POST['includeAll']) && $_POST['includeAll'] == 1) {
                $modelData = '<option value="0">All</option>';
            }
        } else {
            if (isset($_POST['includeAll']) && $_POST['includeAll'] == 1) {
                $modelData = '<option value="">Choose an option</option>';
            }
        }
        foreach ($models as $key => $model) {
            $modelData .= '<option value="' . $key . '">' . $model . '</option>';
        }

        return $modelData;
    }

    public function getLocations(Request $request)
    {
        $models = OfficeLocation::where([['client_id', $request->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();

        if (isset($_POST['listAll']) && $_POST['listAll'] == 1) {
            if (isset($_POST['includeAll']) && $_POST['includeAll'] == 1) {
                $modelData = '<option value="0">All</option>';
            }
        } else {
            if (isset($_POST['includeAll']) && $_POST['includeAll'] == 1) {
                $modelData = '<option value="">Choose an option</option>';
            }
        }
        foreach ($models as $key => $model) {
            $modelData .= '<option value="' . $key . '">' . $model . '</option>';
        }

        return $modelData;
    }

    public function getUnits(Request $request)
    {
        $models = Unit::where([['client_id', $request->client_id], ['status', 1]])->orderBy('title', 'ASC')->pluck('title', 'id')->all();

        if (isset($_POST['listAll']) && $_POST['listAll'] == 1) {
            if (isset($_POST['includeAll']) && $_POST['includeAll'] == 1) {
                $modelData = '<option value="0">All</option>';
            }
        } else {
            if (isset($_POST['includeAll']) && $_POST['includeAll'] == 1) {
                $modelData = '<option value="">Choose an option</option>';
            }
        }
        foreach ($models as $key => $model) {
            $modelData .= '<option value="' . $key . '">' . $model . '</option>';
        }

        return $modelData;
    }

    //get vendor
    public function getVendor(Request $request)
    {

        $vendor = VendorInfo::where([['id', $request->vendor_info_id], ['status', 1]])->first();
        return "@" . $vendor->vendor_id;
    }

}
