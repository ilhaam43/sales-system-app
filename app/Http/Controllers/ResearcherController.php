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
}
