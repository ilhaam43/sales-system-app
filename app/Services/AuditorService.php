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
use App\Models\AuditorInquiryJobs;

class AuditorService
{

    public function updateProfile($request, $id)
    {
        $check = empty($request['password']);

        try{
            if($check == 0){
                if($request['password'] !== $request['confirm_password']){
                    return redirect()->route('auditor.profile')->with('error', 'User failed to update cause password and confirm password not same');
                }

                if($_FILES['profile_image']['size'] == 0){
                    $request['password'] = Hash::make($request['password']);
                    $updateUsers = User::find($id)->update($request->except(['profile_image']));

                    return redirect()->route('auditor.profile')->with('success', 'User data updated successfully');
                }

                $image = User::find($id);

                if(is_null($image->profile_image) == 0){
                    $deletePhotoFile = unlink($image->profile_image);
                }

                $name = date('YmdHis') . $request->file('profile_image')->getClientOriginalName();
                
                $uploadImage = $request['profile_image']->move(public_path('auditors/img/photos'), $name);

                $input['profile_image'] = 'auditors/img/photos/' . $name;

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

                    return redirect()->route('auditor.profile')->with('success', 'User data updated successfully');
                }

                $image = User::find($id);
                
                if(is_null($image->profile_image) == 0){
                    $deletePhotoFile = unlink($image->profile_image);
                }

                $name = date('YmdHis') . $request->file('profile_image')->getClientOriginalName();

                $uploadImage = $request['profile_image']->move(public_path('auditors/img/photos'), $name);

                $input['profile_image'] = 'auditors/img/photos/' . $name;

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

    public function updateResearches($request, $id)
    {
        $urlFilter = preg_replace('/\b(?:(?:https?|ftp):\/\/|www\.)/', '', $request['company_website']); //regex for filter url

        $emailFilter = preg_replace('^[A-z0-9.]+@^', '', $request['company_email']); //regex for filter email

        $domainMailAllowed = array("gmail.com", "yahoo.com", "ymail.com", "rocketmail.com", "hotmail.com", "qq.com", "outlook.com", "live.com", "aol.com");

        if(in_array($emailFilter, $domainMailAllowed)){
            $emailFilter = $request['company_email'];
        }

        try {
            $checkUrl = ResearchJobs::where('company_website','LIKE','%' . $urlFilter . '%')->get();
            $checkEmail = ResearchJobs::where('company_email','LIKE','%' . $emailFilter . '%')->get();

            if(count($checkUrl) > 0){
                return back()->withError('Company data failed to add because company website data already exists');
            }elseif(count($checkEmail) > 0){
                return back()->withError('Company data failed to add because company email data already exists');
            }

            $updateCompanyData = ResearchJobs::find($id)->update($request->all());

        } catch(\Throwable $th) {
            return back()->withError('Company data failed to update because company data already exists');
        }
        
        return redirect()->route('researcher.researches')->with('success', 'Company data updated successfully');
    }

    public function updateInquiries($request, $id)
    {
        $user = Auth::user();

        try{
        $inquiryJobs = InquiryJobs::where('id', $id)->first();
        $researchJobs = ResearchJobs::where('id', $inquiryJobs->research_jobs_id)->first();

        $createAuditInquiriesData = AuditorInquiryJobs::create([
            'user_id' => $user->id,
            'inquiry_job_id' => $id,
            'product_category_id' => $researchJobs->product_category_id,
        ]);

        $updateInquiriesData = InquiryJobs::find($id)->update($request->all());
        }catch(\Throwable $th){
            return back()->withError('Inquiries data failed to update');
        }

        return redirect()->route('auditor.inquiries')->with('success', 'Inquiries data updated successfully');
    }

}
?>