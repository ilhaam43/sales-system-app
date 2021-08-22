<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Services\AdminService;

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

use App\Exports\ApprovedResearches;
use Excel;

class AdminController extends Controller
{
    private $service;

    public function __construct(AdminService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $researchJobsId = [];
        $auth = Auth::user();

        $listResearchJobs = ResearchJobs::where('product_category_id', $auth->product_category_id)->get();

        if(count($listResearchJobs) == 0)
        {
            $researchApproved = 0;
            $inquiryApproved = 0;
            
            $user = count(User::whereNotIn('id', [1,2])->where('product_category_id', $auth->product_category_id)->get());

            return view('/admin/index', compact('researchApproved','inquiryApproved','user'));
        }

        $researchJobsLists = json_decode($listResearchJobs, true);

        foreach($researchJobsLists as $researchLists){
            array_push($researchJobsId, $researchLists['id']);
        }

        if(count($researchJobsId) == 0){
            $researchJobsId = 0;
        }

        $researchApproved = count(ResearchJobs::where('product_category_id', $auth->product_category_id)->where('job_status_id', 1)->where('is_blacklist', 'No')->get());

        $inquiryApproved = count(InquiryJobs::whereIn('research_jobs_id', $researchJobsId)->where('job_status_id', 1)->where('is_form', 'Yes')->get());

        $user = count(User::whereNotIn('id', [1,2])->where('product_category_id', $auth->product_category_id)->get());

        return view('/admin/index', compact('researchApproved','inquiryApproved','user'));
    }

    //photo function
    public function showPhotoList()
    {
        $photos = Photos::all();
        return view('/admin/photos/listPhotos', compact('photos'))->with('i');
    }

    public function addPhoto(Request $request)
    {
        $request->validate([
            'photo_name' => 'required',
            'photo_image' => 'required|mimes:jpeg,bmp,png'
        ]);

        return $this->service->addPhoto($request);
    }

    public function deletePhoto($id)
    {
        return $this->service->deletePhoto($id);
    }

    //all users function
    public function showUsersList()
    {
        $auth = Auth::user();
        $user = User::whereNotIn('role_id', [1,2])->where('product_category_id', $auth->product_category_id)->with('ProductCategory', 'UsersStatus', 'UsersRole', 'Country')->get();
        $users = json_decode($user, true);
        
        return view('/admin/users/index', compact('users'))->with('i');
    }

    public function showUsersDetails($id)
    {
        $users = User::find($id);

        if(!$users){
            return redirect()->route('admin.users.index');
        }

        $usersRole = UsersRole::all();
        $usersStatus = UsersStatus::all();
        $listCountries = Countries::all();
        $productCategory = ProductCategory::all();

        return view('/admin/users/updateUsers', compact('users', 'usersRole', 'usersStatus','listCountries', 'productCategory'))->with('i');
    }

    public function updateUsers(Request $request, $id)
    {
        $request->validate([
            'role_id'   => 'required',
            'status_id' => 'required',
            'country_id'      => 'required',
            'product_category_id' => 'required',
            'name'      => 'required',
            'email'     => 'required|email',
        ]);

        return $this->service->updateUsers($request, $id);
    }

    public function deleteUsers($id)
    {
        return $this->service->deleteUsers($id);
    }

    public function blockUsers(Request $request)
    {
        $request->validate([
            'id'   => 'required',
        ]);

        return $this->service->blockUsers($request);
    }

    //workers function
    public function showWorkersList($workers)
    {
        $usersRole = UsersRole::where('role', $workers)->get();

        if(count($usersRole) == 0){
            return redirect()->route('admin.workers.index');
        }
        
        foreach($usersRole as $i => $roles){
            $usersRole[$i] = $roles;
        }

        $auth = Auth::user();

        $workersList = User::where('role_id', $roles->id)->where('product_category_id', $auth->product_category_id)->with('ProductCategory', 'UsersStatus', 'UsersRole', 'Country')->get();
        $workersLists = json_decode($workersList, true);

        return view('/admin/workers/index', compact('workersLists', 'workers'))->with('i');
    }

