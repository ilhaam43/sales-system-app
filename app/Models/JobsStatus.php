<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobsStatus extends Model
{
    use HasFactory;

    protected $table = 'jobs_status';

    protected $guarded = [
        'id'
    ];
    
    public function researchJobs(){
        return $this->hasMany(ResearchJobs::class, 'id', 'job_status_id');
    }

    public function inquiryJobs(){
        return $this->hasMany(InquiryJobs::class, 'id', 'job_status_id');
    }
}
