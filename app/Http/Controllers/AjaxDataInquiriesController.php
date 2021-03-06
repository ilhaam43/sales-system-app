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

class AjaxDataInquiriesController extends Controller
{

    public function allDataInquiries(Request $request)
    {
        if ($request->ajax()) {
            $user = Auth::user();

            $researchJobsId = [];

            $listResearchJobs = ResearchJobs::where('product_category_id', $user->product_category_id)->with('Country', 'JobsStatus')->get();
            
            if(count($listResearchJobs) == 0)
            {
                $data = InquiryJobs::whereIn('research_jobs_id', $researchJobsId)->where('is_form', 'Yes')->with(['ResearchJobs', 'JobsStatus','User'])->select('inquiry_jobs.*');

            }else if(count($listResearchJobs) > 0){
                $researchJobsLists = json_decode($listResearchJobs, true);

                foreach($researchJobsLists as $researchLists){
                    array_push($researchJobsId, $researchLists['id']);
                }

                if(count($researchJobsId) == 0){
                    $researchJobsId = 0;
                }

                $data = InquiryJobs::whereIn('research_jobs_id', $researchJobsId)->where('is_form', 'Yes')->with(['ResearchJobs', 'JobsStatus','User'])->select('inquiry_jobs.*');
            }  
                return Datatables::eloquent($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($data){
                        $routeEdit = route('admin.inquiries.update',$data->id);
                        $actionBtn = '<a href="'.$routeEdit.'" class="edit btn btn-primary btn-sm" target="_blank">Edit</a>';
                        return $actionBtn;
                    })->addColumn('website', function($data){
                        $datas = json_decode($data, true);

                        $websiteBtn = '<a href="'.$datas['research_jobs']['company_website'].'" class="btn btn-info btn-sm" target="_blank">Website Link</a>';
                        return $websiteBtn;
                    })->addColumn('checkbox', function($data){
                        $checkbox = '<input type="checkbox" name="id_inquiries[]" id="id_inquiries" value="'.$data->id.'">';
                        return $checkbox;
                    })->addColumn('status', function($data){
                        $datas = json_decode($data, true);

                        return $datas['jobs_status']['status'];
                    })->addColumn('screenshot', function($data){
                        if($data->screenshot_url !== NULL){
                            $screenshotBtn = '<a href="'.asset($data->screenshot_url).'" class="btn btn-primary btn-sm" target="_blank">Screenshot</a>';
                        }else{
                            $screenshotBtn = 'DELETED';
                        }
    
                        return $screenshotBtn;
                    })->addColumn('user', function($data){
                        $datas = json_decode($data, true);

                        $idUser = $datas['user']['id'] ?? '';
                        $nameUser = $datas['user']['name'] ?? '';

                        $userLink = '<a href="/admin/workers/inqurier/'.$idUser.'">'.$nameUser.'</a>';
    
                        return $userLink;
                    })
                    ->rawColumns(['action', 'website', 'checkbox', 'status', 'user','screenshot'])->setRowId(function ($data) {
                        return $data->id;
                    })
                    ->make(true);
            }
    }

