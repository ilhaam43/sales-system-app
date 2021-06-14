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
use App\Models\UsersRole;
use App\Models\Settings;

class AdminService
{

    //photo function logic
    public function addPhoto($request)
    {
        $name = $request->file('photo_image')->getClientOriginalName();
        
        try{
        $uploadPhoto = $request->photo_image->move(public_path('admins/img/photos'), $name);

        $addPhotos = new Photos([
            "photo_name" => $request['photo_name'],
            "photo_url" =>  'admins/img/photos/' . $name
        ]);

        $addPhotos->save();
        }catch(\Throwable $th){
            return back()->withError('Photo failed to add');
        }

        return redirect()->route('admin.photos')->with('success', 'Photo added successfully');
    }

    public function deletePhoto($id)
    {
        try{
            $photo = Photos::find($id);
            $deletePhotoFile = unlink($photo->photo_url);
            $deletePhotoData = Photos::where('id',$id)->delete();
        }catch(\Throwable $th){
            return response()->json(['success' => false, 'message' => "Photo data failed to delete",]);
        }
        
        return response()->json(['success' => true, 'message' => "Photo data deleted successfully",]);
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
            return redirect()->route('admin.users.show', $id)->with('error', 'User data failed to update because email that want to update is already registered in this system');
        }

        return redirect()->route('admin.users.index')->with('success', 'User data updated successfully');
    }

    //workers function logic

    public function updateUserWorkers($request, $workers, $id)
    {
        $check = empty($request['password']);

        try{
            if($check == 0){
                if($request['password'] !== $request['confirm_password']){
                    return redirect()->route('admin.workers.show', ['workers' => $workers, 'id' => $id])->with('error', $workers . ' failed to update cause password and confirm password not same');
                }
                $request['password'] = Hash::make($request['password']);

                $updateUserWorkers = User::find($id)->update($request->all());
            }elseif($check == 1){
                $updateUserWorkers = User::find($id)->update($request->except(['password', 'confirm_password']));
            }
        }catch(\Throwable $th){
            return redirect()->route('admin.workers.show', ['workers' => $workers, 'id' => $id])->with('error', $workers .' data failed to update because email that want to update is already registered in this system');
        }

        return redirect()->route('admin.workers.index', $workers)->with('success', $workers . ' data updated successfully');
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

    //general settings logic
    public function addGeneralSetting($request)
    {
        try {
            $addSetting = Settings::create($request->all());
        } catch(\Throwable $th) {
            return back()->withError('Setting data failed to add because product categories cannot be duplicated');
        }
        
        return redirect()->route('admin.settings.index')->with('success', 'Setting data added successfully');
    }

    public function updateGeneralSetting($request, $id)
    {
        try{
            $updateSetting = Settings::find($id)->update($request->all());
        }catch(\Throwable $th) {
            return back()->withError('Setting data failed to update because product categories cannot be duplicated');
        }

        return redirect()->route('admin.settings.index')->with('success', 'Setting data updated successfully');
    }

    public function deleteGeneralSetting($id)
    {
        try{
            $deleteSetting = Settings::where('id',$id)->delete();
        }catch(\Throwable $th){
            return response()->json(['success' => false, 'message' => "Setting data failed to delete",]);
        }
        
        return response()->json(['success' => true, 'message' => "Setting data deleted successfully",]);
    }

}
?>