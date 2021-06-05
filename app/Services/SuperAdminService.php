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
            return redirect()->route('superadmin.index')->with('error', 'Product category added failed');
        }
        return redirect()->route('superadmin.index')->with('success', 'Product category added successfully');
    }
}

?>