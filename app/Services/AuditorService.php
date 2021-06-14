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

class AuditorService
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

    public function addCompanyData($request)
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

            $addCompanyData = ResearchJobs::create($request->all());

        } catch(\Throwable $th) {
            return back()->withError('Company data failed to add because company data already exists');
        }
        
        return redirect()->route('researcher.researches')->with('success', 'Company data added successfully');
    }

    public function checkCompanyData($request)
    {
        try{
            if($request['type_search'] == "name"){
                $checkName = ResearchJobs::where('company_name','LIKE','%' . $request['input_data'] . '%')->get();
                
                if(count($checkName) > 0){
                    return back()->withError('Company name data already exists');
                }
            }elseif($request['type_search'] == "website"){
                $urlFilter = preg_replace('/\b(?:(?:https?|ftp):\/\/|www\.)/', '', $request['input_data']); //regex for filter url

                $checkWebsite = ResearchJobs::where('company_website','LIKE','%' . $urlFilter . '%')->get();
                if(count($checkWebsite) > 0){
                    return back()->withError('Company website data already exists');
                }
            }elseif($request['type_search'] == "email"){
                $emailFilter = preg_replace('^[A-z0-9.]+@^', '', $request['input_data']); //regex for filter email

                $domainMailAllowed = array("gmail.com", "yahoo.com", "ymail.com", "rocketmail.com", "hotmail.com", "qq.com", "outlook.com", "live.com", "aol.com");

                if(in_array($emailFilter, $domainMailAllowed)){
                    $emailFilter = $request['input_data'];
                }

                $checkEmail = ResearchJobs::where('company_website','LIKE','%' . $emailFilter . '%')->get();
                if(count($checkEmail) > 0){
                    return back()->withError('Company email data already exists');
                }
            }elseif($request['type_search'] == "phone"){
                $checkPhone = ResearchJobs::where('company_name','LIKE','%' . $request['input_data'] . '%')->get();

                if(count($checkPhone) > 0){
                    return back()->withError('Company phone data already exists');
                }
            }elseif($request['type_search'] == "product_url"){
                $checkProductUrl = ResearchJobs::where('company_name','LIKE','%' . $request['input_data'] . '%')->get();

                if(count($checkProductUrl) > 0){
                    return back()->withError('Company phone data already exists');
                }
            }

        }catch(\Throwable $th){
            return back()->withError('Company data already exists');
        }
        return redirect()->route('researcher.researches')->with('success', 'Company data not exists');
    }

}
?>