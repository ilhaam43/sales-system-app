<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSources extends Model
{
    use HasFactory;

    protected $table = 'product_sources';

    protected $guarded = [
        'id'
    ];

    public function researchJobs(){
        return $this->hasMany(ResearchJobs::class, 'product_sources_id', 'id');
    }
}