    public function approvedDataInquiries(Request $request)
    {
        if ($request->ajax()) {
            $user = Auth::user();
    
            $researchJobsId = [];
    
            $listResearchJobs = ResearchJobs::where('product_category_id', $user->product_category_id)->with('Country', 'JobsStatus')->get();

            if(count($listResearchJobs) == 0){

                $data = InquiryJobs::whereIn('research_jobs_id', $researchJobsId)->where('is_form', 'Yes')->where('job_status_id', 1)->with(['ResearchJobs', 'JobsStatus','User'])->select('inquiry_jobs.*');

            }else if(count($listResearchJobs) > 0){
                $researchJobsLists = json_decode($listResearchJobs, true);
        
                foreach($researchJobsLists as $researchLists){
                    array_push($researchJobsId, $researchLists['id']);
                }
        
                if(count($researchJobsId) == 0){
                    $researchJobsId = 0;
                }
        
                $data = InquiryJobs::whereIn('research_jobs_id', $researchJobsId)->where('is_form', 'Yes')->where('job_status_id', 1)->with(['ResearchJobs', 'JobsStatus','User'])->select('inquiry_jobs.*');
            } 
                return Datatables::eloquent($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($data){
                        $routeEdit = route('admin.inquiries.update',$data->id);
                        $actionBtn = '<a href="'.$routeEdit.'" class="edit btn btn-primary btn-sm" target="_blank">Edit</a>';
                        return $actionBtn;
                    })->addColumn('website', function($data){
                        $datas = json_decode($data, true);
    
                        $websiteBtn = '<a href="'.$datas['research_jobs']['company_website'].'" class="btn btn-info btn-sm" target="_blank">Website Link</a>';
                        return $websiteBtn;
                    })->addColumn('checkbox', function($data){
                        $checkbox = '<input type="checkbox" name="id_inquiries[]" id="id_inquiries" value="'.$data->id.'">';
                        return $checkbox;
                    })->addColumn('status', function($data){
                        $datas = json_decode($data, true);
    
                        return $datas['jobs_status']['status'];
                    })->addColumn('screenshot', function($data){
                        if($data->screenshot_url !== NULL){
                            $screenshotBtn = '<a href="'.asset($data->screenshot_url).'" class="btn btn-primary btn-sm" target="_blank">Screenshot</a>';
                        }else{
                            $screenshotBtn = 'DELETED';
                        }
    
                        return $screenshotBtn;
                    })->addColumn('user', function($data){
                        $datas = json_decode($data, true);

                        $idUser = $datas['user']['id'] ?? '';
                        $nameUser = $datas['user']['name'] ?? '';

                        $userLink = '<a href="/admin/workers/inqurier/'.$idUser.'">'.$nameUser.'</a>';
    
                        return $userLink;
                    })
                    ->rawColumns(['action', 'website', 'checkbox', 'status', 'user','screenshot'])->setRowId(function ($data) {
                        return $data->id;
                    })
                    ->make(true);
            }
    }

    public function rejectedDataInquiries(Request $request)
    {
        if ($request->ajax()) {
            $user = Auth::user();
    
            $researchJobsId = [];
    
            $listResearchJobs = ResearchJobs::where('product_category_id', $user->product_category_id)->with('Country', 'JobsStatus')->get();

            if(count($listResearchJobs) == 0){

                $data = InquiryJobs::whereIn('research_jobs_id', $researchJobsId)->where('is_form', 'Yes')->where('job_status_id', 2)->with(['ResearchJobs', 'JobsStatus','User'])->select('inquiry_jobs.*');

            }else if(count($listResearchJobs) > 0){

                $researchJobsLists = json_decode($listResearchJobs, true);
        
                foreach($researchJobsLists as $researchLists){
                    array_push($researchJobsId, $researchLists['id']);
                }
        
                if(count($researchJobsId) == 0){
                    $researchJobsId = 0;
                }
        
                $data = InquiryJobs::whereIn('research_jobs_id', $researchJobsId)->where('is_form', 'Yes')->where('job_status_id', 2)->with(['ResearchJobs', 'JobsStatus','User'])->select('inquiry_jobs.*');
            }   
                return Datatables::eloquent($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($data){
                        $routeEdit = route('admin.inquiries.update',$data->id);
                        $actionBtn = '<a href="'.$routeEdit.'" class="edit btn btn-primary btn-sm" target="_blank">Edit</a>';
                        return $actionBtn;
                    })->addColumn('website', function($data){
                        $datas = json_decode($data, true);
    
                        $websiteBtn = '<a href="'.$datas['research_jobs']['company_website'].'" class="btn btn-info btn-sm" target="_blank">Website Link</a>';
                        return $websiteBtn;
                    })->addColumn('checkbox', function($data){
                        $checkbox = '<input type="checkbox" name="id_inquiries[]" id="id_inquiries" value="'.$data->id.'">';
                        return $checkbox;
                    })->addColumn('status', function($data){
                        $datas = json_decode($data, true);
    
                        return $datas['jobs_status']['status'];
                    })->addColumn('screenshot', function($data){
                        if($data->screenshot_url !== NULL){
                            $screenshotBtn = '<a href="'.asset($data->screenshot_url).'" class="btn btn-primary btn-sm" target="_blank">Screenshot</a>';
                        }else{
                            $screenshotBtn = 'DELETED';
                        }
    
                        return $screenshotBtn;
                    })->addColumn('user', function($data){
                        $datas = json_decode($data, true);

                        $idUser = $datas['user']['id'] ?? '';
                        $nameUser = $datas['user']['name'] ?? '';

                        $userLink = '<a href="/admin/workers/inqurier/'.$idUser.'">'.$nameUser.'</a>';
    
                        return $userLink;
                    })
                    ->rawColumns(['action', 'website', 'checkbox', 'status', 'user','screenshot'])->setRowId(function ($data) {
                        return $data->id;
                    })
                    ->make(true);
        }
    }

