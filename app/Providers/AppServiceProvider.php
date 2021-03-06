<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\ServiceProvider;
use App\Services\AdminService;

class AppServiceProvider extends ServiceProvider
{

    private $service;

    public function __construct()
    {
        $this->service = new AdminService;
    }
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {   
        view()->composer('*', function ($view) 
        {   if(Auth::check()){
                $auth = Auth::user();

                if($auth->role_id == 2){
                    $globalPendingResearch = $this->service->globalPendingResearch($auth);
                    $globalPendingInquiry = $this->service->globalPendingInquiry($auth);
                    
                    view()->share('globalPendingResearch', $globalPendingResearch);
                    view()->share('globalPendingInquiry', $globalPendingInquiry);
                }

                if($auth->role_id !== 1 && $auth->role_id !== 2)
                {
                    $globalWorkerNotifications = $this->service->globalWorkerNotifications($auth);

                    view()->share('globalWorkerNotifications', $globalWorkerNotifications);
                }
            }
        });
    }
}
