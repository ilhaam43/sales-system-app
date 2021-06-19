<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

use App\Models\ProductCategory;
use App\Models\User;
use App\Models\UsersRole;
use App\Models\UsersStatus;
use App\Models\Photos;
use App\Models\Countries;
use App\Models\Settings;
use App\Models\JobsStatus;
use App\Models\ResearchJobs;
use App\Models\InquiryJobs;
use App\Models\AuditorInquiryJobs;
use App\Models\AuditorResearchJobs;
use DataTables;

class AjaxDataUsersController extends Controller
{

    public function allDataUsers(Request $request)
    {
        if ($request->ajax()) {
            
            $auth = Auth::user();
            $data = User::whereNotIn('id', [1,2])->where('product_category_id', $auth->product_category_id)->with(['ProductCategory', 'UsersStatus', 'UsersRole', 'Country'])->select('users.*');
                
            return Datatables::eloquent($data)
                ->addIndexColumn()
                ->addColumn('actions', function($data){
                    $routeEdit = route('admin.users.show',$data->id);
                    $routeDelete = route('admin.users.destroy',$data->id);

                    $actionBtn = '<a class="btn btn-primary btn-sm" href="'.$routeEdit.'">Edit</a> <button class="btn btn-danger btn-sm remove-user" data-id="'.$data->id.'" data-action="'.$routeDelete.'" onclick="deleteConfirmation('.$data->id.')"> Delete</button>';

                    return $actionBtn;
                })->addColumn('checkbox', function($data){
                    $checkbox = '<input type="checkbox" name="id_inquiries[]" id="id_inquiries" value="'.$data->id.'">';
                    return $checkbox;
                })->addColumn('status', function($data){
                    $datas = json_decode($data, true);

                    return $datas['users_status']['status'];
                })
                ->rawColumns(['actions', 'checkbox', 'status'])->setRowId(function ($data) {
                    return $data->id;
                })
                ->make(true);
        }
    }

}