    public function pendingDataInquiries(Request $request)
    {
        if ($request->ajax()) {
            $user = Auth::user();
    
            $researchJobsId = [];
    
            $listResearchJobs = ResearchJobs::where('product_category_id', $user->product_category_id)->with('Country', 'JobsStatus')->get();
            
            if(count($listResearchJobs) == 0){

                $data = InquiryJobs::whereIn('research_jobs_id', $researchJobsId)->where('is_form', 'Yes')->where('job_status_id', 3)->with(['ResearchJobs', 'JobsStatus','User'])->select('inquiry_jobs.*');

            }else if(count($listResearchJobs) > 0){
            
                $researchJobsLists = json_decode($listResearchJobs, true);
        
                foreach($researchJobsLists as $researchLists){
                    array_push($researchJobsId, $researchLists['id']);
                }
        
                if(count($researchJobsId) == 0){
                    $researchJobsId = 0;
                }
        
                $data = InquiryJobs::whereIn('research_jobs_id', $researchJobsId)->where('is_form', 'Yes')->where('job_status_id', 3)->with(['ResearchJobs', 'JobsStatus','User'])->select('inquiry_jobs.*');
            }
                return Datatables::eloquent($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($data){
                        $routeEdit = route('admin.inquiries.update',$data->id);
                        $actionBtn = '<a href="'.$routeEdit.'" class="edit btn btn-primary btn-sm" target="_blank">Edit</a>';
                        return $actionBtn;
                    })->addColumn('website', function($data){
                        $datas = json_decode($data, true);
    
                        $websiteBtn = '<a href="'.$datas['research_jobs']['company_website'].'" class="btn btn-info btn-sm" target="_blank">Website Link</a>';
                        return $websiteBtn;
                    })->addColumn('checkbox', function($data){
                        $checkbox = '<input type="checkbox" name="id_inquiries[]" id="id_inquiries" value="'.$data->id.'">';
                        return $checkbox;
                    })->addColumn('status', function($data){
                        $datas = json_decode($data, true);
    
                        return $datas['jobs_status']['status'];
                    })->addColumn('screenshot', function($data){
                        if($data->screenshot_url !== NULL){
                            $screenshotBtn = '<a href="'.asset($data->screenshot_url).'" class="btn btn-primary btn-sm" target="_blank">Screenshot</a>';
                        }else{
                            $screenshotBtn = 'DELETED';
                        }
    
                        return $screenshotBtn;
                    })->addColumn('user', function($data){
                        $datas = json_decode($data, true);

                        $idUser = $datas['user']['id'] ?? '';
                        $nameUser = $datas['user']['name'] ?? '';

                        $userLink = '<a href="/admin/workers/inqurier/'.$idUser.'">'.$nameUser.'</a>';
    
                        return $userLink;
                    })
                    ->rawColumns(['action', 'website', 'checkbox', 'status', 'user','screenshot'])->setRowId(function ($data) {
                        return $data->id;
                    })
                    ->make(true);
        }
    }

