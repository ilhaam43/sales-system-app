<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Services\SuperAdminService;

use App\Models\ProductCategory;
use App\Models\Photos;

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

    public function registerAdmin(Request $request)
    {
        $request->validate([
            'email'     => 'required|email',
            'password'  => 'required',
        ]);
    }
}
