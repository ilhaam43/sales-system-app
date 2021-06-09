<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResearcherController extends Controller
{
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
        return view();
    }
}
