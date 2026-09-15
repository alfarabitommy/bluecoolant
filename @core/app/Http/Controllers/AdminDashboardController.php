<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Language;
use App\PaymentLogs;
use App\Services;
use App\Blog;
use App\ContactInfoItem;
use App\Counterup;
use App\KeyFeatures;
use App\PricePlan;
use App\TeamMember;
use App\Testimonial;
use App\Works;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Process\Process;
use Str;
use Illuminate\Support\Facades\Http;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function smtp_settings(){
        return view('backend.general-settings.smtp-settings');
    }

    public function update_smtp_settings(Request $request){
        $this->validate($request,[
            'site_smtp_mail_host' => 'required|string',
            'site_smtp_mail_port' => 'required|string',
            'site_smtp_mail_username' => 'required|string',
            'site_smtp_mail_password' => 'required|string',
            'site_smtp_mail_encryption' => 'required|string'
        ]);

        update_static_option('site_smtp_mail_mailer',$request->site_smtp_mail_mailer);
        update_static_option('site_smtp_mail_host',$request->site_smtp_mail_host);
        update_static_option('site_smtp_mail_port',$request->site_smtp_mail_port);
        update_static_option('site_smtp_mail_username',$request->site_smtp_mail_username);
        update_static_option('site_smtp_mail_password',$request->site_smtp_mail_password);
        update_static_option('site_smtp_mail_encryption',$request->site_smtp_mail_encryption);

        setEnvValue([
            'MAIL_DRIVER' => $request->site_smtp_mail_mailer,
            'MAIL_HOST' => $request->site_smtp_mail_host,
            'MAIL_PORT' => $request->site_smtp_mail_port,
            'MAIL_USERNAME' => $request->site_smtp_mail_username,
            'MAIL_PASSWORD' => '"'.$request->site_smtp_mail_password.'"',
            'MAIL_ENCRYPTION' => $request->site_smtp_mail_encryption
        ]);

        return redirect()->back()->with(['msg' => __('SMTP Settings Updated...'),'type' => 'success']);
    }

    public function adminIndex()
    {
        $all_blogs = Blog::count();
        $total_admin = Admin::count();
        $total_testimonial = Testimonial::count();
        $total_team_member = TeamMember::count();
        $total_counterup = Counterup::count();
        $total_price_plan = PricePlan::count();
        $total_services = Services::count();
        $total_key_features = KeyFeatures::count();
        $total_works = Works::count();
        $recent_orders = PaymentLogs::orderBy('id','desc')->take(5)->get();

        return view('backend.admin-home')->with([
            'blog_count' => $all_blogs,
            'total_admin' => $total_admin,
            'total_testimonial' => $total_testimonial,
            'total_team_member' => $total_team_member,
            'total_counterup' => $total_counterup,
            'total_price_plan' => $total_price_plan,
            'total_works' => $total_works,
            'total_services' => $total_services,
            'total_key_features' => $total_key_features,
            'recent_orders' => $recent_orders,
        ]);
    }

    public function site_identity()
    {
        return view('backend.general-settings.site-identity');
    }

    public function update_site_identity(Request $request)
    {
        $this->validate($request, [
            'site_logo' => 'nullable|string|max:191',
            'site_favicon' => 'nullable|string|max:191',
            'site_breadcrumb_bg' => 'nullable|string|max:191',
        ]);
        update_static_option('site_logo', $request->site_logo);
        update_static_option('site_favicon', $request->site_favicon);
        update_static_option('site_breadcrumb_bg', $request->site_breadcrumb_bg);

        return redirect()->back()->with([
            'msg' => __('Site Identity Has Been Updated..'),
            'type' => 'success'
        ]);
    }

    public function admin_settings()
    {
        return view('auth.admin.settings');
    }

    public function admin_profile_update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'username' => 'required|string|max:191',
            'image' => 'nullable|string|max:191'
        ]);
        Admin::find(Auth::user()->id)->update(['name' => $request->name, 'email' => $request->email,'username' =>
         str_replace(' ','_',$request->username), 'image' => $request->image]);

        return redirect()->back()->with(['msg' => __('Profile Update Success'), 'type' => 'success']);
    }

    public function admin_password_chagne(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed'
        ]);

        $user = Admin::findOrFail(Auth::id());

        if (Hash::check($request->old_password, $user->password)) {

            $user->password = Hash::make($request->password);
            $user->save();
            Auth::logout();

            return redirect()->route('admin.login')->with(['msg' => 'Password Changed Successfully', 'type' => 'success']);
        }

        return redirect()->back()->with(['msg' => 'Somethings Going Wrong! Please Try Again or Check Your Old Password', 'type' => 'danger']);
    }

    public function adminLogout()
    {
        Auth::logout();
        return redirect()->route('admin.login')->with(['msg' => 'You Logged Out !!', 'type' => 'danger']);
    }

    public function admin_profile()
    {
        return view('auth.admin.edit-profile');
    }

    public function admin_password()
    {
        return view('auth.admin.change-password');
    }

    public function contact()
    {
        $all_contact_info_items = ContactInfoItem::all();
        return view('backend.pages.contact')->with([
            'all_contact_info_item' => $all_contact_info_items
        ]);
    }

    public function update_contact(Request $request)
    {
        $this->validate($request, [
            'page_title' => 'required|string|max:191',
            'get_title' => 'required|string|max:191',
            'get_description' => 'required|string',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        update_static_option('contact_page_title', $request->page_title);
        update_static_option('contact_page_get_title', $request->get_title);
        update_static_option('contact_page_get_description', $request->get_description);
        update_static_option('contact_page_latitude', $request->latitude);
        update_static_option('contact_page_longitude', $request->longitude);

        return redirect()->back()->with(['msg' => 'Contact Page Info Update Success', 'type' => 'success']);
    }


    public function blog_page()
    {
        $all_languages = Language::all();
        return view('backend.pages.blog')->with(['all_languages' => $all_languages]);
    }

    public function blog_page_update(Request $request)
    {
        $all_language = Language::all();
        foreach ($all_language as $lang){
            $this->validate($request, [
                'blog_page_'.$lang->slug.'_title' => 'nullable',
                'blog_page_'.$lang->slug.'_item' => 'nullable',
                'blog_page_'.$lang->slug.'_category_widget_title' => 'nullable',
                'blog_page_'.$lang->slug.'_recent_post_widget_title' => 'nullable',
                'blog_page_'.$lang->slug.'_recent_post_widget_item' => 'nullable',
            ]);
            $blog_page_title = 'blog_page_'.$lang->slug.'_title';
            $blog_page_item = 'blog_page_'.$lang->slug.'_item';
            $blog_page_category_widget_title = 'blog_page_'.$lang->slug.'_category_widget_title';
            $blog_page_recent_post_widget_title = 'blog_page_'.$lang->slug.'_recent_post_widget_title';
            $blog_page_recent_post_widget_item = 'blog_page_'.$lang->slug.'_recent_post_widget_item';

            update_static_option('blog_page_'.$lang->slug.'_title', $request->$blog_page_title);
            update_static_option('blog_page_'.$lang->slug.'_item', $request->$blog_page_item);
            update_static_option('blog_page_'.$lang->slug.'_category_widget_title', $request->$blog_page_category_widget_title);
            update_static_option('blog_page_'.$lang->slug.'_recent_post_widget_title', $request->$blog_page_recent_post_widget_title);
            update_static_option('blog_page_'.$lang->slug.'_recent_post_widget_item', $request->$blog_page_recent_post_widget_item);
        }


        return redirect()->back()->with(['msg' => 'Blog Settings Update Success', 'type' => 'success']);
    }


    public function basic_settings()
    {
        $all_languages = Language::all();
        return view('backend.general-settings.basic')->with(['all_languages' => $all_languages]);
    }

    public function update_basic_settings(Request $request)
    {
        $this->validate($request, [
            'site_color' => 'required|string',
            'site_main_color_two' => 'required|string',
            'site_admin_panel_preloader_enabled' => 'nullable|string',
            'site_admin_dark_mode' => 'nullable|string',
            'site_maintenance_mode' => 'nullable|string',
            'site_payment_gateway' => 'nullable|string',
            'hide_frontend_language_change_option' => 'nullable|string',
            'disable_user_email_verify' => 'nullable|string',
            'disable_admin_panel_sticky_menu' => 'nullable|string',
        ]);

        $all_language = Language::all();

        foreach ($all_language as $lang) {
            $this->validate($request, [
                'site_' . $lang->slug . '_title' => 'nullable|string',
                'site_' . $lang->slug . '_tag_line' => 'nullable|string',
                'site_' . $lang->slug . '_footer_copyright' => 'nullable|string',
                'site_' . $lang->slug . '_footer_copyright' => 'nullable|string',
            ]);
            $_title = 'site_' . $lang->slug . '_title';
            $_tag_line = 'site_' . $lang->slug . '_tag_line';
            $_footer_copyright = 'site_' . $lang->slug . '_footer_copyright';

            update_static_option($_title, $request->$_title);
            update_static_option($_tag_line, $request->$_tag_line);
            update_static_option($_footer_copyright, $request->$_footer_copyright);
        }

            $all_fields = [
                'site_color',
                'site_main_color_two',
                'site_admin_panel_preloader_enabled',
                'site_admin_dark_mode',
                'site_maintenance_mode',
                'site_payment_gateway',
                'hide_frontend_language_change_option',
                'disable_user_email_verify',
                'disable_admin_panel_sticky_menu',
            ];

            foreach ($all_fields as $field){
                update_static_option($field,$request->$field);
            }

            return redirect()->back()->with(['msg' => 'Basic Settings Update Success', 'type' => 'success']);
    }

    public function seo_settings()
    {
        return view('backend.general-settings.seo');
    }

    public function update_seo_settings(Request $request)
    {
        $this->validate($request, [
            'site_meta_tags' => 'required|string',
            'site_meta_description' => 'required|string'
        ]);

        update_static_option('site_meta_tags', $request->site_meta_tags);
        update_static_option('site_meta_description', $request->site_meta_description);

        return redirect()->back()->with(['msg' => 'SEO Settings Update Success', 'type' => 'success']);
    }

    public function scripts_settings()
    {
        return view('backend.general-settings.thid-party');
    }

    public function update_scripts_settings(Request $request)
    {

        $this->validate($request, [
            'site_disqus_key' => 'nullable|string',
            'tawk_api_key' => 'nullable|string',
            'site_google_map_api' => 'nullable|string',
            'site_google_analytics' => 'nullable|string',
            'site_google_captcha_v3_secret_key' => 'nullable|string',
            'site_google_captcha_v3_site_key' => 'nullable|string',
        ]);

        update_static_option('site_disqus_key', $request->site_disqus_key);
        update_static_option('site_google_analytics', $request->site_google_analytics);
        update_static_option('tawk_api_key', $request->tawk_api_key);
        update_static_option('site_google_map_api', $request->site_google_map_api);
        update_static_option('site_google_captcha_v3_site_key', $request->site_google_captcha_v3_site_key);
        update_static_option('site_google_captcha_v3_secret_key', $request->site_google_captcha_v3_secret_key);

        return redirect()->back()->with(['msg' => 'Third Party Scripts Settings Updated..', 'type' => 'success']);
    }

    public function email_template_settings()
    {
        $all_languages = Language::all();
        return view('backend.general-settings.email-template')->with(['all_languages' => $all_languages]);
    }

    public function update_email_template_settings(Request $request)
    {
        $this->validate($request, [
            'site_global_email' => 'required|string',
        ]);

        update_static_option('site_global_email', $request->site_global_email);
        $all_languages = Language::all();

        foreach ($all_languages as $lang){
            $email_template = 'site_global_email_template_'.$lang->slug;
            update_static_option($email_template, $request->$email_template);
        }

        return redirect()->back()->with(['msg' => __('Email Settings Updated..'), 'type' => 'success']);
    }

    public function home_variant()
    {
        return view('backend.pages.home.home-variant');
    }

    public function update_home_variant(Request $request)
    {
        $this->validate($request, [
            'home_page_variant' => 'required|string'
        ]);
        update_static_option('home_page_variant', $request->home_page_variant);
        return redirect()->back()->with(['msg' => 'Home Variant Settings Updated..', 'type' => 'success']);
    }

    public function navbar_settings()
    {
        return view('backend.pages.navbar-settings');
    }

    public function update_navbar_settings(Request $request)
    {

        $this->validate($request, [
            'navbar_button' => 'nullable|string'
        ]);

        update_static_option('navbar_button', $request->navbar_button);
        $all_lang  = Language::all();
        foreach ($all_lang as $lang){
            $filed_name = 'navbar_'.$lang->slug.'_button_text';
            update_static_option('navbar_'.$lang->slug.'_button_text', $request->$filed_name);
        }

        return redirect()->back()->with(['msg' => 'Navbar Settings Updated..', 'type' => 'success']);
    }

    public function cache_settings()
    {
        return view('backend.general-settings.cache-settings');
    }

    public function update_cache_settings(Request $request)
    {

        $this->validate($request, [
            'cache_type' => 'required|string'
        ]);

        Artisan::call($request->cache_type . ':clear');

        return redirect()->back()->with(['msg' => 'Cache Cleaned...', 'type' => 'success']);
    }



    public function license_settings()
    {
        return view('backend.general-settings.license-settings');
    }

    public function update_license_settings(Request $request)
    {
            $this->validate($request, [
          'item_purchase_key' => 'required|string'
        ]);

      $response = Http::post('https://xgenious.com/api/v2/license/new', [
          'purchase_code' => $request->item_purchase_key,
          'site_url' => url('/'),
          'item_unique_key' => getenv('XGENIOUS_API_KEY'),
      ]);
      $result = $response->json();

      update_static_option('item_purchase_key', $request->item_purchase_key);
      update_static_option('item_license_status', $result['license_status']);
      update_static_option('item_license_msg', $result['msg']);

      $type = 'verified' == $result['license_status'] ? 'success' : 'danger';
      setcookie("site_license_check", "", time() - 3600,'/');
      $license_info = [
          "item_license_status" => $result['license_status'],
          "last_check" => time(),
          "purchase_code" => get_static_option('item_purchase_key'),
          "xgenious_app_key" => env('XGENIOUS_API_KEY'),
          "author" => env('XGENIOUS_API_AUTHOR'),
          "message" => $result['msg']
      ];
      file_put_contents('@core/license.json', json_encode($license_info));

      return redirect()->back()->with(['msg' => $result['msg'], 'type' => $type]);
  }

    public function custom_css_settings(){
        $custom_css = '/* Write Custom Css Here */';
        if (file_exists('assets/frontend/css/dynamic-style.css')){
            $custom_css = file_get_contents('assets/frontend/css/dynamic-style.css');
        }
        return view('backend.general-settings.custom-css')->with(['custom_css' => $custom_css]);
    }

    public function update_custom_css_settings(Request $request){
        $custom_css = $request->custom_css_area;
        file_put_contents('assets/frontend/css/dynamic-style.css',$custom_css);

        return redirect()->back()->with(['msg' => __('Custom Style Added Success...'), 'type' => 'success']);
    }

      public function typography_settings(){
        $all_google_fonts = file_get_contents('assets/frontend/webfonts/google-fonts.json');
        return view('backend.general-settings.typograhpy')->with(['google_fonts' => json_decode($all_google_fonts)]);
    }
    public function update_typography_settings(Request $request){
        $this->validate($request,[
            'body_font_family' => 'required|string|max:191',
            'body_font_variant' => 'required',
            'heading_font' => 'nullable|string',
            'heading_font_family' => 'nullable|string|max:191',
            'heading_font_variant' => 'nullable',
        ]);

        $save_data = [
            'body_font_family',
            'heading_font_family',
        ];
        foreach ($save_data as $item){
            if (empty($request->$item)){continue;}
            update_static_option($item,$request->$item);
        }
        update_static_option('heading_font',$request->heading_font);
        update_static_option('body_font_variant',serialize($request->body_font_variant));
        update_static_option('heading_font_variant',serialize($request->heading_font_variant));

        return redirect()->back()->with(['msg'=>'Typography Settings Updated..','type'=> 'success']);
    }

    public function page_settings()
    {
        $all_languages = Language::all();
        return view('backend.general-settings.page-settings')->with(['all_languages' => $all_languages]);
    }

    public function update_page_settings(Request $request)
      {
          $this->validate($request,[
              'about_page_slug' => 'required|string|max:191',
              'service_page_slug' => 'required|string|max:191',
              'work_page_slug' => 'required|string|max:191',
              'team_page_slug' => 'required|string|max:191',
              'faq_page_slug' => 'required|string|max:191',
              'blog_page_slug' => 'required|string|max:191',
              'contact_page_slug' => 'required|string|max:191',
              'quote_page_slug' => 'required|string|max:191',
          ]);

          $all_slugs = [
            'about_page_slug',
            'service_page_slug',
            'work_page_slug',
            'team_page_slug',
            'faq_page_slug',
            'blog_page_slug',
            'contact_page_slug',
            'quote_page_slug',
          ];

          foreach ($all_slugs as $slug){
              update_static_option($slug,Str::slug($request->$slug));
          }

          $all_languages = Language::all();
          foreach ($all_languages as $lang) {
              $this->validate($request, [
                  'about_page_' . $lang->slug . '_name' => 'nullable|string',
                  'service_page_' . $lang->slug . '_name' => 'nullable|string',
                  'work_page_' . $lang->slug . '_name' => 'nullable|string',
                  'team_page_' . $lang->slug . '_name' => 'nullable|string',
                  'faq_page_' . $lang->slug . '_name' => 'nullable|string',
                  'blog_page_' . $lang->slug . '_name' => 'nullable|string',
                  'contact_page_' . $lang->slug . '_name' => 'nullable|string',
                  'quote_page_' . $lang->slug . '_name' => 'nullable|string',
              ]);

              $all_fields = [
                  'about_page_' . $lang->slug . '_name',
                  'about_page_' . $lang->slug . '_meta_tags',
                  'about_page_' . $lang->slug . '_meta_description',
                  'service_page_' . $lang->slug . '_name',
                  'service_page_' . $lang->slug . '_meta_tags',
                  'service_page_' . $lang->slug . '_meta_description',
                  'work_page_' . $lang->slug . '_name',
                  'work_page_' . $lang->slug . '_meta_tags',
                  'work_page_' . $lang->slug . '_meta_description',
                  'team_page_' . $lang->slug . '_name',
                  'team_page_' . $lang->slug . '_meta_tags',
                  'team_page_' . $lang->slug . '_meta_description',
                  'faq_page_' . $lang->slug . '_name',
                  'faq_page_' . $lang->slug . '_meta_tags',
                  'faq_page_' . $lang->slug . '_meta_description',
                  'blog_page_' . $lang->slug . '_name',
                  'blog_page_' . $lang->slug . '_meta_tags',
                  'blog_page_' . $lang->slug . '_meta_description',
                  'contact_page_' . $lang->slug . '_name',
                  'contact_page_' . $lang->slug . '_meta_tags',
                  'contact_page_' . $lang->slug . '_meta_description',
                  'quote_page_' . $lang->slug . '_name',
                  'quote_page_' . $lang->slug . '_meta_tags',
                  'quote_page_' . $lang->slug . '_meta_description',
                  'account_page_' . $lang->slug . '_name',
                  'account_page_' . $lang->slug . '_meta_tags',
                  'account_page_' . $lang->slug . '_meta_description'
              ];

              foreach ($all_fields as $field){
                  update_static_option($field, $request->$field);
              }
          }

          return redirect()->back()->with(['msg' => __('Page Settings Updated..'), 'type' => 'success']);
      }

}
