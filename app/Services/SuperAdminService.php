<?php
namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\ProductCategory;
use App\Models\Photos;

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

    public function editProductCategory($request, $id)
    {
        try{
            $updateCategory = ProductCategory::find($id)->update($request->all());
        }catch(\Throwable $th) {
            return back()->withError('Product categories failed to update because product categories cannot be duplicated');
        }

        return redirect()->route('product-category')->with('success', 'Product category updated successfully');
    }

    public function addPhoto($request)
    {
        $name = $request->file('photo_image')->getClientOriginalName();
        
        try{
        $uploadPhoto = $request->photo_image->move(public_path('superadmin/img/photos'), $name);

        $addPhotos = new Photos([
            "photo_name" => $request['photo_name'],
            "photo_url" =>  'superadmins/img/photos/' . $name
        ]);

        $addPhotos->save();
        }catch(\Throwable $th){
            return back()->withError('Photo failed to add');
        }

        return redirect()->route('photos')->with('success', 'Photo added successfully');
    }

}
?>