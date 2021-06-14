<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Services\AdminService;

use App\Models\ProductCategory;
use App\Models\User;
use App\Models\UsersRole;
use App\Models\UsersStatus;
use App\Models\Photos;
use App\Models\Countries;
use App\Models\Settings;

class AdminController extends Controller
{
    private $service;

    public function __construct(AdminService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('/admin/index');
    }

    //photo function
    public function showPhotoList()
    {
        $photos = Photos::all();
        return view('/admin/photos/listPhotos', compact('photos'))->with('i');
    }

    public function addPhoto(Request $request)
    {
        $request->validate([
            'photo_name' => 'required',
            'photo_image' => 'required|mimes:jpeg,bmp,png'
        ]);

        return $this->service->addPhoto($request);
    }

    public function deletePhoto($id)
    {
        return $this->service->deletePhoto($id);
    }

    //all users function
    public function showUsersList()
    {
        $auth = Auth::user();
        $user = User::whereNotIn('id', [1,2])->where('product_category_id', $auth->product_category_id)->with('ProductCategory', 'UsersStatus', 'UsersRole', 'Country')->get();
        $users = json_decode($user, true);
        
        return view('/admin/users/index', compact('users'))->with('i');
    }

    public function showUsersDetails($id)
    {
        $users = User::find($id);

        if(!$users){
            return redirect()->route('admin.users.index');
        }

        $usersRole = UsersRole::all();
        $usersStatus = UsersStatus::all();
        $listCountries = Countries::all();
        $productCategory = ProductCategory::all();

        return view('/admin/users/updateUsers', compact('users', 'usersRole', 'usersStatus','listCountries', 'productCategory'))->with('i');
    }

    public function updateUsers(Request $request, $id)
    {
        $request->validate([
            'role_id'   => 'required',
            'status_id' => 'required',
            'country_id'      => 'required',
            'product_category_id' => 'required',
            'name'      => 'required',
            'email'     => 'required|email',
        ]);

        return $this->service->updateUsers($request, $id);
    }

    public function deleteUsers($id)
    {
        return $this->service->deleteUsers($id);
    }

    //workers function
    public function showWorkersList($workers)
    {
        $usersRole = UsersRole::where('role', $workers)->get();

        if(count($usersRole) == 0){
            return redirect()->route('admin.workers.index');
        }
        
        foreach($usersRole as $i => $roles){
            $usersRole[$i] = $roles;
        }

        $auth = Auth::user();

        $workersList = User::where('role_id', $roles->id)->where('product_category_id', $auth->product_category_id)->with('ProductCategory', 'UsersStatus', 'UsersRole', 'Country')->get();
        $workersLists = json_decode($workersList, true);

        return view('/admin/workers/index', compact('workersLists', 'workers'))->with('i');
    }

    public function showWorkersDetails($workers, $id)
    {
        $worker = User::find($id);

        if(!$worker){
            return redirect()->route('workers.index',$workers);
        }

        $usersRole = UsersRole::all();
        $usersStatus = UsersStatus::all();
        $listCountries = Countries::all();
        $productCategory = ProductCategory::all();

        return view('/admin/workers/updateWorkers', compact('worker', 'workers', 'usersRole', 'usersStatus','listCountries', 'productCategory'))->with('i');
    }

    public function updateUserWorkers(Request $request, $workers, $id)
    {
        $request->validate([
            'role_id'   => 'required',
            'status_id' => 'required',
            'country_id'      => 'required',
            'product_category_id' => 'required',
            'name'      => 'required',
            'email'     => 'required|email',
        ]);

        return $this->service->updateUserWorkers($request, $workers, $id);
    }

    public function deleteUserWorkers($workers, $id)
    {
        return $this->service->deleteUserWorkers($workers, $id);
    }

    //general setting function
    public function showFormAddGeneralSetting()
    {
        return view('/admin/setting/addGeneralSetting');
    }

    public function showGeneralSetting()
    {
        $settings = Settings::all();

        return view('/admin/setting/listGeneralSetting', compact('settings'))->with('i');
    }

    public function showDetailGeneralSetting($id)
    {
        $setting = Settings::find($id);

        return view('/admin/setting/updateGeneralSetting', compact('setting'));
    }

    public function addGeneralSetting(Request $request)
    {
        $request->validate([
            'setting_name' => 'required',
            'setting_description' => 'required'
        ]);

        return $this->service->addGeneralSetting($request);
    }

    public function updateGeneralSetting(Request $request, $id)
    {
        $request->validate([
            'setting_name' => 'required',
            'setting_description' => 'required'
        ]);

        return $this->service->updateGeneralSetting($request, $id);
    }

    public function deleteGeneralSetting($id)
    {
        return $this->service->deleteGeneralSetting($id);
    }
}
