<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Services\SuperAdminService;

use App\Models\ProductCategory;
use App\Models\User;
use App\Models\Photos;
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
        return view('/superadmin/index');
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

        return view('/superadmin/product-category/editProductCategory', compact('productCategory'));
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

        return $this->service->editProductCategory($request, $id);
    }

    //photo function
    public function showPhotoList()
    {
        $photos = Photos::all();
        return view('/superadmin/photos/listPhotos', compact('photos'))->with('i');
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

    //admin function
    public function showFormAddAdmin()
    {
        $listCountries = Countries::pluck('country_name');
        $productCategory = ProductCategory::all();

        return view('/superadmin/admin/addAdmin', compact('listCountries', 'productCategory'))->with('i');
    }

    public function showAdminList()
    {
        $admin = User::where('role_id', 2)->get();

        return view('/superadmin/admin/index', compact('admin'))->with('i');
    }

    public function addUserAdmin(Request $request)
    {
        $request->validate([
            'role_id'   => 'required',
            'product_category_id' => 'required',
            'name'      => 'required',
            'email'     => 'required|email',
            'password'  => 'required',
            'country'      => 'required',
            'status'    => 'required'
        ]);

        return $this->service->addUserAdmin($request);
    }

    public function deleteUserAdmin($id)
    {
        return $this->service->deleteUserAdmin($id);
    }
}