    public function showWorkersDetails($workers, $id)
    {
        $worker = User::find($id);

        if(!$worker){
            return redirect()->route('workers.index',$workers);
        }

        $countResearch = count(ResearchJobs::where('user_id', $id)->get());
        $countInquiry = count(InquiryJobs::where('user_id', $id)->where('is_form', 'Yes')->get());
        $countAuditorResearch = count(AuditorResearchJobs::where('user_id', $id)->get());
        $countAuditorInquiry = count(AuditorInquiryJobs::where('user_id', $id)->get());

        $usersRole = UsersRole::all();
        $usersStatus = UsersStatus::all();
        $listCountries = Countries::all();
        $productCategory = ProductCategory::all();

        return view('/admin/workers/updateWorkers', compact('worker', 'workers', 'usersRole', 'usersStatus','listCountries', 'productCategory', 'countResearch', 'countInquiry', 'countAuditorResearch', 'countAuditorInquiry'))->with('i');
    }

    public function updateUserWorkers(Request $request, $workers, $id)
    {
        $request->validate([
            'role_id'   => 'required',
            'status_id' => 'required',
            'country_id'      => 'required',
            'product_category_id' => 'required',
            'name'      => 'required',
            'email'     => 'required|email',
        ]);

        return $this->service->updateUserWorkers($request, $workers, $id);
    }

    public function deleteUserWorkers($workers, $id)
    {
        return $this->service->deleteUserWorkers($workers, $id);
    }

    //researches function
    public function showAllResearches()
    {
        $auth = Auth::user();

        $listResearches = ResearchJobs::where('product_category_id', $auth->product_category_id)->where('is_blacklist', 'No')->with('Country', 'JobsStatus', 'AuditorResearchJobs.User', 'User')->get();

        $researchesList = json_decode($listResearches, true);

        return view('/admin/researches/index', compact('researchesList'))->with('i');
    }

    public function showApprovedResearches()
    {
        $auth = Auth::user();

        $listResearches = ResearchJobs::where('product_category_id', $auth->product_category_id)->where('job_status_id', 1)->where('is_blacklist', 'No')->with('Country', 'JobsStatus', 'AuditorResearchJobs.User', 'User')->get();

        $researchesList = json_decode($listResearches, true);

        return view('/admin/researches/approved', compact('researchesList'))->with('i');
    }

    public function exportApprovedResearches()
    {
        $auth = Auth::user();

        $listResearches = ResearchJobs::where('product_category_id', $auth->product_category_id)->where('job_status_id', 1)->where('is_blacklist', 'No')->with('Country', 'JobsStatus', 'AuditorResearchJobs.User', 'User', 'ProductSources')->get();

        $researchesList = json_decode($listResearches, true);

        $i = 0;

        return Excel::download(new ApprovedResearches($researchesList, $i), 'research_approved.xlsx');
    }

    public function showPendingResearches()
    {
        $auth = Auth::user();

        $listResearches = ResearchJobs::where('product_category_id', $auth->product_category_id)->where('job_status_id', 3)->where('is_blacklist', 'No')->with('Country', 'JobsStatus', 'AuditorResearchJobs.User', 'User')->get();

        $researchesList = json_decode($listResearches, true);

        return view('/admin/researches/pending', compact('researchesList'))->with('i');
    }

    public function showRejectedResearches()
    {
        $auth = Auth::user();

        $listResearches = ResearchJobs::where('product_category_id', $auth->product_category_id)->where('job_status_id', 2)->where('is_blacklist', 'No')->with('Country', 'JobsStatus', 'AuditorResearchJobs.User', 'User')->get();

        $researchesList = json_decode($listResearches, true);

        return view('/admin/researches/rejected', compact('researchesList'))->with('i');
    }

