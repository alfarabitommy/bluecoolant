<?php

namespace App\Http\Controllers;

use App\Language;
use Illuminate\Http\Request;

class TeamPageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function team_page_about_section(){
        $all_language = Language::all();
        return view('backend.pages.team-page.about-section')->with(['all_language','$all_language']);
    }
    public function team_page_update_about_section(Request $request){

        $all_language = Language::all();

        foreach ($all_language as $lang){

            $this->validate($request,[
                'team_page_'.$lang->slug.'_about_section_title' => 'nullable|string',
                'team_page_'.$lang->slug.'_about_section_description' => 'nullable|string',
                'team_page_'.$lang->slug.'_about_section_image' => 'nullable|string',
            ]);
            $_about_section_title = 'team_page_'.$lang->slug.'_about_section_title';
            $_about_section_description = 'team_page_'.$lang->slug.'_about_section_description';
            $image_filed = 'team_page_'.$lang->slug.'_about_section_image';

            update_static_option('team_page_'.$lang->slug.'_about_section_title', $request->$_about_section_title);
            update_static_option('team_page_'.$lang->slug.'_about_section_description', $request->$_about_section_description);
            update_static_option('team_page_'.$lang->slug.'_about_section_image',$request->$image_filed);
        }

        return redirect()->back()->with(['msg' => 'Settings Update Success','type' => 'success']);
    }

    public function team_page_team_section(){
        $all_language = Language::all();
        return view('backend.pages.team-page.team-section')->with(['all_language' => $all_language]);
    }
    public function team_page_update_team_section(Request $request){
        $all_language = Language::all();
        $this->validate($request,[
            'team_page_team_member_section_item' => 'nullable|string'
        ]);
        foreach ($all_language as $lang){
            $this->validate($request,[
                'team_page_'.$lang->slug.'_team_member_section_title' => 'nullable|string',
            ]);
            $field = 'team_page_'.$lang->slug.'_team_member_section_title';

            update_static_option('team_page_'.$lang->slug.'_team_member_section_title', $request->$field);
        }
            update_static_option('team_page_team_member_section_item', $request->team_page_team_member_section_item);

        return redirect()->back()->with(['msg' => 'Settings Update Success','type' => 'success']);
    }
}
