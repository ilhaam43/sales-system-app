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

    public function addProductCategory(Request $request)
    {
        $request->validate([
            'category_name' => 'required'
        ]);

        return $this->service->addProductCategory($request);
    }

    public function showAddProductCategoryForm()
    {
        return view('/superadmin/addProductCategory');
    }

    public function registerAdmin(Request $request)
    {
        $request->validate([
            'email'     => 'required|email',
            'password'  => 'required',
        ]);
    }
}
