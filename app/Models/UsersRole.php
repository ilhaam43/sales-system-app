<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersRole extends Model
{
    use HasFactory;

    protected $table = 'users_role';

    protected $guarded = [
        'id'
    ];

    public function users(){
        return $this->hasMany(User::class, 'id', 'role_id');
    }

    public function workerNotifications()
    {
        return $this->hasMany(WorkerNotifications::class, 'id', 'role_id');
    }
}
