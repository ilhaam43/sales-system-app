<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Services\ResearcherService;

use App\Models\User;
use App\Models\Countries;
use App\Models\ResearchJobs;

class ResearcherController extends Controller
{
    private $service;

    public function __construct(ResearcherService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('workers/researcher/index');
    }

    public function showResearches()
    {
        $userId = Auth::user()->id;
        $listResearchJobs = ResearchJobs::where('user_id', $userId)->with('Country', 'JobsStatus')->get();
        $researchJobsLists = json_decode($listResearchJobs, true);
        
        return view('workers/researcher/researches', compact('researchJobsLists'))->with('i');
    }

    public function showFAQ()
    {
        return view('workers/researcher/faq');
    }

    public function showNotice()
    {
        return view('workers/researcher/notice');
    }

    public function showPayments()
    {
        return view('workers/researcher/payments');
    }

    public function showMyWork()
    {
        return view('workers/researcher/my-work');
    }

    public function showCountryRecords()
    {
        $researchJobsList = ResearchJobs::with('Country')->distinct()->get('country_id');
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

    }

    public function checkCompanyData(Request $request)
    {

    }

    public function updateProfile(Request $request)
    {
        $id = Auth::user()->id;
        return $this->service->updateProfile($request, $id);
    }
}
