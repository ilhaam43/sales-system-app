<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Services\InqurierService;

use App\Models\User;
use App\Models\Countries;
use App\Models\ResearchJobs;
use App\Models\InquiryJobs;
use App\Models\ProductCategory;
use App\Models\Settings;
use App\Models\WorkerNotifications;

class InqurierController extends Controller
{
    private $service;

    public function __construct(InqurierService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $auth = Auth::user();
        $inquirerHowWeWork = Settings::where('id', 2)->first();
        
        $updateWeWork = WorkerNotifications::where('user_id', $auth->id)->update(['how_we_work' => 0]);

        return view('workers/inqurier/index', compact('inquirerHowWeWork'));
    }

    public function showInquiries()
    {
        $user = Auth::user();

        $listInquiriesJobs = InquiryJobs::where('user_id', $user->id)->where('is_form', 'Yes')->with('ResearchJobs.Country','JobsStatus')->get();
        $inquiriesJobs = json_decode($listInquiriesJobs, true);

        return view('workers/inqurier/inquiries', compact('inquiriesJobs'))->with('i');
    }

    public function showCompanies()
    {
        $user = Auth::user();

        $listCompanies = ResearchJobs::where('job_status_id', 1)->where('is_blacklist', 'No')->where('product_category_id', $user->product_category_id)->with('Country')->inRandomOrder()->limit(10)->get();
        $companiesList = json_decode($listCompanies, true);

        return view('workers/inqurier/companies', compact('companiesList'))->with('i');
    }

    public function showFAQ()
    {
        $auth = Auth::user();
        $inquirerFAQ = Settings::where('id', 5)->first();

        $updateFAQ = WorkerNotifications::where('user_id', $auth->id)->update(['faq' => 0]);

        return view('workers/inqurier/faq', compact('inquirerFAQ'));
    }

    public function showNotice()
    {
        $auth = Auth::user();
        $inquirerNotice = Settings::where('id', 8)->first();

        $updateNotice = WorkerNotifications::where('user_id', $auth->id)->update(['notice' => 0]);

        return view('workers/inqurier/notice', compact('inquirerNotice'));
    }

    public function showPayments()
    {
        $userId = Auth::user()->id;
        $user = User::where('id', $userId)->first();

        $inquiryQuantity = count(InquiryJobs::where('user_id', $userId)->where('is_form', 'Yes')->get());
        $inquiryPaid = $user->quantity_inquire_paid;
        $amountPaid = $user->amount_paid;

        return view('workers/inqurier/payments', compact('inquiryQuantity', 'inquiryPaid', 'amountPaid'));
    }

    public function showMyWork()
    {
        $userId = Auth::user()->id;
        
        $inquiriesApproved = count(InquiryJobs::where('user_id', $userId)->where('job_status_id', 1)->where('is_form', 'Yes')->get());
        $inquiriesPending = count(InquiryJobs::where('user_id', $userId)->where('job_status_id', 3)->where('is_form', 'Yes')->get());
        $inquiriesDisapproved = count(InquiryJobs::where('user_id', $userId)->whereIn('job_status_id', array(2,4))->get());

        return view('workers/inqurier/my-work', compact('inquiriesApproved', 'inquiriesPending', 'inquiriesDisapproved'));
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

        return view('workers/inqurier/profile', compact('userData','listCountries'))->with('i');
    }

    public function addInquiryData(Request $request)
    {
        return $this->service->addInquiryData($request);
    }

    public function addReportData(Request $request)
    {
        return $this->service->addReportData($request);
    }

    public function updateProfile(Request $request)
    {
        $id = Auth::user()->id;
        return $this->service->updateProfile($request, $id);
    }

}
