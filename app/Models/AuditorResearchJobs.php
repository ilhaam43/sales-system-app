<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditorResearchJobs extends Model
{
    use HasFactory;

    protected $table = 'auditor_research_jobs';

    protected $guarded = [
        'id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function researchJobs(){
        return $this->hasOne(ResearchJobs::class);
    }

    public function productCategory(){
        return $this->belongsTo(ProductCategory::class);
    }
}
