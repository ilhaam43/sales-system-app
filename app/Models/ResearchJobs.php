<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResearchJobs extends Model
{
    use HasFactory;

    protected $table = 'research_jobs';

    protected $guarded = [
        'id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function productCategory(){
        return $this->belongsTo(ProductCategory::class);
    }

    public function productSources(){
        return $this->belongsTo(ProductSources::class);
    }

    public function inquiryJobs(){
        return $this->hasMany(InquiryJobs::class, 'research_jobs_id', 'id');
    }

    public function auditorResearchJobs(){
        return $this->hasOne(AuditorResearchJobs::class, 'researcher_job_id', 'id');
    }

    public function country(){
        return $this->belongsTo(Countries::class, 'country_id', 'id');
    }

    public function jobsStatus(){
        return $this->belongsTo(JobsStatus::class, 'job_status_id', 'id');
    }
}
