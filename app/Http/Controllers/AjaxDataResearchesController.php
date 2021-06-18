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

class AjaxDataResearchesController extends Controller
{

    public function allDataResearches(Request $request)
    {
        if ($request->ajax()) {
            $auth = Auth::user();
            $data = ResearchJobs::where('product_category_id', $auth->product_category_id)->where('is_blacklist', 'No')->with('Country', 'JobsStatus', 'AuditorResearchJobs.User', 'User');
            
            return Datatables::eloquent($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">Edit</a>';
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

                    $researcherLink = '<a href="/admin/users/'.$data['user']['id'].'">'.$data['user']['name'] ?? '' .'</a>';
                    return $researcherLink;
                })->addColumn('auditor', function($data){
                    $datas = json_decode($data, true);

                    return $datas['auditor_research_jobs']['user']['name'] ?? "NO";
                })
                ->rawColumns(['action', 'website', 'checkbox', 'product_page', 'country', 'status', 'researcher','auditor'])->setRowId(function ($data) {
                    return $data->id;
                })
                ->make(true);
        }
    }

    public function approvedDataResearches(Request $request)
    {
        if ($request->ajax()) {
            $auth = Auth::user();
            $data = ResearchJobs::where('product_category_id', $auth->product_category_id)->where('job_status_id', 1)->where('is_blacklist', 'No')->with('Country', 'JobsStatus', 'AuditorResearchJobs.User', 'User');
            
            return Datatables::eloquent($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">Edit</a>';
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

                    $researcherLink = '<a href="/admin/users/'.$data['user']['id'].'">'.$data['user']['name'] ?? '' .'</a>';
                    return $researcherLink;
                })->addColumn('auditor', function($data){
                    $datas = json_decode($data, true);

                    return $datas['auditor_research_jobs']['user']['name'] ?? "NO";
                })
                ->rawColumns(['action', 'website', 'checkbox', 'product_page', 'country', 'status', 'researcher','auditor'])->setRowId(function ($data) {
                    return $data->id;
                })
                ->make(true);
        }
    }

    public function rejectedDataResearches(Request $request)
    {
        if ($request->ajax()) {
            $auth = Auth::user();
            $data = ResearchJobs::where('product_category_id', $auth->product_category_id)->where('job_status_id', 2)->where('is_blacklist', 'No')->with('Country', 'JobsStatus', 'AuditorResearchJobs.User', 'User');
            
            return Datatables::eloquent($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">Edit</a>';
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

                    $researcherLink = '<a href="/admin/users/'.$data['user']['id'].'">'.$data['user']['name'] ?? '' .'</a>';
                    return $researcherLink;
                })->addColumn('auditor', function($data){
                    $datas = json_decode($data, true);

                    return $datas['auditor_research_jobs']['user']['name'] ?? "NO";
                })
                ->rawColumns(['action', 'website', 'checkbox', 'product_page', 'country', 'status', 'researcher','auditor'])->setRowId(function ($data) {
                    return $data->id;
                })
                ->make(true);
        }
    }

    public function pendingDataResearches(Request $request)
    {
        if ($request->ajax()) {
            $auth = Auth::user();
            $data = ResearchJobs::where('product_category_id', $auth->product_category_id)->where('job_status_id', 3)->where('is_blacklist', 'No')->with('Country', 'JobsStatus', 'AuditorResearchJobs.User', 'User');
            
            return Datatables::eloquent($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">Edit</a>';
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

                    $researcherLink = '<a href="/admin/users/'.$data['user']['id'].'">'.$data['user']['name'] ?? '' .'</a>';
                    return $researcherLink;
                })->addColumn('auditor', function($data){
                    $datas = json_decode($data, true);

                    return $datas['auditor_research_jobs']['user']['name'] ?? "NO";
                })
                ->rawColumns(['action', 'website', 'checkbox', 'product_page', 'country', 'status', 'researcher','auditor'])->setRowId(function ($data) {
                    return $data->id;
                })
                ->make(true);
        }
    }

    public function removedDataResearches(Request $request)
    {
        if ($request->ajax()) {
            $auth = Auth::user();
            $data = ResearchJobs::where('product_category_id', $auth->product_category_id)->where('job_status_id', 4)->where('is_blacklist', 'No')->with('Country', 'JobsStatus', 'AuditorResearchJobs.User', 'User');
            
            return Datatables::eloquent($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">Edit</a>';
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

                    $researcherLink = '<a href="/admin/users/'.$data['user']['id'].'">'.$data['user']['name'] ?? '' .'</a>';
                    return $researcherLink;
                })->addColumn('auditor', function($data){
                    $datas = json_decode($data, true);

                    return $datas['auditor_research_jobs']['user']['name'] ?? "NO";
                })
                ->rawColumns(['action', 'website', 'checkbox', 'product_page', 'country', 'status', 'researcher','auditor'])->setRowId(function ($data) {
                    return $data->id;
                })
                ->make(true);
        }
    }

}
