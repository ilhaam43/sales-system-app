<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Services\ResearcherService;

use App\Models\User;
use App\Models\Countries;
use App\Models\ResearchJobs;
use App\Models\ProductCategory;
use App\Models\Settings;
use App\Models\WorkerNotifications;

class ResearcherController extends Controller
{
    private $service;

    public function __construct(ResearcherService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $auth = Auth::user();
        $howWeWork = Settings::where('id', 1)->first();
        
        $updateWeWork = WorkerNotifications::where('user_id', $auth->id)->update(['how_we_work' => 0]);

        return view('workers/researcher/index', compact('howWeWork'));
    }

    public function showResearches()
    {
        $user = Auth::user();
        $listCountries = Countries::all();

        $productCategory = User::where('id', $user->id)->with('ProductCategory')->get();
        $productCategories = json_decode($productCategory, true);

        $listResearchJobs = ResearchJobs::where('user_id', $user->id)->with('Country', 'JobsStatus')->get();
        $researchJobsLists = json_decode($listResearchJobs, true);
        
        return view('workers/researcher/researches', compact('researchJobsLists','listCountries','productCategories', 'user'))->with('i');
    }

    public function showDetailResearches($id)
    {   
        $listCountries = Countries::all();
        $listResearchJobs = ResearchJobs::where('id', $id)->with('Country', 'JobsStatus')->get();
        $researchJobsLists = json_decode($listResearchJobs, true);

        foreach($researchJobsLists as $researchList){
            $researchJobsLists = $researchList;
        }

        return view('workers/researcher/updateResearches', compact('researchJobsLists', 'listCountries'))->with('i');
    }

    public function showFAQ()
    {
        $auth = Auth::user();
        $researchFAQ = Settings::where('id', 4)->first();

        $updateFAQ = WorkerNotifications::where('user_id', $auth->id)->update(['faq' => 0]);

        return view('workers/researcher/faq', compact('researchFAQ'));
    }

    public function showNotice()
    {
        $auth = Auth::user();
        $researchNotice = Settings::where('id', 7)->first();

        $updateNotice = WorkerNotifications::where('user_id', $auth->id)->update(['notice' => 0]);

        return view('workers/researcher/notice', compact('researchNotice'));
    }

    public function showPayments()
    {
        $userId = Auth::user()->id;
        $user = User::where('id', $userId)->first();

        $researchQuantity = count(ResearchJobs::where('user_id', $userId)->get());
        $researchPaid = $user->quantity_research_paid;
        $amountPaid = $user->amount_paid;

        return view('workers/researcher/payments', compact('researchQuantity', 'researchPaid', 'amountPaid'));
    }

    public function showMyWork()
    {
        $userId = Auth::user()->id;
        
        $companiesApproved = count(ResearchJobs::where('user_id', $userId)->where('job_status_id', 1)->get());
        $companiesPending = count(ResearchJobs::where('user_id', $userId)->where('job_status_id', 3)->get());
        $companiesDisapproved = count(ResearchJobs::where('user_id', $userId)->whereIn('job_status_id', array(2,4))->get());

        return view('workers/researcher/my-work', compact('companiesApproved', 'companiesPending', 'companiesDisapproved'));
    }

    public function showCountryRecords()
    {
        $auth = Auth::user();
        $researchJobsList = ResearchJobs::where('user_id', $auth->id)->where('product_category_id', $auth->product_category_id)->with('Country')->distinct()->get('country_id');
        $researchJobsLists = json_decode($researchJobsList, true);

        $countriesRecords = [];

        foreach($researchJobsLists as $researchesList){
            $searchResearch = ResearchJobs::whereIn('country_id', array($researchesList['country']['id']))->count();
        
                if($searchResearch > 0){
                    array_push($countriesRecords, [
                        'country_id' => $researchesList['country']['id'],
                        'country_name' => $researchesList['country']['country_name'],
                        'count' => $searchResearch,
                    ]);
                }
            }

        return view('workers/researcher/country-records', compact('countriesRecords'))->with('i');
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

        return view('workers/researcher/profile', compact('userData','listCountries'))->with('i');
    }

    public function addCompanyData(Request $request)
    {
        $request->validate([
            'user_id'               => 'required',
            'job_status_id'         => 'required',
            'product_category_id'   => 'required',
            'country_id'            => 'required',
            'company_name'          => 'required',
            'company_website'       => 'required',
            'company_email'         => 'required',
            'company_phone'         => 'required',
            'company_product_url'   => 'required',
            'is_form'               => 'required',
            'is_blacklist'          => 'required',
        ]);

        return $this->service->addCompanyData($request);
    }

    public function checkCompanyData(Request $request)
    {
        $request->validate([
            'input_data'            => 'required',
            'type_search'           => 'required',
        ]);

        return $this->service->checkCompanyData($request);
    }

    public function updateProfile(Request $request)
    {
        $id = Auth::user()->id;
        return $this->service->updateProfile($request, $id);
    }

    public function updateResearches(Request $request, $id)
    {
        $request->validate([
            'country_id'            => 'required',
            'company_name'          => 'required',
            'company_website'       => 'required',
            'company_email'         => 'required',
            'company_phone'         => 'required',
            'company_product_url'   => 'required',
        ]);

        return $this->service->updateResearches($request, $id);
    }
}
