<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ResearchJobs;


class AjaxValidationDataController extends Controller
{
    //form validation client side with ajax
    public function validateCompanyName(Request $request)
    {
        $companyName = $request['company_name'];

        $validateNameData = ResearchJobs::where('company_name','LIKE','%' . $companyName . '%')->get();

        if(count($validateNameData) > 0){
            return response()->json(['success' => false, 'message' => "Company Name Data Already Exists"], 200);
        }

        return response()->json(['success' => true, 'message' => "Company Name Data Is Acceptable"], 200);
    }

    public function validateCompanyWebsite(Request $request)
    {
        $companyWebsite = preg_replace('/\b(?:(?:https?|ftp):\/\/|www\.)/', '', $request['company_website']); //regex for filter url

        $validateWebsiteData = ResearchJobs::where('company_website','LIKE','%' . $companyWebsite . '%')->get();

        if(count($validateWebsiteData) > 0){
            return response()->json(['success' => false, 'message' => "Website Data Already Exists"], 200);
        }

        return response()->json(['success' => true, 'message' => "Website Data Is Acceptable"], 200);
    }

    public function validateCompanyEmail(Request $request)
    {
        $emailFilter = preg_replace('^[A-z0-9.]+@^', '', $request['company_email']); //regex for filter email

        $domainMailAllowed = array("gmail.com", "yahoo.com", "ymail.com", "rocketmail.com", "hotmail.com", "qq.com", "outlook.com", "live.com", "aol.com");

        if(in_array($emailFilter, $domainMailAllowed)){
            $emailFilter = $request['company_email'];
        }

        $validateEmailData = ResearchJobs::where('company_email','LIKE','%' . $emailFilter . '%')->get();

        if(count($validateEmailData) > 0){
            return response()->json(['success' => false, 'message' => "Email Data Already Exists"], 200);
        }

        return response()->json(['success' => true, 'message' => "Email Data Is Acceptable"], 200);
    }

    public function validateCompanyPhone(Request $request)
    {
        $companyPhone = $request['company_phone'];

        $validatePhoneData = ResearchJobs::where('company_phone','LIKE','%' . $companyPhone . '%')->get();

        if(count($validatePhoneData) > 0){
            return response()->json(['success' => false, 'message' => "Company Phone Data Already Exists"], 200);
        }

        return response()->json(['success' => true, 'message' => "Company Phone Data Is Acceptable"], 200);
    }

    public function validateCompanyProduct(Request $request)
    {
        $companyProduct = $request['company_product_url'];

        $validateProductData = ResearchJobs::where('company_product_url','LIKE','%' . $companyProduct . '%')->get();

        if(count($validateProductData) > 0){
            return response()->json(['success' => false, 'message' => "Company Product URL Data Already Exists"], 200);
        }

        return response()->json(['success' => true, 'message' => "Company Product URL Data Is Acceptable"], 200);
    }

}