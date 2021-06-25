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
use App\Models\WorkerNotifications;

class AdminService
{
    //global function 
    public function globalPendingResearch($auth)
    {
        $globalPendingResearch = count(ResearchJobs::where('product_category_id', $auth->product_category_id)->where('job_status_id', 3)->where('is_blacklist', 'No')->get());

        return $globalPendingResearch;
    }

    public function globalPendingInquiry($auth)
    {
        $researchJobsId = [];
        
        $listResearchJobs = ResearchJobs::where('product_category_id', $auth->product_category_id)->get();
        
        if(count($listResearchJobs) == 0)
        {
            $globalPendingInquiry = 0;
            return $globalPendingInquiry;
        }
        
        $researchJobsLists = json_decode($listResearchJobs, true);

        foreach($researchJobsLists as $researchLists){
            array_push($researchJobsId, $researchLists['id']);
        }

        if(count($researchJobsId) == 0){
            $researchJobsId = 0;
        }

        $globalPendingInquiry = count(InquiryJobs::whereIn('research_jobs_id', $researchJobsId)->where('job_status_id', 3)->where('is_form', 'Yes')->get());

        return $globalPendingInquiry;
    }

    public function globalWorkerNotifications($auth)
    {
        $globalWorkerNotifications = WorkerNotifications::where('user_id', $auth->id)->first();
        
        return $globalWorkerNotifications;
    }


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

    public function blockUsers($request)
    {
        try{
            foreach($request['id'] as $id){
                $blockUsers = User::find($id)->update([
                    'status_id' => 2,
                ]);
            }
        }catch(\Throwable $th){
            return response()->json(['success' => false, 'message' => "Users data failed to block",]);
        }

        return response()->json(['success' => true, 'message' => "Users data success to block",]);
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

    public function blacklistResearches($request)
    {
        try{
            foreach($request['id'] as $id){
                $blacklistResearches = ResearchJobs::find($id)->update([
                    'is_blacklist' => "Yes",
                ]);
            }
        }catch(\Throwable $th){
            return response()->json(['success' => false, 'message' => "Researches data failed to blacklist",]);
        }

        return response()->json(['success' => true, 'message' => "Researches data success to blacklist",]);
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

    public function updateDetailInquiries($request, $id)
    {
        $user = Auth::user();

        try{
            $inquiryJobs = InquiryJobs::where('id', $id)->first();
            $researchJobs = ResearchJobs::where('id', $inquiryJobs->research_jobs_id)->first();

            if($request['job_status_id'] == 1 || $request['job_status_id'] == 4){
                
                if($inquiryJobs->screenshot_url !== NULL){
                    $deleteScreenshot = unlink($inquiryJobs->screenshot_url);
                    $request['screenshot_url'] = NULL;
                }

                $createAuditInquiriesData = AuditorInquiryJobs::create([
                    'user_id' => $user->id,
                    'inquiry_job_id' => $id,
                    'product_category_id' => $researchJobs->product_category_id,
                ]);
            }

            $updateInquiriesData = InquiryJobs::find($id)->update($request->all());
        }catch(\Throwable $th){
            return back()->withError('Inquiries data failed to update');
        }

        return redirect()->route('admin.inquiries.index')->with('success', 'Inquiries data updated successfully');
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
            //check id setting for dynamicly notifications

            if($id == 1) {
                $updateWeWork = WorkerNotifications::where('role_id', 3)->update(['how_we_work' => 1]);
            } elseif($id == 2) {
                $updateWeWork = WorkerNotifications::where('role_id', 4)->update(['how_we_work' => 1]);
            } elseif($id == 3) {
                $updateWeWork = WorkerNotifications::where('role_id', 5)->update(['how_we_work' => 1]);
            } elseif($id == 4) {
                $updateFAQ = WorkerNotifications::where('role_id', 3)->update(['faq' => 1]);
            } elseif($id == 5) {
                $updateFAQ = WorkerNotifications::where('role_id', 4)->update(['faq' => 1]);
            } elseif($id == 6) {
                $updateFAQ = WorkerNotifications::where('role_id', 5)->update(['faq' => 1]);
            } elseif($id == 7) {
                $updateNotice = WorkerNotifications::where('role_id', 3)->update(['notice' => 1]);
            } elseif($id == 8) {
                $updateWeWork = WorkerNotifications::where('role_id', 4)->update(['notice' => 1]);
            } elseif($id == 9) {
                $updateWeWork = WorkerNotifications::where('role_id', 5)->update(['notice' => 1]);
            }

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