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

        if($companyName == ""){
            return response()->json(['success' => false, 'empty' => true,  'message' => "Company Name Data Empty"], 200);
        }

        $validateNameData = ResearchJobs::where('company_name','LIKE','%' . $companyName . '%')->get();

        if(count($validateNameData) > 0){
            return response()->json(['success' => false, 'empty' => false, 'message' => "Company Name Data Already Exists"], 200);
        }

        return response()->json(['success' => true, 'empty' => false, 'message' => "Company Name Data Is Acceptable"], 200);
    }

    public function validateCompanyWebsite(Request $request)
    {
        if($request['company_website'] == ""){
            return response()->json(['success' => false, 'empty' => true,  'message' => "Company Website Data Empty"], 200);
        }

        $companyWebsite = preg_replace('/\b(?:(?:https?|ftp):\/\/|www\.)/', '', $request['company_website']); //regex for filter url

        $validateWebsiteData = ResearchJobs::where('company_website','LIKE','%' . $companyWebsite . '%')->get();

        if(count($validateWebsiteData) > 0){
            return response()->json(['success' => false, 'empty' => false, 'message' => "Website Data Already Exists"], 200);
        }

        return response()->json(['success' => true, 'empty' => false, 'message' => "Website Data Is Acceptable"], 200);
    }

    public function validateCompanyEmail(Request $request)
    {
        if($request['company_email'] == ""){
            return response()->json(['success' => false, 'empty' => true,  'message' => "Company Email Data Empty"], 200);
        }

        $emailFilter = preg_replace('^[A-z0-9.]+@^', '', $request['company_email']); //regex for filter email

        $domainMailAllowed = array("gmail.com", "yahoo.com", "ymail.com", "rocketmail.com", "hotmail.com", "qq.com", "outlook.com", "live.com", "aol.com");

        if(in_array($emailFilter, $domainMailAllowed)){
            $emailFilter = $request['company_email'];
        }

        $validateEmailData = ResearchJobs::where('company_email','LIKE','%' . $emailFilter . '%')->get();

        if(count($validateEmailData) > 0){
            return response()->json(['success' => false, 'empty' => false, 'message' => "Email Data Already Exists"], 200);
        }

        return response()->json(['success' => true, 'empty' => false, 'message' => "Email Data Is Acceptable"], 200);
    }

    public function validateCompanyPhone(Request $request)
    {
        $companyPhone = $request['company_phone'];

        if($companyPhone == ""){
            return response()->json(['success' => false, 'empty' => true, 'message' => "Company Phone Data Empty"], 200);
        }

        $validatePhoneData = ResearchJobs::where('company_phone','LIKE','%' . $companyPhone . '%')->get();

        if(count($validatePhoneData) > 0){
            return response()->json(['success' => false, 'empty' => false, 'message' => "Company Phone Data Already Exists"], 200);
        }

        return response()->json(['success' => true, 'empty' => false, 'message' => "Company Phone Data Is Acceptable"], 200);
    }

    public function validateCompanyProduct(Request $request)
    {
        $companyProduct = $request['company_product_url'];

        if($companyProduct == ""){
            return response()->json(['success' => false, 'empty' => true, 'message' => "Company Product URL Data Empty"], 200);
        }

        $validateProductData = ResearchJobs::where('company_product_url','LIKE','%' . $companyProduct . '%')->get();

        if(count($validateProductData) > 0){
            return response()->json(['success' => false, 'empty' => false, 'message' => "Company Product URL Data Already Exists"], 200);
        }

        return response()->json(['success' => true, 'empty' => false, 'message' => "Company Product URL Data Is Acceptable"], 200);
    }

}