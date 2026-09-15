<?php

namespace App\Http\Controllers;

use App\Language;
use Illuminate\Http\Request;

class ContactPageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function contact_page_form_area(){
        $all_language = Language::all();
        return view('backend.pages.contact-page.form-section')->with(['all_language' => $all_language]);
    }
    public function contact_page_update_form_area(Request $request){
        $all_language = Language::all();

        foreach ($all_language as $lang){
            $this->validate($request,[
                'contact_page_'.$lang->slug.'_form_section_title' => 'nullable|string'
            ]);
            $field = 'contact_page_'.$lang->slug.'_form_section_title';

            update_static_option('contact_page_'.$lang->slug.'_form_section_title',$request->$field);
        }

        return redirect()->back()->with(['msg' => 'Settings Updated..','type' => 'success']);
    }
    public function contact_page_map_area(){
        return view('backend.pages.contact-page.google-map-section');
    }
    public function contact_page_update_map_area(Request $request){
      $this->validate($request,[
           'contact_page_map_section_address' => 'required|string',
       ]);
       update_static_option('contact_page_map_section_address',$request->contact_page_map_section_address);

       return redirect()->back()->with(['msg' => __('Settings Updated..'),'type' => 'success']);
    }
}