    public function showRemovedResearches()
    {
        $auth = Auth::user();

        $listResearches = ResearchJobs::where('product_category_id', $auth->product_category_id)->where('job_status_id', 4)->where('is_blacklist', 'No')->with('Country', 'JobsStatus', 'AuditorResearchJobs.User', 'User')->get();

        $researchesList = json_decode($listResearches, true);

        return view('/admin/researches/removed', compact('researchesList'))->with('i');
    }

    public function showDetailResearches($id)
    {   
        $listCountries = Countries::all();
        $jobsStatus = JobsStatus::all();
        $listResearchJobs = ResearchJobs::where('id', $id)->with('Country', 'JobsStatus')->get();
        $researchJobsLists = json_decode($listResearchJobs, true);

        foreach($researchJobsLists as $researchList){
            $researchJobsLists = $researchList;
        }

        return view('admin/researches/updateResearches', compact('researchJobsLists', 'listCountries', 'jobsStatus'))->with('i');
    }

    public function updateResearches(Request $request, $id)
    {
        $request->validate([
            'country_id'            => 'required',
            'company_name'          => 'required',
            'company_website'       => 'required',
            'company_email'         => 'required|email',
            'company_phone'         => 'required',
            'company_product_url'   => 'required',
        ]);

        return $this->service->updateResearches($request, $id);
    }

    public function approveResearches(Request $request)
    {
        $request->validate([
            'id'   => 'required',
        ]);

        return $this->service->approveResearches($request);
    }

    public function rejectResearches(Request $request)
    {
        $request->validate([
            'id'   => 'required',
        ]);

        return $this->service->rejectResearches($request);
    }

    public function blacklistResearches(Request $request)
    {
        $request->validate([
            'id'   => 'required',
        ]);

        return $this->service->blacklistResearches($request);
    }

    //inquiries function
    public function showAllInquiries()
    {
        $user = Auth::user();

        $researchJobsId = [];

        $listResearchJobs = ResearchJobs::where('product_category_id', $user->product_category_id)->with('Country', 'JobsStatus')->get();
        
        if(count($listResearchJobs) == 0)
        {
            $inquiryJobsLists = $listResearchJobs;
            return view('/admin/inquiries/index', compact('inquiryJobsLists'))->with('i');
        }

        $researchJobsLists = json_decode($listResearchJobs, true);

        foreach($researchJobsLists as $researchLists){
            array_push($researchJobsId, $researchLists['id']);
        }

        if(count($researchJobsId) == 0){
            $researchJobsId = 0;
        }

        $listInquiryJobs = InquiryJobs::whereIn('research_jobs_id', $researchJobsId)->where('is_form', 'Yes')->with('ResearchJobs', 'JobsStatus','User')->get();
        $inquiryJobsLists = json_decode($listInquiryJobs, true);

        return view('/admin/inquiries/index', compact('inquiryJobsLists'))->with('i');
    }

    public function showApprovedInquiries()
    {
        $user = Auth::user();

        $researchJobsId = [];

        $listResearchJobs = ResearchJobs::where('product_category_id', $user->product_category_id)->with('Country', 'JobsStatus')->get();
        
        if(count($listResearchJobs) == 0)
        {
            $inquiryJobsLists = $listResearchJobs;
            return view('/admin/inquiries/approved', compact('inquiryJobsLists'))->with('i');
        }

        $researchJobsLists = json_decode($listResearchJobs, true);

        foreach($researchJobsLists as $researchLists){
            array_push($researchJobsId, $researchLists['id']);
        }

        if(count($researchJobsId) == 0){
            $researchJobsId = 0;
        }

        $listInquiryJobs = InquiryJobs::whereIn('research_jobs_id', $researchJobsId)->where('job_status_id', 1)->where('is_form', 'Yes')->with('ResearchJobs', 'JobsStatus','User')->get();
        $inquiryJobsLists = json_decode($listInquiryJobs, true);

        return view('/admin/inquiries/approved', compact('inquiryJobsLists'))->with('i');
    }

