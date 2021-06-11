<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Countries extends Model
{
    use HasFactory;

    protected $table = 'country';

    protected $guarded = [
        'id'
    ];

    public function users(){
        return $this->hasMany(User::class, 'id', 'country_id');
    }

    public function researchJobs(){
        return $this->hasMany(researchJobs::class, 'id', 'country_id');
    }
}
