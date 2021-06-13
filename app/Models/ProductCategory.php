<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    protected $table = 'product_category';

    protected $guarded = [
        'id'
    ];

    public function user(){
        return $this->hasMany(User::class);
    }

    public function researchJobs(){
        return $this->hasMany(ResearchJobs::class, 'product_category_id', 'id');
    }

    public function auditorResearchJobs(){
        return $this->hasMany(AuditorResearchJobs::class, 'product_category_id', 'id');
    }

    public function auditorInquiryJobs(){
        return $this->hasMany(AuditorInquiryJobs::class, 'product_category_id', 'id');
    }
}