    public function showPendingInquiries()
    {
        $user = Auth::user();

        $researchJobsId = [];

        $listResearchJobs = ResearchJobs::where('product_category_id', $user->product_category_id)->with('Country', 'JobsStatus')->get();
        
        if(count($listResearchJobs) == 0)
        {
            $inquiryJobsLists = $listResearchJobs;
            return view('/admin/inquiries/pending', compact('inquiryJobsLists'))->with('i');
        }
        
        $researchJobsLists = json_decode($listResearchJobs, true);

        foreach($researchJobsLists as $researchLists){
            array_push($researchJobsId, $researchLists['id']);
        }

        if(count($researchJobsId) == 0){
            $researchJobsId = 0;
        }

        $listInquiryJobs = InquiryJobs::whereIn('research_jobs_id', $researchJobsId)->where('job_status_id', 3)->where('is_form', 'Yes')->with('ResearchJobs', 'JobsStatus','User')->get();
        $inquiryJobsLists = json_decode($listInquiryJobs, true);

        return view('/admin/inquiries/pending', compact('inquiryJobsLists'))->with('i');
    }

    public function showRejectedInquiries()
    {
        $user = Auth::user();

        $researchJobsId = [];

        $listResearchJobs = ResearchJobs::where('product_category_id', $user->product_category_id)->with('Country', 'JobsStatus')->get();
        
        if(count($listResearchJobs) == 0)
        {
            $inquiryJobsLists = $listResearchJobs;
            return view('/admin/inquiries/rejected', compact('inquiryJobsLists'))->with('i');
        }

        $researchJobsLists = json_decode($listResearchJobs, true);

        foreach($researchJobsLists as $researchLists){
            array_push($researchJobsId, $researchLists['id']);
        }

        if(count($researchJobsId) == 0){
            $researchJobsId = 0;
        }

        $listInquiryJobs = InquiryJobs::whereIn('research_jobs_id', $researchJobsId)->where('job_status_id', 2)->where('is_form', 'Yes')->with('ResearchJobs', 'JobsStatus','User')->get();
        $inquiryJobsLists = json_decode($listInquiryJobs, true);

        return view('/admin/inquiries/rejected', compact('inquiryJobsLists'))->with('i');
    }

    public function showRemovedInquiries()
    {
        $user = Auth::user();

        $researchJobsId = [];

        $listResearchJobs = ResearchJobs::where('product_category_id', $user->product_category_id)->with('Country', 'JobsStatus')->get();
        
        if(count($listResearchJobs) == 0)
        {
            $inquiryJobsLists = $listResearchJobs;
            return view('/admin/inquiries/removed', compact('inquiryJobsLists'))->with('i');
        }
        
        $researchJobsLists = json_decode($listResearchJobs, true);

        foreach($researchJobsLists as $researchLists){
            array_push($researchJobsId, $researchLists['id']);
        }

        if(count($researchJobsId) == 0){
            $researchJobsId = 0;
        }

        $listInquiryJobs = InquiryJobs::whereIn('research_jobs_id', $researchJobsId)->where('job_status_id', 4)->where('is_form', 'Yes')->with('ResearchJobs', 'JobsStatus','User')->get();
        $inquiryJobsLists = json_decode($listInquiryJobs, true);

        return view('/admin/inquiries/removed', compact('inquiryJobsLists'))->with('i');
    }

    public function showDetailInquiries($id)
    {
        $listJobsStatus = JobsStatus::whereNotIn('id', array(2))->get();
        $listInquiryJobs = InquiryJobs::where('id', $id)->with('JobsStatus', 'ResearchJobs')->get();
        $inquiryJobsLists = json_decode($listInquiryJobs, true);

        foreach($inquiryJobsLists as $inquiryList){
            $inquiryJobsLists = $inquiryList;
        }

        return view('admin/inquiries/updateInquiries', compact('inquiryJobsLists','listJobsStatus'))->with('i');
    }

