<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'users';

    protected $guarded = [
        'id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function usersRole(){
        return $this->belongsTo(UsersRole::class, 'role_id', 'id');
    }

    public function usersStatus(){
        return $this->belongsTo(UsersStatus::class, 'status_id', 'id');
    }

    public function researchJobs(){
        return $this->hasMany(ResearchJobs::class, 'user_id', 'id');
    }

    public function inquiryJobs(){
        return $this->hasMany(InquiryJobs::class, 'user_id', 'id');
    }

    public function productCategory(){
        return $this->belongsTo(ProductCategory::class);
    }

    public function AuditorInquityJobs(){
        return $this->hasMany(AuditorInquiryJobs::class, 'user_id', 'id');
    }

    public function AuditorResearchJobs(){
        return $this->hasMany(AuditorResearchJobs::class, 'user_id', 'id');
    }

    public function country(){
        return $this->belongsTo(Countries::class, 'country_id', 'id');
    }

    public function workerNotifications(){
        return $this->hasMany(WorkerNotifications::class, 'user_id', 'id');
    }
}
