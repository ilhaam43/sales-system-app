<?php
namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Countries;

class ResearcherService
{

    public function updateProfile($request, $id)
    {
        $check = empty($request['password']);

        try{
            if($check == 0){
                if($request['password'] !== $request['confirm_password']){
                    return redirect()->route('researcher.profile')->with('error', 'User failed to update cause password and confirm password not same');
                }

                if($_FILES['profile_image']['size'] == 0){
                    $request['password'] = Hash::make($request['password']);
                    $updateUsers = User::find($id)->update($request->except(['profile_image']));

                    return redirect()->route('researcher.profile')->with('success', 'User data updated successfully');
                }

                $image = User::find($id);

                if(is_null($image->profile_image) == 0){
                    $deletePhotoFile = unlink($image->profile_image);
                }

                $name = date('YmdHis') . $request->file('profile_image')->getClientOriginalName();
                
                $uploadImage = $request['profile_image']->move(public_path('researches/img/photos'), $name);

                $input['profile_image'] = 'researches/img/photos/' . $name;

                $request['password'] = Hash::make($request['password']);

                $updateUsers = User::find($id)->update([
                    'name' => $request['name'],
                    'country_id' => $request['country_id'],
                    'profile_image' => $input['profile_image'],
                    'password' => $request['password'],
                ]);

            }elseif($check == 1){

                if($_FILES['profile_image']['size'] == 0){
                    $updateUsers = User::find($id)->update($request->except(['password', 'confirm_password', 'profile_image']));

                    return redirect()->route('researcher.profile')->with('success', 'User data updated successfully');
                }

                $image = User::find($id);
                
                if(is_null($image->profile_image) == 0){
                    $deletePhotoFile = unlink($image->profile_image);
                }

                $name = date('YmdHis') . $request->file('profile_image')->getClientOriginalName();

                $uploadImage = $request['profile_image']->move(public_path('researches/img/photos'), $name);

                $input['profile_image'] = 'researches/img/photos/' . $name;

                $updateUsers = User::find($id)->update([
                    'name' => $request['name'],
                    'country_id' => $request['country_id'],
                    'profile_image' => $input['profile_image'],
                ]);
            }
        }catch(\Throwable $th){
            return redirect()->route('researcher.profile')->with('error', 'User data failed to update cause your input data is invalid');
        }

        return redirect()->route('researcher.profile')->with('success', 'User data updated successfully');
    }

    

}
?>