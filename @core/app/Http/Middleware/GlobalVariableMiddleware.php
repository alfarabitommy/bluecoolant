<?php

namespace App\Http\Middleware;

use App\Blog;
use App\Language;
use App\Menu;
use App\SocialIcons;
use App\SupportInfo;
use Closure;
use App\StaticOption;

class GlobalVariableMiddleware
{

    public function handle($request, Closure $next)
    {

        view()->composer('*', function ($view) {
            $lang = !empty(session()->get('lang')) ? session()->get('lang') : Language::where('default',1)->first()->slug;
            $all_social_item = SocialIcons::all();
            $all_support_item = SupportInfo::where('lang',$lang)->get();
            $all_language = Language::where('status', 'publish')->get();
            $all_usefull_links = Menu::find(get_static_option('useful_link_'.get_user_lang().'_widget_menu_id'));
            $all_important_links = Menu::find(get_static_option('important_link_'.get_user_lang().'_widget_menu_id'));
            $all_recent_post = Blog::where('lang' ,$lang)->orderBy('id', 'DESC')->take(get_static_option('recent_post_widget_item'))->get();
            $primary_menu = Menu::where(['status' => 'default' ,'lang' => $lang])->first();

            //make a function to call all static option by home page
           $static_option_arr = [
               'product_module_status',
               'site_white_logo',
               'site_google_analytics',
               'og_meta_image_for_site',
               'site_main_color_one',
               'site_main_color_two',
               'site_secondary_color',
               'site_heading_color',
               'site_paragraph_color',
               'heading_font',
               'heading_font_family',
               'body_font_family',
               'body_font_family',
               'site_rtl_enabled',
               'services_page_slug',
               'about_page_slug',
               'contact_page_slug',
               'blog_page_slug',
               'team_page_slug',
               'faq_page_slug',
               'works_page_slug',
               'site_third_party_tracking_code',
               'site_favicon',
               'home_page_variant',
               'item_license_status',
               'site_script_unique_key',
               'site_meta_'.$lang.'_description',
               'site_meta_'.$lang.'_tags',
               'site_'.$lang.'_title',
               'site_'.$lang.'_tag_line',
           ];

            $static_field_data = StaticOption::whereIn('option_name',$static_option_arr)->get()->mapWithKeys(function ($item) {
            return [$item->option_name => $item->option_value];
          })->toArray();

            $view->with('global_static_field_data', $static_field_data);
            $view->with('all_support_item', $all_support_item);
            $view->with('all_usefull_links', $all_usefull_links);
            $view->with('all_important_links', $all_important_links);
            $view->with('all_recent_post', $all_recent_post);
            $view->with('all_social_item', $all_social_item);
            $view->with('all_language', $all_language);
            // $view->with('primary_menu', $primary_menu);
            $view->with('primary_menu_id', !empty($primary_menu) ? $primary_menu->id : '');
            $view->with('user_select_lang_slug', $lang);

        });

        return $next($request);
    }
}