    public function updateDetailInquiries(Request $request, $id)
    {
        $request->validate([
            'job_status_id' => 'required',
        ]);

        return $this->service->updateDetailInquiries($request, $id);
    }

    public function approveInquiries(Request $request)
    {
        $request->validate([
            'id'   => 'required',
        ]);

        return $this->service->approveInquiries($request);
    }

    public function rejectInquiries(Request $request)
    {
        $request->validate([
            'id'   => 'required',
        ]);

        return $this->service->rejectInquiries($request);
    }

    //reports function
    public function showAllReports()
    {
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

        $listInquiryJobs = InquiryJobs::whereIn('research_jobs_id', $researchJobsId)->where('is_form', 'No')->with('ResearchJobs', 'JobsStatus','User')->get();
        $inquiryJobsLists = json_decode($listInquiryJobs, true);

        return view('/admin/reports/index', compact('inquiryJobsLists'))->with('i');
    }

    public function showDetailReports($id)
    {
        $listInquiry = InquiryJobs::where('id', $id)->first();
        $listResearchJobs = ResearchJobs::where('id', $id)->with('Country', 'JobsStatus')->get();

        $researchJobsLists = json_decode($listResearchJobs, true);

        foreach($researchJobsLists as $researchList){
            $researchJobsLists = $researchList;
        }

        return view('admin/researches/updateResearches', compact('researchJobsLists', 'listCountries'))->with('i');
    }

    //blacklist function
    public function showAllBlacklist()
    {
        $auth = Auth::user();

        $listResearches = ResearchJobs::where('product_category_id', $auth->product_category_id)->where('is_blacklist', 'Yes')->with('Country', 'JobsStatus', 'AuditorResearchJobs.User', 'User')->get();

        $researchesList = json_decode($listResearches, true);

        return view('/admin/blacklist/index', compact('researchesList'))->with('i');
    }

    //sources function
    public function showSources()
    {
        $sources = ProductSources::all();

        return view('/admin/sources/listProductSources', compact('sources'))->with('i');
    }

    public function showDetailSources($id)
    {
        $sources = ProductSources::find($id);
        
        if(!$sources){
            return redirect()->route('admin.sources');
        }

        return view('/admin/sources/updateProductSources', compact('sources'));
    }

    public function deleteSources($id)
    {
        return $this->service->deleteSources($id);
    }

    public function addSources(Request $request)
    {
        $request->validate([
            'sources' => 'required'
        ]);

        return $this->service->addSources($request);
    }

    public function updateSources(Request $request, $id)
    {
        $request->validate([
            'sources' => 'required'
        ]);

        return $this->service->updateSources($request, $id);
    }

    //general setting function
    public function showFormAddGeneralSetting()
    {
        return view('/admin/setting/addGeneralSetting');
    }

    public function showGeneralSetting()
    {
        $settings = Settings::all();

        return view('/admin/setting/listGeneralSetting', compact('settings'))->with('i');
    }

    public function showDetailGeneralSetting($id)
    {
        $setting = Settings::find($id);

        return view('/admin/setting/updateGeneralSetting', compact('setting'));
    }

    public function addGeneralSetting(Request $request)
    {
        $request->validate([
            'setting_name' => 'required',
            'setting_description' => 'required'
        ]);

        return $this->service->addGeneralSetting($request);
    }

    public function updateGeneralSetting(Request $request, $id)
    {
        $request->validate([
            'setting_name' => 'required',
            'setting_description' => 'required'
        ]);

        return $this->service->updateGeneralSetting($request, $id);
    }

    public function deleteGeneralSetting($id)
    {
        return $this->service->deleteGeneralSetting($id);
    }
}
