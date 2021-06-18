<?php

namespace App\Exports;

use App\Models\ResearchJobs;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ApprovedResearches implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct($researcherList, $i)
    {
        $this->researcherList = $researcherList;
        $this->i = $i;
    }

    public function view(): View
    {   
        $data = $this->researcherList;
        $i = $this->i;

        return view('admin.researches.exports.researchApprovedList', [
            'data' => $data,
            'i' => $i
        ]);        
    }
}
