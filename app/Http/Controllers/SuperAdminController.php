<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Redirect;
use App\Services\SuperAdminService;

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

    public function showProductCategory()
    {
        $productCategory = ProductCategory::all();
        return view('/superadmin/listProductCategory', compact('productCategory'))->with('i');
    }

    public function showDetailProductCategory($id)
    {
        $productCategory = ProductCategory::find($id);
        return view('/superadmin/editProductCategory', compact('productCategory'));
    }

    public function deleteProductCategory($id){
        try{
            $productCategory = ProductCategory::where('id',$id)->delete();
        }catch(\Throwable $th){
            return response()->json(['success' => false, 'message' => "Product category data failed to delete",]);
        }
        
        return response()->json(['success' => true, 'message' => "Product category data deleted successfully",]);
    }

    public function addProductCategory(Request $request)
    {
        $request->validate([
            'category_name' => 'required'
        ]);

        return $this->service->addProductCategory($request);
    }

    public function editProductCategory(Request $request)
    {
        $request->validate([
            'category_name' => 'required'
        ]);

        return $this->service->editProductCategory($request);
    }

    public function registerAdmin(Request $request)
    {
        $request->validate([
            'email'     => 'required|email',
            'password'  => 'required',
        ]);
    }
}
