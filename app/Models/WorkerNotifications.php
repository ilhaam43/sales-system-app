<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkerNotifications extends Model
{
    use HasFactory;

    protected $table = 'worker_notification';

    public function user(){
        return $this->belongsTo(User::class);
    }
}
