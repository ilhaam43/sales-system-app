<?php
namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\ProductCategory;

class SuperAdminService
{
    public function addProductCategory($request)
    {
        try {
            $addData = ProductCategory::create($request->all());
        } catch(\Throwable $th) {
            return back()->withError('Product categories failed to add because product categories cannot be duplicated');
        }
        
        return redirect()->route('product-category')->with('success', 'Product category added successfully');
    }

    public function editProductCategory($request)
    {

    }
}

?>