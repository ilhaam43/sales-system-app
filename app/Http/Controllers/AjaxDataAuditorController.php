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

class AjaxDataAuditorController extends Controller
{
    public function showResearchesData(Request $request)
    {
        if ($request->ajax()) {
            $user = Auth::user();

            $data = ResearchJobs::where('job_status_id', 3)->where('product_category_id', $user->product_category_id)->where('is_blacklist', 'No')->with(['Country', 'JobsStatus'])->inRandomOrder()->select('research_jobs.*');

            return Datatables::eloquent($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    $routeEdit = route('auditor.detail.researches',$data->id);

                    $actionBtn = '<a class="btn btn-primary btn-sm" href="'.$routeEdit.'">Edit</a>';

                    return $actionBtn;
                })->addColumn('status', function($data){
                    $datas = json_decode($data, true);

                    return $datas['jobs_status']['status'] ?? "";
                })->rawColumns(['action', 'status'])->setRowId(function ($data) {
                    return $data->id;
                })->make(true);
        }
    }

    public function showInquiriesData(Request $request)
    {
        if ($request->ajax()) {
            $user = Auth::user();

            $researchJobsId = [];

            $listResearchJobs = ResearchJobs::where('product_category_id', $user->product_category_id)->with('Country', 'JobsStatus')->get();
            
            if(count($listResearchJobs) == 0){

                $data = InquiryJobs::whereIn('research_jobs_id', $researchJobsId)->where('job_status_id', 3)->where('is_form', 'Yes')->with(['ResearchJobs', 'JobsStatus'])->inRandomOrder()->select('inquiry_jobs.*');

            }else if(count($listResearchJobs) > 0){

                $researchJobsLists = json_decode($listResearchJobs, true);

                foreach($researchJobsLists as $researchLists){
                    array_push($researchJobsId, $researchLists['id']);
                }

                if(count($researchJobsId) == 0){
                    $researchJobsId = 0;
                }

                $data = InquiryJobs::whereIn('research_jobs_id', $researchJobsId)->where('job_status_id', 3)->where('is_form', 'Yes')->with(['ResearchJobs', 'JobsStatus'])->select('inquiry_jobs.*');
            }
            
            return Datatables::eloquent($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    $routeEdit = route('auditor.detail.inquiries',$data->id);

                    $actionBtn = '<a class="btn btn-primary btn-sm" href="'.$routeEdit.'">Edit</a>';

                    return $actionBtn;
                })->addColumn('screenshot', function($data){
                    $url = asset($data->screenshot_url);
                    $screenshotLink = '<a href="'.$url.'">Screenshot</a>';

                    return $screenshotLink ?? "";
                })->addColumn('status', function($data){
                    $datas = json_decode($data, true);

                    return $datas['jobs_status']['status'] ?? "";
                })->rawColumns(['action', 'screenshot', 'status'])->setRowId(function ($data) {
                    return $data->id;
                })->make(true);
        }
    }
}
