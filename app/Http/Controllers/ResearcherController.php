<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Services\ResearcherService;

use App\Models\User;
use App\Models\Countries;

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
        return view('workers/researcher/researches');
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

    public function updateProfile(Request $request)
    {
        $id = Auth::user()->id;
        return $this->service->updateProfile($request, $id);
    }
}
