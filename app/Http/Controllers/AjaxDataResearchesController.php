<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

use App\Models\ProductCategory;
use App\Models\ProductSources;
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

class AjaxDataResearchesController extends Controller
{

    public function allDataResearches(Request $request)
    {
        if ($request->ajax()) {
            $auth = Auth::user();
            $data = ResearchJobs::where('product_category_id', $auth->product_category_id)->where('is_blacklist', 'No')->with('Country', 'JobsStatus', 'AuditorResearchJobs.User', 'User', 'ProductSources');
            
            return Datatables::eloquent($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    $routeEdit = route('admin.researches.detail',$data->id);
                    $actionBtn = '<a href="'.$routeEdit.'" class="edit btn btn-primary btn-sm" target="_blank">Edit</a>';
                    return $actionBtn;
                })->addColumn('website', function($data){
                    $websiteBtn = '<a href="'.$data->company_website.'" class="edit btn btn-primary btn-sm" target="_blank">Website</a>';
                    return $websiteBtn;
                })->addColumn('checkbox', function($data){
                    $checkbox = '<input type="checkbox" name="id_researcher[]" id="id_researcher" value="'.$data->id.'">';
                    return $checkbox;
                })->addColumn('product_page', function($data){
                    $productBtn = '<a href="'.$data->company_product_url.'" class="edit btn btn-info btn-sm" target="_blank">Product</a>';
                    return $productBtn;
                })->addColumn('country', function($data){
                    return $data->country->country_name;
                })->addColumn('status', function($data){
                    $datas = json_decode($data, true);

                    return $datas['jobs_status']['status'];
                })->addColumn('researcher', function($data){
                    $datas = json_decode($data, true);

                    $userId = $datas['user']['id'] ?? '';
                    $userName = $datas['user']['name'] ?? '';

                    $researcherLink = '<a href="/admin/workers/researcher/'.$userId.'">'.$userName.'</a>';
                    return $researcherLink;
                })
                ->rawColumns(['action', 'website', 'checkbox', 'product_page', 'country', 'status', 'researcher'])->setRowId(function ($data) {
                    return $data->id;
                })
                ->make(true);
        }
    }

    public function approvedDataResearches(Request $request)
    {
        if ($request->ajax()) {
            $auth = Auth::user();
            $data = ResearchJobs::where('product_category_id', $auth->product_category_id)->where('job_status_id', 1)->where('is_blacklist', 'No')->with('Country', 'JobsStatus', 'AuditorResearchJobs.User', 'User', 'ProductSources');
            
            return Datatables::eloquent($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    $routeEdit = route('admin.researches.detail',$data->id);
                    $actionBtn = '<a href="'.$routeEdit.'" class="edit btn btn-primary btn-sm" target="_blank">Edit</a>';
                    return $actionBtn;
                })->addColumn('website', function($data){
                    $websiteBtn = '<a href="'.$data->company_website.'" class="edit btn btn-primary btn-sm" target="_blank">Website</a>';
                    return $websiteBtn;
                })->addColumn('checkbox', function($data){
                    $checkbox = '<input type="checkbox" name="id_researcher[]" id="id_researcher" value="'.$data->id.'">';
                    return $checkbox;
                })->addColumn('product_page', function($data){
                    $productBtn = '<a href="'.$data->company_product_url.'" class="edit btn btn-info btn-sm" target="_blank">Product</a>';
                    return $productBtn;
                })->addColumn('country', function($data){
                    return $data->country->country_name;
                })->addColumn('status', function($data){
                    $datas = json_decode($data, true);

                    return $datas['jobs_status']['status'];
                })->addColumn('researcher', function($data){
                    $datas = json_decode($data, true);

                    $userId = $datas['user']['id'] ?? '';
                    $userName = $datas['user']['name'] ?? '';

                    $researcherLink = '<a href="/admin/workers/researcher/'.$userId.'">'.$userName.'</a>';
                    return $researcherLink;
                })
                ->rawColumns(['action', 'website', 'checkbox', 'product_page', 'country', 'status', 'researcher'])->setRowId(function ($data) {
                    return $data->id;
                })
                ->make(true);
        }
    }

    public function rejectedDataResearches(Request $request)
    {
        if ($request->ajax()) {
            $auth = Auth::user();
            $data = ResearchJobs::where('product_category_id', $auth->product_category_id)->where('job_status_id', 2)->where('is_blacklist', 'No')->with('Country', 'JobsStatus', 'AuditorResearchJobs.User', 'User', 'ProductSources');
            
            return Datatables::eloquent($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    $routeEdit = route('admin.researches.detail',$data->id);
                    $actionBtn = '<a href="'.$routeEdit.'" class="edit btn btn-primary btn-sm" target="_blank">Edit</a>';
                    return $actionBtn;
                })->addColumn('website', function($data){
                    $websiteBtn = '<a href="'.$data->company_website.'" class="edit btn btn-primary btn-sm" target="_blank">Website</a>';
                    return $websiteBtn;
                })->addColumn('checkbox', function($data){
                    $checkbox = '<input type="checkbox" name="id_researcher[]" id="id_researcher" value="'.$data->id.'">';
                    return $checkbox;
                })->addColumn('product_page', function($data){
                    $productBtn = '<a href="'.$data->company_product_url.'" class="edit btn btn-info btn-sm" target="_blank">Product</a>';
                    return $productBtn;
                })->addColumn('country', function($data){
                    return $data->country->country_name;
                })->addColumn('status', function($data){
                    $datas = json_decode($data, true);

                    return $datas['jobs_status']['status'];
                })->addColumn('researcher', function($data){
                    $datas = json_decode($data, true);

                    $userId = $datas['user']['id'] ?? '';
                    $userName = $datas['user']['name'] ?? '';

                    $researcherLink = '<a href="/admin/workers/researcher/'.$userId.'">'.$userName.'</a>';
                    return $researcherLink;
                })
                ->rawColumns(['action', 'website', 'checkbox', 'product_page', 'country', 'status', 'researcher'])->setRowId(function ($data) {
                    return $data->id;
                })
                ->make(true);
        }
    }

    public function pendingDataResearches(Request $request)
    {
        if ($request->ajax()) {
            $auth = Auth::user();
            $data = ResearchJobs::where('product_category_id', $auth->product_category_id)->where('job_status_id', 3)->where('is_blacklist', 'No')->with('Country', 'JobsStatus', 'AuditorResearchJobs.User', 'User', 'ProductSources');
            
            return Datatables::eloquent($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    $routeEdit = route('admin.researches.detail',$data->id);
                    $actionBtn = '<a href="'.$routeEdit.'" class="edit btn btn-primary btn-sm" target="_blank">Edit</a>';
                    return $actionBtn;
                })->addColumn('website', function($data){
                    $websiteBtn = '<a href="'.$data->company_website.'" class="edit btn btn-primary btn-sm" target="_blank">Website</a>';
                    return $websiteBtn;
                })->addColumn('checkbox', function($data){
                    $checkbox = '<input type="checkbox" name="id_researcher[]" id="id_researcher" value="'.$data->id.'">';
                    return $checkbox;
                })->addColumn('product_page', function($data){
                    $productBtn = '<a href="'.$data->company_product_url.'" class="edit btn btn-info btn-sm" target="_blank">Product</a>';
                    return $productBtn;
                })->addColumn('country', function($data){
                    return $data->country->country_name;
                })->addColumn('status', function($data){
                    $datas = json_decode($data, true);

                    return $datas['jobs_status']['status'];
                })->addColumn('researcher', function($data){
                    $datas = json_decode($data, true);

                    $userId = $datas['user']['id'] ?? '';
                    $userName = $datas['user']['name'] ?? '';

                    $researcherLink = '<a href="/admin/workers/researcher/'.$userId.'">'.$userName.'</a>';
                    return $researcherLink;
                })
                ->rawColumns(['action', 'website', 'checkbox', 'product_page', 'country', 'status', 'researcher'])->setRowId(function ($data) {
                    return $data->id;
                })
                ->make(true);
        }
    }

    public function removedDataResearches(Request $request)
    {
        if ($request->ajax()) {
            $auth = Auth::user();
            $data = ResearchJobs::where('product_category_id', $auth->product_category_id)->where('job_status_id', 4)->where('is_blacklist', 'No')->with('Country', 'JobsStatus', 'AuditorResearchJobs.User', 'User', 'ProductSources');
            
            return Datatables::eloquent($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    $routeEdit = route('admin.researches.detail',$data->id);
                    $actionBtn = '<a href="'.$routeEdit.'" class="edit btn btn-primary btn-sm" target="_blank">Edit</a>';
                    return $actionBtn;
                })->addColumn('website', function($data){
                    $websiteBtn = '<a href="'.$data->company_website.'" class="edit btn btn-primary btn-sm" target="_blank">Website</a>';
                    return $websiteBtn;
                })->addColumn('checkbox', function($data){
                    $checkbox = '<input type="checkbox" name="id_researcher[]" id="id_researcher" value="'.$data->id.'">';
                    return $checkbox;
                })->addColumn('product_page', function($data){
                    $productBtn = '<a href="'.$data->company_product_url.'" class="edit btn btn-info btn-sm" target="_blank">Product</a>';
                    return $productBtn;
                })->addColumn('country', function($data){
                    return $data->country->country_name;
                })->addColumn('status', function($data){
                    $datas = json_decode($data, true);

                    return $datas['jobs_status']['status'];
                })->addColumn('researcher', function($data){
                    $datas = json_decode($data, true);

                    $userId = $datas['user']['id'] ?? '';
                    $userName = $datas['user']['name'] ?? '';

                    $researcherLink = '<a href="/admin/workers/researcher/'.$userId.'">'.$userName.'</a>';
                    return $researcherLink;
                })
                ->rawColumns(['action', 'website', 'checkbox', 'product_page', 'country', 'status', 'researcher'])->setRowId(function ($data) {
                    return $data->id;
                })
                ->make(true);
        }
    }

    public function showResearcherData(Request $request)
    {
        if ($request->ajax()) {
            $auth = Auth::user();

            $data = ResearchJobs::where('user_id', $auth->id)->with('Country', 'JobsStatus', 'ProductSources')->select('research_jobs.*');
            
            return Datatables::eloquent($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    $editRoute = route('researcher.detail.researches',$data->id);
                    $actionBtn = '<a class="btn btn-primary btn-sm" href="'.$editRoute.'">Edit</a>';
    
                    return $actionBtn;
                })
                ->rawColumns(['action'])->setRowId(function ($data) {
                    return $data->id;
                })
                ->make(true);
        }
    }

    public function showCompanyData(Request $request)
    {
        if ($request->ajax()) {
            $auth = Auth::user();

            $data = ResearchJobs::whereNotIn('count_inquiry', array(1))->orWhereNull('count_inquiry')->where('job_status_id', 1)->where('is_blacklist', 'No')->where('product_category_id', $auth->product_category_id)->with('Country')->inRandomOrder()->select('research_jobs.*');
            
            return Datatables::eloquent($data)
                ->addIndexColumn()->addColumn('company_websites', function($data){
                    $urlBtn = '<a class="btn btn-primary btn-md" href="'.$data->company_website.'"><i class="fa fa-link p-r-5"></i> Website Link</a>';
    
                    return $urlBtn;
                })
                ->addColumn('inquiry', function($data){
                    $inquiryBtn = '<button data-toggle="modal" data-target-id="'.$data->id.'" data-target="#sendInquiry" class="btn btn-primary btn-md"><i class="fa fa-envelope p-r-5"></i> Send Inquiry</button>';
    
                    return $inquiryBtn;
                })->addColumn('website_problem', function($data){
                    $problemBtn = '<button data-toggle="modal" data-target-id="'.$data->id.'" data-target="#sendReport" class="btn btn-danger btn-md"><i class="fa fa-info p-r-5"></i> Report</a>';
    
                    return $problemBtn;
                })
                ->rawColumns(['company_websites', 'inquiry', 'website_problem'])->setRowId(function ($data) {
                    return $data->id;
                })
                ->make(true);
        }
    }

}
