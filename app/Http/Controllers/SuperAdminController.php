<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Services\SuperAdminService;

use App\Models\ProductCategory;
use App\Models\User;
use App\Models\UsersRole;
use App\Models\UsersStatus;
use App\Models\Countries;

class SuperAdminController extends Controller
{
    private $service;

    public function __construct(SuperAdminService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $totalProductCategory = count(ProductCategory::all()); 
        $totalUsers = count(User::whereNotIn('id', array(1))->get());
        $totalAdmins = count(User::where('role_id', 2)->get());
        $totalWorkers = count(User::whereNotIn('id', array(1,2))->get());

        return view('/superadmin/index', compact('totalProductCategory','totalUsers','totalAdmins','totalWorkers'));
    }

    //product category function
    public function showProductCategory()
    {
        $productCategory = ProductCategory::all();

        return view('/superadmin/product-category/listProductCategory', compact('productCategory'))->with('i');
    }

    public function showDetailProductCategory($id)
    {
        $productCategory = ProductCategory::find($id);
        
        if(!$productCategory){
            return redirect()->route('product-category');
        }

        return view('/superadmin/product-category/updateProductCategory', compact('productCategory'));
    }

    public function deleteProductCategory($id)
    {
        return $this->service->deleteProductCategory($id);
    }

    public function addProductCategory(Request $request)
    {
        $request->validate([
            'category_name' => 'required'
        ]);

        return $this->service->addProductCategory($request);
    }

    public function updateProductCategory(Request $request, $id)
    {
        $request->validate([
            'category_name' => 'required'
        ]);

        return $this->service->updateProductCategory($request, $id);
    }

    //all users function
    public function showUsersList()
    {
        $user = User::whereNotIn('id', [1])->with('ProductCategory', 'UsersStatus', 'UsersRole', 'Country')->get();
        $users = json_decode($user, true);
        
        return view('/superadmin/users/index', compact('users'))->with('i');
    }

    public function showUsersDetails($id)
    {
        $users = User::find($id);

        if(!$users){
            return redirect()->route('users.index');
        }

        $usersRole = UsersRole::all();
        $usersStatus = UsersStatus::all();
        $listCountries = Countries::all();
        $productCategory = ProductCategory::all();

        return view('/superadmin/users/updateUsers', compact('users', 'usersRole', 'usersStatus','listCountries', 'productCategory'))->with('i');
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

    //admin function
    public function showFormAddAdmin()
    {
        $listCountries = Countries::all();
        $productCategory = ProductCategory::all();

        return view('/superadmin/admin/addAdmin', compact('listCountries', 'productCategory'))->with('i');
    }

    public function showAdminList()
    {
        $admin = User::where('role_id', 2)->with('ProductCategory', 'UsersStatus','Country')->get();
        $admins = json_decode($admin, true);
        
        return view('/superadmin/admin/index', compact('admins'))->with('i');
    }

    public function showAdminDetails($id)
    {
        $admin = User::find($id);

        if(!$admin){
            return redirect()->route('admins.index');
        }

        $usersRole = UsersRole::all();
        $usersStatus = UsersStatus::all();
        $listCountries = Countries::all();
        $productCategory = ProductCategory::all();

        return view('/superadmin/admin/updateAdmin', compact('admin', 'usersRole', 'usersStatus','listCountries', 'productCategory'))->with('i');
    }

    public function addUserAdmin(Request $request)
    {
        $request->validate([
            'role_id'   => 'required',
            'status_id' => 'required',
            'product_category_id' => 'required',
            'country_id'      => 'required',
            'name'      => 'required',
            'email'     => 'required|email',
            'password'  => 'required',
        ]);

        return $this->service->addUserAdmin($request);
    }

    public function updateUserAdmin(Request $request, $id)
    {
        $request->validate([
            'role_id'   => 'required',
            'status_id' => 'required',
            'country_id'      => 'required',
            'product_category_id' => 'required',
            'name'      => 'required',
            'email'     => 'required|email',
        ]);

        return $this->service->updateUserAdmin($request, $id);
    }

    public function deleteUserAdmin($id)
    {
        return $this->service->deleteUserAdmin($id);
    }

    //workers function
    public function showWorkersList($workers)
    {
        $usersRole = UsersRole::where('role', $workers)->get();

        if(count($usersRole) == 0){
            return redirect()->route('admins.index');
        }
        
        foreach($usersRole as $i => $roles){
            $usersRole[$i] = $roles;
        }

        $workersList = User::where('role_id', $roles->id)->with('ProductCategory', 'UsersStatus', 'UsersRole', 'Country')->get();
        $workersLists = json_decode($workersList, true);

        return view('/superadmin/workers/index', compact('workersLists', 'workers'))->with('i');
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

        return view('/superadmin/workers/updateWorkers', compact('worker', 'workers', 'usersRole', 'usersStatus','listCountries', 'productCategory'))->with('i');
    }

    public function showFormAddWorkers()
    {
        $listCountries = Countries::all();
        $productCategory = ProductCategory::all();
        $usersRole = UsersRole::whereNotIn('id', array(1,2))->get();

        return view('/superadmin/workers/addWorkers', compact('listCountries', 'productCategory','usersRole'))->with('i');
    }

    public function addUserWorkers(Request $request)
    {
        $request->validate([
            'role_id'   => 'required',
            'status_id' => 'required',
            'product_category_id' => 'required',
            'country_id'      => 'required',
            'name'      => 'required',
            'email'     => 'required|email',
            'password'  => 'required',
        ]);

        return $this->service->addUserWorkers($request);
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
}
