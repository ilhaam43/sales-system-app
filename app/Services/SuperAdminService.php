<?php
namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\ProductCategory;
use App\Models\User;
use App\Models\UsersRole;

class SuperAdminService
{
    //product category function logic
    public function addProductCategory($request)
    {
        try {
            $addData = ProductCategory::create($request->all());
        } catch(\Throwable $th) {
            return back()->withError('Product categories failed to add because product categories cannot be duplicated');
        }
        
        return redirect()->route('product-category')->with('success', 'Product category added successfully');
    }

    public function updateProductCategory($request, $id)
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

    //all users logic
    public function deleteUsers($id)
    {
        try{
            $deleteUsers = User::where('id',$id)->delete();
        }catch(\Throwable $th){
            return response()->json(['success' => false, 'message' => "User data failed to delete",]);
        }
        
        return response()->json(['success' => true, 'message' => "User data deleted successfully",]);
    }

    public function updateUsers($request, $id)
    {
        $check = empty($request['password']);

        try{
            if($check == 0){
                if($request['password'] !== $request['confirm_password']){
                    return redirect()->route('users.show', $id)->with('error', 'User failed to update cause password and confirm password not same');
                }
                $request['password'] = Hash::make($request['password']);

                $updateUsers = User::find($id)->update($request->all());
            }elseif($check == 1){
                $updateUsers = User::find($id)->update($request->except(['password', 'confirm_password']));
            }
        }catch(\Throwable $th){
            return redirect()->route('users.show', $id)->with('error', 'User data failed to update because email that want to update is already registered in this system');
        }

        return redirect()->route('users.index')->with('success', 'User data updated successfully');
    }

    //admin function logic
    public function addUserAdmin($request)
    {
        if($request['password'] !== $request['confirm_password'])
        {
            return redirect()->route('admins.store.index')->with('error', 'Admin failed to add cause password and confirm password not same');
        }

        try{
            $addUserAdmin = new User([
                'role_id'   => $request['role_id'],
                'status_id' => $request['status_id'],
                'product_category_id' =>  $request['product_category_id'],
                'name'      => $request['name'],
                'email'     => $request['email'],
                'password'  => Hash::make($request['password']),
                'country_id'   => $request['country_id'],
            ]);

            $addUserAdmin->save();
        }catch(\Throwable $th){
            return redirect()->route('admins.store.index')->with('error', 'Admin failed to add because email already registered in this system');
        }

        return redirect()->route('admins.index')->with('success', 'Admin added successfully');
    }

    public function updateUserAdmin($request, $id)
    {
        $check = empty($request['password']);

        try{
            if($check == 0){
                if($request['password'] !== $request['confirm_password']){
                    return redirect()->route('admins.show', $id)->with('error', 'Admin failed to update cause password and confirm password not same');
                }
                $request['password'] = Hash::make($request['password']);

                $updateUserAdmin = User::find($id)->update($request->all());
            }elseif($check == 1){
                $updateUserAdmin = User::find($id)->update($request->except(['password', 'confirm_password']));
            }
        }catch(\Throwable $th){
            return redirect()->route('admins.show', $id)->with('error', 'Admin data failed to update because email that want to update is already registered in this system');
        }

        return redirect()->route('admins.index')->with('success', 'Admin data updated successfully');
    }

    public function deleteUserAdmin($id)
    {
        try{
            $deleteAdmin = User::where('id',$id)->delete();
        }catch(\Throwable $th){
            return response()->json(['success' => false, 'message' => "Admin data failed to delete",]);
        }
        
        return response()->json(['success' => true, 'message' => "Admin data deleted successfully",]);
    }

    //workers function logic
    public function addUserWorkers($request)
    {
        if($request['password'] !== $request['confirm_password'])
        {
            return redirect()->route('workers.store.index')->with('error', 'Workers failed to add cause password and confirm password not same');
        }

        $usersRole = UsersRole::find($request['role_id']);

        try{
            $addUserWorkers = new User([
                'role_id'   => $request['role_id'],
                'status_id' => $request['status_id'],
                'product_category_id' =>  $request['product_category_id'],
                'name'      => $request['name'],
                'email'     => $request['email'],
                'password'  => Hash::make($request['password']),
                'country_id'   => $request['country_id'],
            ]);

            $addUserWorkers->save();
        }catch(\Throwable $th){
            return redirect()->route('workers.store.index',$usersRole->role)->with('error', $usersRole->role .' failed to add because email already registered in this system');
        }
        

        return redirect()->route('workers.index',$usersRole->role)->with('success', $usersRole->role .' added successfully');
    }

    public function updateUserWorkers($request, $workers, $id)
    {
        $check = empty($request['password']);

        try{
            if($check == 0){
                if($request['password'] !== $request['confirm_password']){
                    return redirect()->route('workers.show', ['workers' => $workers, 'id' => $id])->with('error', $workers . ' failed to update cause password and confirm password not same');
                }
                $request['password'] = Hash::make($request['password']);

                $updateUserWorkers = User::find($id)->update($request->all());
            }elseif($check == 1){
                $updateUserWorkers = User::find($id)->update($request->except(['password', 'confirm_password']));
            }
        }catch(\Throwable $th){
            return redirect()->route('workers.show', ['workers' => $workers, 'id' => $id])->with('error', $workers .' data failed to update because email that want to update is already registered in this system');
        }

        return redirect()->route('workers.index', $workers)->with('success', $workers . ' data updated successfully');
    }

    public function deleteUserWorkers($workers, $id)
    {
        try{
            $deleteWorkers = User::where('id',$id)->delete();
        }catch(\Throwable $th){
            return response()->json(['success' => false, 'message' => "{$workers} data failed to delete",]);
        }
        
        return response()->json(['success' => true, 'message' => "{$workers} data deleted successfully",]);
    }

}
?>