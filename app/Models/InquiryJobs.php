<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InquiryJobs extends Model
{
    use HasFactory;

    protected $table = 'inquiry_jobs';

    protected $guarded = [
        'id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function researchJobs(){
        return $this->belongsTo(ResearchJobs::class);
    }

    public function auditorInquiryJobs(){
        return $this->hasOne(AuditorInquiryJobs::class);
    }

    public function jobsStatus(){
        return $this->belongsTo(JobsStatus::class, 'job_status_id', 'id');
    }

}
