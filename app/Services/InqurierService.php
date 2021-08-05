<?php
namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Countries;
use App\Models\ResearchJobs;
use App\Models\InquiryJobs;

class InqurierService
{

    public function updateProfile($request, $id)
    {
        $check = empty($request['password']);

        try{
            if($check == 0){
                if($request['password'] !== $request['confirm_password']){
                    return redirect()->route('inqurier.profile')->with('error', 'User failed to update cause password and confirm password not same');
                }

                if($_FILES['profile_image']['size'] == 0){
                    $request['password'] = Hash::make($request['password']);
                    $updateUsers = User::find($id)->update($request->except(['profile_image']));

                    return redirect()->route('inqurier.profile')->with('success', 'User data updated successfully');
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

                    return redirect()->route('inqurier.profile')->with('success', 'User data updated successfully');
                }

                $image = User::find($id);
                
                if(is_null($image->profile_image) == 0){
                    $deletePhotoFile = unlink($image->profile_image);
                }

                $name = date('YmdHis') . $request->file('profile_image')->getClientOriginalName();

                $uploadImage = $request['profile_image']->move(public_path('inquriers/img/photos'), $name);

                $input['profile_image'] = 'inquriers/img/photos/' . $name;

                $updateUsers = User::find($id)->update([
                    'name' => $request['name'],
                    'country_id' => $request['country_id'],
                    'profile_image' => $input['profile_image'],
                ]);
            }
        }catch(\Throwable $th){
            return redirect()->route('inqurier.profile')->with('error', 'User data failed to update cause your input data is invalid');
        }

        return redirect()->route('inqurier.profile')->with('success', 'User data updated successfully');
    }

    public function addInquiryData($request)
    {  
        $user = Auth::user();    

        $researchJobs = ResearchJobs::where('id', $request['research_jobs_id'])->first();

        $inquiryCount = $researchJobs->count_inquiry;

        if($inquiryCount == 1){
            return back()->withError('Inquiry data already added in this cycle, please inquiry another company');
        }  
        
        try{   

            $request['user_id'] = $user['id'];
            $request['job_status_id'] = 3;
            $request['is_form'] = "Yes";

            $name = date('YmdHis') . $request->file('screenshot')->getClientOriginalName();
            
            $uploadImage = $request['screenshot']->move(public_path('inquriers/img/inquiry'), $name);

            $request['screenshot_url'] = 'inquriers/img/inquiry/' . $name;
            
            $addInquiryData = InquiryJobs::create($request->except(['screenshot']));

            $updateCountCompany = $researchJobs->update([
                'count_inquiry' => 1
            ]);

        } catch(\Throwable $th) {
            return $th;
            return back()->withError('Inquiry data failed to add');
        }
        
        return redirect()->route('inqurier.companies')->with('success', 'Inquiry data added successfully');
    }

    public function addReportData($request)
    {       
        $user = Auth::user();
        
        try{   
            $researchJobs = ResearchJobs::where('id', $request['research_jobs_id'])->first();

            $request['user_id'] = $user['id'];
            $request['job_status_id'] = 3;
            $request['is_form'] = "No";
            
            $addReportData = InquiryJobs::create($request->all());

            $updateResearchJobs = $researchJobs->update([
                'is_form' => $request['is_form'],
            ]);

        } catch(\Throwable $th) {
            return back()->withError('Report data failed to add');
        }
        
        return redirect()->route('inqurier.companies')->with('success', 'Report data added successfully');
    }

}
?>