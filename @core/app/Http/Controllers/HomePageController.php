<?php

namespace App\Http\Controllers;

use App\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class HomePageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function home_01_counterup(){
        return view('backend.pages.home.home-01.counterup');
    }
    public function home_01_update_counterup(Request $request){

      $this->validate($request, [
               'home_01_counterup_bg_image' => 'nullable|string|max:191'
           ]);
           $save_data = [
               'home_01_counterup_bg_image'
           ];
           foreach ($save_data as $item) {
               if (empty($request->$item)) {
                   continue;
               }
               update_static_option($item, $request->$item);
           }

           return redirect()->back()->with([
               'msg' => 'Settings Updated ...',
               'type' => 'success'
           ]);
    }
    public function home_01_build_dream(){
        return view('backend.pages.home.home-01.build-dream');
    }

    public function home_01_update_build_dream(Request $request){

        $all_language = Language::all();

        foreach ($all_language as $lang){
            $this->validate($request,[
                'home_page_01_'.$lang->slug.'_build_dream_title' => 'nullable|string|max:191',
                'home_page_01_'.$lang->slug.'_build_dream_description' => 'nullable|string',
                'home_page_01_'.$lang->slug.'_build_dream_btn_title' => 'nullable|string|max:191',
                'home_page_01_'.$lang->slug.'_build_dream_btn_url' => 'nullable|string|max:191',
                'home_page_01_'.$lang->slug.'_build_dream_video_url' => 'nullable|string|max:191',
                'home_page_01_'.$lang->slug.'_build_dream_right_image' => 'nullable|string',
            ]);
            $save_data = [
                'home_page_01_'.$lang->slug.'_build_dream_title',
                'home_page_01_'.$lang->slug.'_build_dream_description',
                'home_page_01_'.$lang->slug.'_build_dream_btn_title',
                'home_page_01_'.$lang->slug.'_build_dream_btn_url',
                'home_page_01_'.$lang->slug.'_build_dream_right_image',
                'home_page_01_'.$lang->slug.'_build_dream_video_url'
            ];
            foreach ($save_data as $item){
                if (empty($request->$item)){continue;}
                update_static_option($item,$request->$item);
            }

            $home_right_image = 'home_page_01_'.$lang->slug.'_build_dream_right_image';
            $build_dream_button_status = 'build_dream_'.$lang->slug.'_section_button_status';

            update_static_option('home_page_01_'.$lang->slug.'_build_dream_right_image', $request->$home_right_image);
            update_static_option('build_dream_'.$lang->slug.'_section_button_status',$request->$build_dream_button_status);

        }

        return redirect()->back()->with([
            'msg' => 'Settings Updated ...',
            'type' => 'success'
        ]);
    }

    public function home_01_testimonial(){
        return view('backend.pages.home.home-01.testimonial');
    }
    public function home_01_update_testimonial(Request $request){

        $all_language = Language::all();
        foreach ($all_language as $lang){
            $this->validate($request,[
                'home_page_01_'.$lang->slug.'_testimonial_title' => 'nullable|string',
            ]);
            $field_name = 'home_page_01_'.$lang->slug.'_testimonial_title';
            update_static_option($field_name,$request->$field_name);
        }

        return redirect()->back()->with([
            'msg' => 'Settings Updated ...',
            'type' => 'success'
        ]);
    }
    public function home_01_latest_news(){
        return view('backend.pages.home.home-01.latest-news');
    }
    public function home_01_update_latest_news(Request $request){

        $all_language = Language::all();
        foreach ($all_language as $lang){
            $this->validate($request,[
                'home_page_01_'.$lang->slug.'_latest_news_title' => 'nullable|string',
            ]);
            $field_name = 'home_page_01_'.$lang->slug.'_latest_news_title';
            update_static_option($field_name,$request->$field_name);
        }

        return redirect()->back()->with([
            'msg' => 'Settings Updated ...',
            'type' => 'success'
        ]);
    }


    public function home_01_service_area(){
        return view('backend.pages.home.home-01.service-area');
    }
    public function home_01_update_service_area(Request $request){
        $this->validate($request,[
            'home_page_01_service_area_items' => 'required|string',
        ]);

        $all_language = Language::all();
        foreach ($all_language as $lang){
            $field_name = 'home_page_01_'.$lang->slug.'_service_area_title';
            update_static_option($field_name,$request->$field_name);
        }
        update_static_option('home_page_01_service_area_items', $request->home_page_01_service_area_items);
        return redirect()->back()->with([
            'msg' => 'Settings Updated ...',
            'type' => 'success'
        ]);
    }

    public function home_01_recent_work(){
        return view('backend.pages.home.home-01.recent-work');
    }
    public function home_01_update_recent_work(Request $request){

        $all_language = Language::all();
        foreach ($all_language as $lang){
            $this->validate($request,[
                'home_page_01_'.$lang->slug.'_recent_work_title' => 'nullable|string',
            ]);
            $field_name = 'home_page_01_'.$lang->slug.'_recent_work_title';
            update_static_option($field_name,$request->$field_name);
        }

        return redirect()->back()->with([
            'msg' => 'Settings Updated ...',
            'type' => 'success'
        ]);
    }



    public function home_01_section_manage(){
        return view('backend.pages.section-manage');
    }
    public function home_01_update_section_manage(Request $request){

        $this->validate($request,[
            'home_page_key_feature_section_status' => 'nullable|string',
            'home_page_build_dream_section_status' => 'nullable|string',
            'home_page_counterup_section_status' => 'nullable|string',
            'home_page_service_section_status' => 'nullable|string',
            'home_page_recent_work_section_status' => 'nullable|string',
            'home_page_testimonial_section_status' => 'nullable|string',
            'home_page_latest_news_section_status' => 'nullable|string',
            'home_page_brand_logo_section_status' => 'nullable|string',
            'home_page_support_bar_section_status' => 'nullable|string',
            'home_page_price_plan_section_status' => 'nullable|string',
            'home_page_team_member_section_status' => 'nullable|string',
            ]);

            update_static_option('home_page_build_dream_section_status',$request->home_page_build_dream_section_status);
            update_static_option('home_page_service_section_status',$request->home_page_service_section_status);
            update_static_option('home_page_key_feature_section_status',$request->home_page_key_feature_section_status);
            update_static_option('home_page_counterup_section_status',$request->home_page_counterup_section_status);
            update_static_option('home_page_recent_work_section_status',$request->home_page_recent_work_section_status);
            update_static_option('home_page_testimonial_section_status',$request->home_page_testimonial_section_status);
            update_static_option('home_page_latest_news_section_status',$request->home_page_latest_news_section_status);
            update_static_option('home_page_brand_logo_section_status',$request->home_page_brand_logo_section_status);
            update_static_option('home_page_support_bar_section_status',$request->home_page_support_bar_section_status);
            update_static_option('home_page_price_plan_section_status',$request->home_page_price_plan_section_status);
            update_static_option('home_page_team_member_section_status',$request->home_page_team_member_section_status);

        Artisan::call('route:clear');
        Artisan::call('view:clear');
        Artisan::call('config:clear');
        Artisan::call('cache:clear');

        return redirect()->back()->with([
            'msg' => 'Settings Updated ...',
            'type' => 'success'
        ]);
    }
    public function home_01_price_plan(){
        return view('backend.pages.home.home-01.price-plan');
    }
    public function home_01_update_price_plan(Request $request){

        $this->validate($request,[
            'home_page_01_price_plan_section_items' => 'required|string',
        ]);

        $all_language = Language::all();
        foreach ($all_language as $lang){
            $this->validate($request,[
                'home_page_01_'.$lang->slug.'_price_plan_section_title' => 'nullable|string',
            ]);
            $field_name = 'home_page_01_'.$lang->slug.'_price_plan_section_title';
            update_static_option($field_name,$request->$field_name);
        }

        update_static_option('home_page_01_price_plan_section_items',$request->home_page_01_price_plan_section_items);

        return redirect()->back()->with([
            'msg' => 'Settings Updated ...',
            'type' => 'success'
        ]);
    }

    public function home_01_team_member(){
        return view('backend.pages.home.home-01.team-member');
    }
    public function home_01_update_team_member(Request $request){

        $this->validate($request,[
            'home_page_01_team_member_section_items' => 'required|string',
        ]);

        $all_language = Language::all();
        foreach ($all_language as $lang){
            $this->validate($request,[
                'home_page_01_'.$lang->slug.'_team_member_section_title' => 'nullable|string',
            ]);
            $field_name = 'home_page_01_'.$lang->slug.'_team_member_section_title';
            update_static_option($field_name,$request->$field_name);
        }

        update_static_option('home_page_01_team_member_section_items',$request->home_page_01_team_member_section_items);

        return redirect()->back()->with([
            'msg' => 'Settings Updated ...',
            'type' => 'success'
        ]);
    }

    public function home_01_newsletter()
    {
        return view('backend.pages.home.home-01.newsletter');
    }

    public function home_01_update_newsletter(Request $request){
        $all_language = Language::all();
        foreach ($all_language as $lang){
            $this->validate($request,[
                'home_page_01_'.$lang->slug.'_newsletter_area_title' => 'nullable|string',
                'home_page_01_'.$lang->slug.'_newsletter_area_description' => 'nullable|string',
            ]);
            $field_name = 'home_page_01_'.$lang->slug.'_newsletter_area_title';
            $field_name_two = 'home_page_01_'.$lang->slug.'_newsletter_area_description';
            update_static_option($field_name,$request->$field_name);
            update_static_option($field_name_two,$request->$field_name_two);
        }

        return redirect()->back()->with([
            'msg' => 'Settings Updated ...',
            'type' => 'success'
        ]);
    }
}