    public function removedDataInquiries(Request $request)
    {
        if ($request->ajax()) {
            $user = Auth::user();
    
            $researchJobsId = [];
    
            $listResearchJobs = ResearchJobs::where('product_category_id', $user->product_category_id)->with('Country', 'JobsStatus')->get();
            
            if(count($listResearchJobs) == 0){

                $data = InquiryJobs::whereIn('research_jobs_id', $researchJobsId)->where('is_form', 'Yes')->where('job_status_id', 4)->with(['ResearchJobs', 'JobsStatus','User'])->select('inquiry_jobs.*');

            }else if(count($listResearchJobs) > 0){

                $researchJobsLists = json_decode($listResearchJobs, true);
        
                foreach($researchJobsLists as $researchLists){
                    array_push($researchJobsId, $researchLists['id']);
                }
        
                if(count($researchJobsId) == 0){
                    $researchJobsId = 0;
                }
        
                $data = InquiryJobs::whereIn('research_jobs_id', $researchJobsId)->where('is_form', 'Yes')->where('job_status_id', 4)->with(['ResearchJobs', 'JobsStatus','User'])->select('inquiry_jobs.*');
            }
                return Datatables::eloquent($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($data){
                        $routeEdit = route('admin.inquiries.update',$data->id);
                        $actionBtn = '<a href="'.$routeEdit.'" class="edit btn btn-primary btn-sm" target="_blank">Edit</a>';
                        return $actionBtn;
                    })->addColumn('website', function($data){
                        $datas = json_decode($data, true);
    
                        $websiteBtn = '<a href="'.$datas['research_jobs']['company_website'].'" class="btn btn-info btn-sm" target="_blank">Website Link</a>';
                        return $websiteBtn;
                    })->addColumn('checkbox', function($data){
                        $checkbox = '<input type="checkbox" name="id_inquiries[]" id="id_inquiries" value="'.$data->id.'">';
                        return $checkbox;
                    })->addColumn('status', function($data){
                        $datas = json_decode($data, true);
    
                        return $datas['jobs_status']['status'];
                    })->addColumn('screenshot', function($data){
                        if($data->screenshot_url !== NULL){
                            $screenshotBtn = '<a href="'.asset($data->screenshot_url).'" class="btn btn-primary btn-sm" target="_blank">Screenshot</a>';
                        }else{
                            $screenshotBtn = 'DELETED';
                        }
    
                        return $screenshotBtn;
                    })->addColumn('user', function($data){
                        $datas = json_decode($data, true);

                        $idUser = $datas['user']['id'] ?? '';
                        $nameUser = $datas['user']['name'] ?? '';

                        $userLink = '<a href="/admin/workers/inqurier/'.$idUser.'">'.$nameUser.'</a>';
    
                        return $userLink;
                    })
                    ->rawColumns(['action', 'website', 'checkbox', 'status', 'user','screenshot'])->setRowId(function ($data) {
                        return $data->id;
                    })
                    ->make(true);
        }
    }

    public function showInqurierData(Request $request)
    {
        if ($request->ajax()) {
            $user = Auth::user();

            $data = InquiryJobs::where('user_id', $user->id)->where('is_form', 'Yes')->with('ResearchJobs.Country','JobsStatus');

            return Datatables::eloquent($data)
                    ->addIndexColumn()
                    ->setRowId(function ($data) {
                        return $data->id;
                    })
                    ->make(true);
        }
    }

    public function showReportsData(Request $request)
    {
        if ($request->ajax()) {
            $user = Auth::user();

            $researchJobsId = [];

            $listResearchJobs = ResearchJobs::where('product_category_id', $user->product_category_id)->with('Country', 'JobsStatus')->get();
            
            if(count($listResearchJobs) == 0)
            {
                $inquiryJobsLists = $listResearchJobs;
                return view('/admin/reports/index', compact('inquiryJobsLists'))->with('i');
            }
            
            $researchJobsLists = json_decode($listResearchJobs, true);

            foreach($researchJobsLists as $researchLists){
                array_push($researchJobsId, $researchLists['id']);
            }

            if(count($researchJobsId) == 0){
                $researchJobsId = 0;
            }

            $data = InquiryJobs::whereIn('research_jobs_id', $researchJobsId)->where('is_form', 'No')->with('ResearchJobs', 'JobsStatus','User')->select('inquiry_jobs.*');

            return Datatables::eloquent($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($data){
                        $datas = json_decode($data, true);
                        $routeEdit = route('admin.reports.update',$datas['research_jobs']['id']);
                        $routeDelete = route('admin.reports.destroy',$datas['id']);

                        $actionBtn = '<a href="'.$routeEdit.'" class="edit btn btn-primary btn-sm" target="_blank">Edit</a> <button class="btn btn-danger btn-sm remove-user" data-id="'.$datas['id'].'" data-action="'.$routeDelete.'" onclick="deleteConfirmation('.$datas['id'].')"> Delete</button>';
                        return $actionBtn;
                    })->addColumn('checkbox', function($data){
                        $datas = json_decode($data, true);
                        $checkbox = '<input type="checkbox" name="id_inquiries[]" id="'.$data->id.'" value="'.$datas['research_jobs']['id'].'">';
                        return $checkbox;
                    })
                    ->rawColumns(['action', 'checkbox'])->setRowId(function ($data) {
                        return $data->id;
                    })
                    ->make(true);
            }
    }

}
