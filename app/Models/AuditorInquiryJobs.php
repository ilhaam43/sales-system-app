<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditorInquiryJobs extends Model
{
    use HasFactory;

    protected $table = 'auditor_inquiry_jobs';

    protected $guarded = [
        'id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function inquiryJobs(){
        return $this->hasOne(inquiryJobs::class);
    }

    public function productCategory(){
        return $this->belongsTo(ProductCategory::class);
    }
}
