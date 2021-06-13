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

class InqurierController extends Controller
{
    private $service;

    public function __construct(InqurierService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('workers/inqurier/index');
    }

    public function showInquiries()
    {
        $user = Auth::user();

        $listInquiriesJobs = InquiryJobs::where('user_id', $user->id)->where('is_form', 'Yes')->get();

        return view('workers/inqurier/inquiries', compact('listInquiriesJobs'))->with('i');
    }

    public function showCompanies()
    {
        $user = Auth::user();

        $listCompanies = ResearchJobs::where('job_status_id', 1)->with('Country')->inRandomOrder()->limit(10)->get();
        $companiesList = json_decode($listCompanies, true);

        return view('workers/inqurier/companies', compact('companiesList'))->with('i');
    }

    public function showFAQ()
    {
        return view('workers/inqurier/faq');
    }

    public function showNotice()
    {
        return view('workers/inqurier/notice');
    }

    public function showPayments()
    {
        $userId = Auth::user()->id;
        $user = User::where('id', $userId)->first();

        $researchQuantity = count(ResearchJobs::where('user_id', $userId)->get());
        $researchPaid = $user->quantity_research_paid;
        $amountPaid = $user->amount_paid;

        return view('workers/inqurier/payments', compact('researchQuantity', 'researchPaid', 'amountPaid'));
    }

    public function showMyWork()
    {
        $userId = Auth::user()->id;
        
        $companiesApproved = count(ResearchJobs::where('user_id', $userId)->where('job_status_id', 1)->get());
        $companiesPending = count(ResearchJobs::where('user_id', $userId)->where('job_status_id', 3)->get());
        $companiesDisapproved = count(ResearchJobs::where('user_id', $userId)->whereIn('job_status_id', array(2,4))->get());

        return view('workers/inqurier/my-work', compact('companiesApproved', 'companiesPending', 'companiesDisapproved'));
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
