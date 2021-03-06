<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Services\AuditorService;

use App\Models\User;
use App\Models\Countries;
use App\Models\JobsStatus;
use App\Models\ResearchJobs;
use App\Models\InquiryJobs;
use App\Models\AuditorInquiryJobs;
use App\Models\AuditorResearchJobs;
use App\Models\ProductCategory;
use App\Models\Settings;
use App\Models\WorkerNotifications;

class AuditorController extends Controller
{
    private $service;

    public function __construct(AuditorService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $auth = Auth::user();
        $auditorHowWeWork = Settings::where('id', 3)->first();

        $updateWeWork = WorkerNotifications::where('user_id', $auth->id)->update(['how_we_work' => 0]);

        return view('workers/auditor/index', compact('auditorHowWeWork'));
    }

    public function showResearches()
    {
        $user = Auth::user();

        $listCountries = Countries::all();

        $productCategory = User::where('product_category_id', $user->product_category_id)->with('ProductCategory')->get();
        $productCategories = json_decode($productCategory, true);

        $listResearchJobs = ResearchJobs::where('job_status_id', 3)->where('product_category_id', $user->product_category_id)->where('is_blacklist', 'No')->with('Country', 'JobsStatus')->get();
        $researchJobsLists = json_decode($listResearchJobs, true);
        
        return view('workers/auditor/researches', compact('researchJobsLists','listCountries','productCategories', 'user'))->with('i');
    }

    public function showDetailResearches($id)
    {   
        $listJobsStatus = JobsStatus::whereNotIn('id', array(4))->get();
        $listResearchJobs = ResearchJobs::where('id', $id)->with('Country', 'JobsStatus', 'ProductCategory')->get();
        $researchJobsLists = json_decode($listResearchJobs, true);

        foreach($researchJobsLists as $researchList){
            $researchJobsLists = $researchList;
        }

        return view('workers/auditor/updateResearches', compact('researchJobsLists', 'listJobsStatus'))->with('i');
    }

    public function showInquiries()
    {
        $user = Auth::user();

        $listCountries = Countries::all();

        $productCategory = User::where('product_category_id', $user->product_category_id)->with('ProductCategory')->get();
        
        $productCategories = json_decode($productCategory, true);

        $researchJobsId = [];

        $listResearchJobs = ResearchJobs::where('product_category_id', $user->product_category_id)->with('Country', 'JobsStatus')->get();
        
        if(count($listResearchJobs) == 0){
            $inquiryJobsLists = [];

            return view('workers/auditor/inquiries', compact('inquiryJobsLists','listCountries','productCategories', 'user'))->with('i');
        }
        
        $researchJobsLists = json_decode($listResearchJobs, true);

        foreach($researchJobsLists as $researchLists){
            array_push($researchJobsId, $researchLists['id']);
        }

        if(count($researchJobsId) == 0){
            $researchJobsId = 0;
        }

        $listInquiryJobs = InquiryJobs::whereIn('research_jobs_id', $researchJobsId)->where('job_status_id', 3)->where('is_form', 'Yes')->with('ResearchJobs', 'JobsStatus')->get();
        $inquiryJobsLists = json_decode($listInquiryJobs, true);
        
        return view('workers/auditor/inquiries', compact('inquiryJobsLists','listCountries','productCategories', 'user'))->with('i');
    }

    public function showDetailInquiries($id)
    {   
        $listJobsStatus = JobsStatus::whereNotIn('id', array(4))->get();
        $listInquiryJobs = InquiryJobs::where('id', $id)->with('JobsStatus', 'ResearchJobs')->get();
        $inquiryJobsLists = json_decode($listInquiryJobs, true);

        foreach($inquiryJobsLists as $inquiryList){
            $inquiryJobsLists = $inquiryList;
        }

        return view('workers/auditor/updateInquiries', compact('inquiryJobsLists','listJobsStatus'))->with('i');
    }

    public function showFAQ()
    {
        $auth = Auth::user();
        $auditorFAQ = Settings::where('id', 6)->first();

        $updateFAQ = WorkerNotifications::where('user_id', $auth->id)->update(['faq' => 0]);

        return view('workers/auditor/faq', compact('auditorFAQ'));
    }

    public function showNotice()
    {
        $auth = Auth::user();
        $auditorNotice = Settings::where('id', 7)->first();

        $updateNotice = WorkerNotifications::where('user_id', $auth->id)->update(['notice' => 0]);

        return view('workers/auditor/notice', compact('auditorNotice'));
    }

    public function showPayments()
    {
        $userId = Auth::user()->id;
        $user = User::where('id', $userId)->first();

        $researchQuantity = count(AuditorResearchJobs::where('user_id', $userId)->get());
        $inquiriesQuantity = count(AuditorInquiryJobs::where('user_id', $userId)->get());
        $researchPaid = $user->quantity_auditor_research_paid;
        $inquiriesPaid = $user->quantity_auditor_inquire_paid;
        $amountPaid = $user->amount_paid;

        return view('workers/auditor/payments', compact('researchQuantity', 'inquiriesQuantity', 'researchPaid', 'inquiriesPaid', 'amountPaid'));
    }

    public function showMyWork()
    {
        $userId = Auth::user()->id;
        
        $companiesUpdated = count(AuditorResearchJobs::where('user_id', $userId)->get());
        $inquiriesUpdated = count(AuditorInquiryJobs::where('user_id', $userId)->get());

        return view('workers/auditor/my-work', compact('companiesUpdated', 'inquiriesUpdated'));
    }

    public function showProfile()
    {
        $listCountries = Countries::all();

        $userId = Auth::user()->id;
        $dataUser = User::where('id', $userId)->with('Country')->get();
        $userData = json_decode($dataUser, true);

        foreach($userData as $user){
            $userData = $user;
        }

        return view('workers/auditor/profile', compact('userData','listCountries'))->with('i');
    }

    public function updateInquiries(Request $request, $id)
    {
        $request->validate([
            'job_status_id' => 'required',
        ]);

        return $this->service->updateInquiries($request, $id);
    }

    public function updateResearches(Request $request, $id)
    {
        $request->validate([
            'is_form'       => 'required',
            'job_status_id' => 'required',
        ]);

        return $this->service->updateResearches($request, $id);
    }

    public function updateProfile(Request $request)
    {
        $id = Auth::user()->id;
        return $this->service->updateProfile($request, $id);
    }

}
