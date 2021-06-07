<?php
namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\ProductCategory;
use App\Models\Photos;
use App\Models\User;

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

    public function deleteProductCategory($id)
    {
        try{
            $productCategory = ProductCategory::where('id',$id)->delete();
        }catch(\Throwable $th){
            return response()->json(['success' => false, 'message' => "Product category data failed to delete",]);
        }
        
        return response()->json(['success' => true, 'message' => "Product category data deleted successfully",]);
    }

    public function addPhoto($request)
    {
        $name = $request->file('photo_image')->getClientOriginalName();
        
        try{
        $uploadPhoto = $request->photo_image->move(public_path('superadmins/img/photos'), $name);

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

    public function deletePhoto($id)
    {
        try{
            $productCategory = Photos::where('id',$id)->delete();
        }catch(\Throwable $th){
            return response()->json(['success' => false, 'message' => "Photo data failed to delete",]);
        }
        
        return response()->json(['success' => true, 'message' => "Photo data deleted successfully",]);
    }

    public function addUserAdmin($request)
    {
        if($request['password'] !== $request['confirm_password'])
        {
            return redirect()->route('admins.store.index')->with('error', 'Admin failed to add cause password and confirm password not same');
        }

        try{
            $addUserAdmin = new User([
                'role_id'   => $request['role_id'],
                'product_category_id' =>  $request['product_category_id'],
                'name'      => $request['name'],
                'email'     => $request['email'],
                'password'  => Hash::make($request['password']),
                'country'   => $request['country'],
                'status'    => $request['status']
            ]);

            $addUserAdmin->save();
        }catch(\Throwable $th){
            return redirect()->route('admins.store.index')->with('error', 'Admin failed to add because email already registered in this system');
        }

        return redirect()->route('admins.store.index')->with('success', 'Admin added successfully');
    }

}
?>