<?php

namespace App\Http\Controllers;

use App\Language;
use Illuminate\Http\Request;

class AboutPageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function about_page_about_section(){
        $all_language = Language::all();
        return view('backend.pages.about.about-section')->with(['all_language' => $all_language]);
    }
    public function about_page_update_about_section(Request $request){

        $all_language = Language::all();

        foreach ($all_language as $lang){
            $this->validate($request ,[
                'about_page_'.$lang->slug.'_about_section_title' => 'nullable|string',
                'about_page_'.$lang->slug.'_about_section_btn_text' => 'nullable|string',
                'about_page_'.$lang->slug.'_about_section_description' => 'nullable|string',
                'about_page_'.$lang->slug.'_about_section_btn_url' => 'nullable|string',
                'about_page_'.$lang->slug.'_about_section_left_image' => 'nullable|string'
            ]);

            $_about_section_btn_status = 'about_page_'.$lang->slug.'_about_section_btn_status';
            $_about_section_title = 'about_page_'.$lang->slug.'_about_section_title';
            $_about_section_btn_text = 'about_page_'.$lang->slug.'_about_section_btn_text';
            $_about_section_description = 'about_page_'.$lang->slug.'_about_section_description';
            $_about_section_btn_url = 'about_page_'.$lang->slug.'_about_section_btn_url';
            $image_filed = 'about_page_'.$lang->slug.'_about_section_left_image';

            update_static_option('about_page_'.$lang->slug.'_about_section_btn_status',$request->$_about_section_btn_status);
            update_static_option('about_page_'.$lang->slug.'_about_section_title',$request->$_about_section_title);
            update_static_option('about_page_'.$lang->slug.'_about_section_btn_text',$request->$_about_section_btn_text);
            update_static_option('about_page_'.$lang->slug.'_about_section_description',$request->$_about_section_description);
            update_static_option('about_page_'.$lang->slug.'_about_section_btn_url',$request->$_about_section_btn_url);
            update_static_option('about_page_'.$lang->slug.'_about_section_left_image', $request->$image_filed);
        }

        return redirect()->back()->with([
            'msg' => 'Settings Updated ...',
            'type' => 'success'
        ]);
    }
    public function about_page_team_member_section(){
        $all_language = Language::all();
        return view('backend.pages.about.team-section')->with(['all_language' => $all_language]);
    }
    public function about_page_update_team_member_section(Request $request){
        $all_language = Language::all();

        foreach ($all_language as $lang){
            $this->validate($request ,[
                'about_page_'.$lang->slug.'_team_section_title' => 'nullable|string',
            ]);
            $filed = 'about_page_'.$lang->slug.'_team_section_title';

            update_static_option('about_page_'.$lang->slug.'_team_section_title',$request->$filed);
        }

        return redirect()->back()->with([
            'msg' => 'Settings Updated ...',
            'type' => 'success'
        ]);
    }
}
