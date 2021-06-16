<?php
namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\ProductCategory;
use App\Models\Photos;
use App\Models\ResearchJobs;
use App\Models\InquiryJobs;
use App\Models\AuditorInquiryJobs;
use App\Models\AuditorResearchJobs;
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

    //researches logic
    public function approveResearches($request)
    {
        try{
            foreach($request['id'] as $id){
                $approveResearches = ResearchJobs::find($id)->update([
                    'job_status_id' => 1,
                ]);
            }
        }catch(\Throwable $th){
            return response()->json(['success' => false, 'message' => "Researches data failed to approve",]);
        }

        return response()->json(['success' => true, 'message' => "Researches data success to approve",]);
    }

    public function rejectResearches($request)
    {
        try{
            foreach($request['id'] as $id){
                $rejectResearches = ResearchJobs::find($id)->update([
                    'job_status_id' => 4,
                ]);
            }
        }catch(\Throwable $th){
            return response()->json(['success' => false, 'message' => "Researches data failed to reject",]);
        }

        return response()->json(['success' => true, 'message' => "Researches data success to reject",]);
    }

    //inquiries function
    public function approveInquiries($request)
    {
        try{
            foreach($request['id'] as $id){

                $inquiryJobs = InquiryJobs::whereIn('id', $request['id'])->get();

                foreach($inquiryJobs as $inquiries){
                    $screenshotImg = file_exists(public_path($inquiries->screenshot_url));
                    if($inquiries->screenshot_url !== NULL && $screenshotImg == 1){
                        $deleteScreenshot = unlink($inquiries->screenshot_url);
                    }
                }

                $approveInquiries = InquiryJobs::find($id)->update([
                    'job_status_id' => 1,
                    'screenshot_url' => NULL,
                ]);
            }

        }catch(\Throwable $th){
            return $th;
            return response()->json(['success' => false, 'message' => "Inquiries data failed to approve",]);
        }

        return response()->json(['success' => true, 'message' => "Inquiries data success to approve",]);
    }

    public function rejectInquiries($request)
    {
        try{
            foreach($request['id'] as $id){
                $inquiryJobs = InquiryJobs::whereIn('id', $request['id'])->get();

                foreach($inquiryJobs as $inquiries){
                    $screenshotImg = file_exists(public_path($inquiries->screenshot_url));
                    if($inquiries->screenshot_url !== NULL && $screenshotImg == 1){
                        $deleteScreenshot = unlink($inquiries->screenshot_url);
                    }
                }

                $rejectInquiries = InquiryJobs::find($id)->update([
                    'job_status_id' => 4,
                    'screenshot_url' => NULL,
                ]);
            }
        }catch(\Throwable $th){
            return response()->json(['success' => false, 'message' => "Inquiries data failed to approve",]);
        }

        return response()->json(['success' => true, 'message' => "Inquiries data success to reject",]);
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