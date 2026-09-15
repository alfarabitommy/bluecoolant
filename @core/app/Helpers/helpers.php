<?php

use App\Language;
use App\StaticOption;
use App\WorksCategory;
use App\Works;
use App\MediaUpload;

function active_menu($url){

    return $url == request()->path() ? 'active' : '';
}
function active_menu_frontend($url){

    return $url == request()->path() ? 'current-menu-item' : '';
}


function check_image_extension($file){
    $extension = strtolower($file->getClientOriginalExtension());
    if ($extension != 'jpg' && $extension != 'jpeg' && $extension != 'png' && $extension = 'gif') {
       return false ;
    }
    return true;
}
function sendSubscriberEmail($to, $subject, $message ,$from = '' ){

    $from = get_static_option('site_global_email') ;
    $headers = "From: ".$from." \r\n";
    $headers .= "Reply-To: <$from> \r\n";
    $headers .= "Return-Path: ".($from) . "\r\n";;
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    $headers .= "X-Priority: 2\nX-MSmail-Priority: high";;
    $headers .= "X-Mailer: PHP". phpversion() ."\r\n";

    if (mail($to, $subject, $message, $headers)){
        return true;
    }

}

function sendEmail($to, $name, $subject, $message ,$from = '' ){
    $template = get_static_option('site_global_email_template');
    $from = get_static_option('site_global_email') ;

    $headers = "From: ".$from." \r\n";
    $headers .= "Reply-To: <$from> \r\n";
    $headers .= "Return-Path: ".($from) . "\r\n";;
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    $headers .= "X-Priority: 2\nX-MSmail-Priority: high";;
    $headers .= "X-Mailer: PHP". phpversion() ."\r\n";

    $mm = str_replace("@username",$name,$template);
    $message = str_replace("@message",$message,$mm);
    $message = str_replace("@company",get_static_option('site_title'),$message);

    if (mail($to, $subject, $message, $headers)){
        return true;
    }

}
function sendPlanEmail($to, $name, $subject, $message,$from){

    $headers = "From: ".$from." \r\n";
    $headers .= "Reply-To: <$from> \r\n";
    $headers .= "Return-Path: ".($from) . "\r\n";;
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    $headers .= "X-Priority: 2\nX-MSmail-Priority: high";;
    $headers .= "X-Mailer: PHP". phpversion() ."\r\n";
$message = "\nThis mail send by ".$name;
    if (mail($to, $subject, $message, $headers)){
        return true;
    }
}


function set_static_option($key,$value){
    if (!StaticOption::where('option_name',$key)->first()){
        StaticOption::create([
            'option_name' => $key,
            'option_value' => $value
        ]);
        return true;
    }
    return false;
}
function get_static_option($key){
    if (StaticOption::where('option_name',$key)->first()){
        $return_val = StaticOption::where('option_name',$key)->first();
        return $return_val->option_value;
    }
    return null;
}
function update_static_option($key,$value){
    if (!StaticOption::where('option_name',$key)->first()){
        StaticOption::create([
            'option_name' => $key,
            'option_value' => $value
        ]);
        return true;
    }else{
        StaticOption::where('option_name',$key)->update([
            'option_name' => $key,
            'option_value' => $value
        ]);
        return true;
    }
    return false;
}
function delete_static_option($key){
    if (!StaticOption::where('option_name',$key)->first()){
        StaticOption::where('option_name', $key)->delete();
        return true;
    }
    return false;
}

function get_total_donate($id){
    $return_val = 0;
    if (BloodLog::where('donors_id',$id)->count()){
        $return_val = BloodLog::where('donors_id',$id)->count();
    }

    return $return_val;
}

function single_post_share($url,$title,$img_url){
    $output = '';
    //get current page url
    $encoded_url = urlencode($url);
    //get current page title
    $post_title = str_replace(' ','%20',$title);

    //all social share link generate
    $facebook_share_link = 'https://www.facebook.com/sharer/sharer.php?u='.$encoded_url;
    $twitter_share_link = 'https://twitter.com/intent/tweet?text='.$post_title.'&amp;url='.$encoded_url.'&amp;via=Crunchify';
    $linkedin_share_link = 'https://www.linkedin.com/shareArticle?mini=true&url='.$encoded_url.'&amp;title='.$post_title;
    $pinterest_share_link = 'https://pinterest.com/pin/create/button/?url='.$encoded_url.'&amp;media='.$img_url.'&amp;description='.$post_title;

    $output .='<li><a class="facebook" href="'.$facebook_share_link.'"><i class="fab fa-facebook-f"></i></a></li>';
    $output .='<li><a class="twitter" href="'.$twitter_share_link.'"><i class="fab fa-twitter"></i></a></li>';
    $output .='<li><a class="linkedin" href="'.$linkedin_share_link.'"><i class="fab fa-linkedin-in"></i></a></li>';
    $output .='<li><a class="pinterest" href="'.$pinterest_share_link.'"><i class="fab fa-pinterest-p"></i></a></li>';

    return $output;
}


function formatBytes($size, $precision = 2)
{
    $base = log($size, 1024);
    $suffixes = array('', 'KB', 'MB', 'GB', 'TB');

    return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
}


function licnese_cheker () {
    $data = array(
        'action' => env('XGENIOUS_API_ACTION'),
        'purchase_code' => get_static_option('item_purchase_key'),
        'author' => env('XGENIOUS_API_AUTHOR'),
        'site_url' => url('/'),
        'item_unique_key' => env('XGENIOUS_API_KEY'),
    );
    //item_license_status
    $api_url = env('XGENIOUS_API_URL') . '?' . http_build_query($data);
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $api_url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    $result = curl_exec($curl);
    curl_close($curl);
    $result = json_decode($result);
     //update_static_option('item_license_status', $result->license_status);
    // $type = 'verified' == $result->license_status ? 'success' : 'danger';
    // $license_info = [
    //     "item_license_status" => $result->license_status,
    //     "last_check" => time(),
    //     "purchase_code" => get_static_option('item_purchase_key'),
    //     "xgenious_app_key" => env('XGENIOUS_API_KEY'),
    //     "author" => env('XGENIOUS_API_AUTHOR'),
    //     "message" => $result->message
    // ];
     //file_put_contents('@core/license.json',json_encode($license_info));
}

function get_work_category_by_id($id, $output = 'array'){
    // 1. Ambil data produk. Jika tidak ditemukan, kembalikan nilai default langsung.
    $work_item = Works::find($id);

    if (is_null($work_item)) {
        // Jika produk tidak ada, kembalikan nilai default (array kosong untuk mencegah crash).
        if ($output == 'string' || $output == 'slug') {
            return '';
        }
        return [];
    }

    // 2. Ambil categories_id. Pastikan nilainya adalah array/collection yang dapat di-loop.
    // Asumsi categories_id adalah kolom JSON atau array.
    $category_ids = $work_item->categories_id; 

    // Jika categories_id adalah null atau bukan array/object yang bisa di-loop,
    // kita set ke array kosong untuk mencegah error foreach.
    if (!is_array($category_ids) && !($category_ids instanceof \Illuminate\Support\Collection)) {
        $category_ids = [];
    }
    
    // Inisialisasi variabel output
    $cat_list = [];
    $cat_list_string = '';
    $cat_list_slug = '';

    // 3. Lakukan perulangan
    foreach ($category_ids as $key => $data){
        // ... (Logika perulangan Anda tetap sama)
        $separator = $key != 0 ? ', ' : '';
        $cat_item = WorksCategory::find($data);
        if ($cat_item){
            $cat_list[$cat_item->id] = $cat_item->name;
            $cat_list_string  .= $separator .$cat_item->name ;
            $cat_list_slug  .= Str::slug($cat_item->name) .' ';
        }
    }
    
    // 4. Return hasil
    switch ($output){
        case ("string"):
            return $cat_list_string;
        case ("slug"):
            return $cat_list_slug;
        default:
            return $cat_list;
    }
}
function get_one_work_category_by_id($id){
    $category_id = WorksCategory::where('id', $id)->first();
    return $category_id->name;

 

}


function get_child_menu_count($menu_content,$parent_id){
    $return_val = 0;
    foreach ($menu_content as $data){
        if ($parent_id == $data->parent_id){
            $return_val++;
        }
    }
    return $return_val;
}

function minify_css_lines($css){
    // some of the following functions to minimize the css-output are directly taken
    // from the awesome CSS JS Booster: https://github.com/Schepp/CSS-JS-Booster
    // all credits to Christian Schaefer: http://twitter.com/derSchepp
    // remove comments
    $css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);
    // backup values within single or double quotes
    preg_match_all('/(\'[^\']*?\'|"[^"]*?")/ims', $css, $hit, PREG_PATTERN_ORDER);
    for ($i=0; $i < count($hit[1]); $i++) {
        $css = str_replace($hit[1][$i], '##########' . $i . '##########', $css);
    }
    // remove traling semicolon of selector's last property
    $css = preg_replace('/;[\s\r\n\t]*?}[\s\r\n\t]*/ims', "}\r\n", $css);
    // remove any whitespace between semicolon and property-name
    $css = preg_replace('/;[\s\r\n\t]*?([\r\n]?[^\s\r\n\t])/ims', ';$1', $css);
    // remove any whitespace surrounding property-colon
    $css = preg_replace('/[\s\r\n\t]*:[\s\r\n\t]*?([^\s\r\n\t])/ims', ':$1', $css);
    // remove any whitespace surrounding selector-comma
    $css = preg_replace('/[\s\r\n\t]*,[\s\r\n\t]*?([^\s\r\n\t])/ims', ',$1', $css);
    // remove any whitespace surrounding opening parenthesis
    $css = preg_replace('/[\s\r\n\t]*{[\s\r\n\t]*?([^\s\r\n\t])/ims', '{$1', $css);
    // remove any whitespace between numbers and units
    $css = preg_replace('/([\d\.]+)[\s\r\n\t]+(px|em|pt|%)/ims', '$1$2', $css);
    // shorten zero-values
    $css = preg_replace('/([^\d\.]0)(px|em|pt|%)/ims', '$1', $css);
    // constrain multiple whitespaces
    $css = preg_replace('/\p{Zs}+/ims',' ', $css);
    // remove newlines
    $css = str_replace(array("\r\n", "\r", "\n"), '', $css);
    // Restore backupped values within single or double quotes
    for ($i=0; $i < count($hit[1]); $i++) {
        $css = str_replace('##########' . $i . '##########', $hit[1][$i], $css);
    }

    return $css;
}

function google_captcha_check($token){
    $captha_url = 'https://www.google.com/recaptcha/api/siteverify';
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL,$captha_url);
    curl_setopt($curl,CURLOPT_POST,1);
    curl_setopt($curl,CURLOPT_POSTFIELDS,http_build_query(array('secret' => get_static_option('site_google_captcha_v3_secret_key'),'response' => $token)));
    curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
    $response = curl_exec($curl);
    curl_close($curl);
    $result = json_decode($response,true);
    return $result;
}

function load_google_fonts()
{
    //google fonts link;
    $fonts_url = 'https://fonts.googleapis.com/css2?family=';
    //body fonts
    $body_font_family = get_static_option('body_font_family') ?? 'Open Sans';
    $heading_font_family = get_static_option('heading_font_family') ??  'Montserrat';



    $load_body_font_family = str_replace(' ', '+', $body_font_family);
    $body_font_variant = get_static_option('body_font_variant');
    $body_font_variant_selected_arr = !empty($body_font_variant) ? unserialize($body_font_variant,['class' => false]) : ['400'];
    $load_body_font_variant = is_array($body_font_variant_selected_arr) ? implode(';', $body_font_variant_selected_arr) : '400';

    $body_italic = '';
    preg_match('/1,/',$load_body_font_variant,$match);
    if(count($match) > 0){
        $body_italic =  'ital,';
    }else{
        $load_body_font_variant = str_replace('0,','',$load_body_font_variant);
    }

    $fonts_url .= $load_body_font_family . ':'.$body_italic.'wght@' . $load_body_font_variant;
    $load_heading_font_family = str_replace(' ', '+', $heading_font_family);
    $heading_font_variant = get_static_option('heading_font_variant');
    $heading_font_variant_selected_arr = !empty($heading_font_variant) ? unserialize($heading_font_variant,['class' => false]) : ['400'];
    $load_heading_font_variant = is_array($heading_font_variant_selected_arr) ? implode(';', $heading_font_variant_selected_arr) : '400';

    if (!empty(get_static_option('heading_font')) && $heading_font_family != $body_font_family) {

        $heading_italic = '';
        preg_match('/1,/',$load_heading_font_variant,$match);
        if(count($match) > 0){
            $heading_italic =  'ital,';
        }else{
            $load_heading_font_variant = str_replace('0,','',$load_heading_font_variant);
        }

        $fonts_url .= '&family=' . $load_heading_font_family . ':'.$heading_italic.'wght@' . $load_heading_font_variant;
    }

    return sprintf('<link rel="preconnect" href="https://fonts.gstatic.com"> <link href="%1$s&display=swap" rel="stylesheet">', $fonts_url);
}

function get_language_by_slug($slug){
    $lang_details = \App\Language::where('slug',$slug)->first();
    return !empty($lang_details) ? $lang_details->name : '';
}

function get_default_language(){
    $defaultLang =  Language::where('default',1)->first();
    return $defaultLang->slug;
}

function get_all_language(){
    $all_lang =  Language::orderBy('default','DESC')->get();
    return $all_lang;
}
function get_user_lang(){
    $default = Language::where('default',1)->first();
    return !empty(session()->get('lang'))
    ? session()->get('lang') : $default->slug;
}


function render_image_markup_by_attachment_id($id, $class = null, $size = 'full')
{
    if (empty($id)) return '';
    $output = '';

    $image_details = get_attachment_image_by_id($id, $size);
    if (!empty($image_details)) {
        $class_list = !empty($class) ? 'class="' . $class . '"' : '';
        $image_alt = $image_details['img_alt'] ?? $image_details['title'];
        $output = '<img src="' . $image_details['img_url'] . '" ' . $class_list . ' alt="' . $image_alt . '"/>';
    }
    return $output;
}
function render_image_src_by_attachment_id($id, $class = null, $size = 'full')
{
    if (empty($id)) return '';
    $output = '';

    $image_details = get_attachment_image_by_id($id, $size);
    if (!empty($image_details)) {
        $class_list = !empty($class) ? 'class="' . $class . '"' : '';
        $image_alt = $image_details['img_alt'] ?? '';
        $output = $image_details['img_url'];
    }
    return $output;
}

function render_image_alt_by_attachment_id($id, $class = null, $size = 'full')
{
    if (empty($id)) return '';
    $output = '';

    $image_details = get_attachment_image_by_id($id, $size);
    if (!empty($image_details)) {
        $output = $image_details['img_alt'] ?? $image_details['title'];
    }
    return $output;
}



function get_attachment_image_by_id($id, $size = null, $default = false): array
{
    $image_details = MediaUpload::find($id);
    $return_val = [];
    $image_url = '';

    if (!empty($id) && !empty($image_details)) {
        switch ($size) {
            case "large":
                if (file_exists('assets/uploads/media-uploader/large-' . $image_details->path)) {
                    $image_url = asset('assets/uploads/media-uploader/large-' . $image_details->path);
                }
                break;
            case "grid":
                if (file_exists('assets/uploads/media-uploader/grid-' . $image_details->path)) {
                    $image_url = asset('assets/uploads/media-uploader/grid-' . $image_details->path);
                }
                break;
            case "thumb":
                if (file_exists('assets/uploads/media-uploader/thumb-' . $image_details->path)) {
                    $image_url = asset('assets/uploads/media-uploader/thumb-' . $image_details->path);
                }
                break;
            default:
                if (is_numeric($id) && file_exists('assets/uploads/media-uploader/' . $image_details->path)) {
                    $image_url = asset('assets/uploads/media-uploader/' . $image_details->path);
                }
                break;
        }
    }

    if (!empty($image_details)) {
        $return_val['image_id'] = $image_details->id;
        $return_val['path'] = $image_details->path;
        $return_val['title'] = $image_details->title;
        $return_val['img_url'] = $image_url;
        $return_val['img_alt'] = $image_details->alt;
    } elseif (empty($image_details) && $default) {
        $return_val['img_url'] = asset('assets/uploads/no-image.png');
    }

    return $return_val;
}

function render_favicon_by_id($id)
{
    $site_favicon = get_attachment_image_by_id($id, "full", false);
    $output = '';
    if (!empty($site_favicon)) {
        $output .= '<link rel="icon" href="' . $site_favicon['img_url'] . '" type="image/png">';
    }
    return $output;
}

function render_footer_copyright_text()
{
    $footer_copyright_text = get_static_option('site_' . get_user_lang() . '_footer_copyright');
    $footer_copyright_text = str_replace('{copy}', '&copy;', $footer_copyright_text);
    $footer_copyright_text = str_replace('{year}', date('Y'), $footer_copyright_text);

    return $footer_copyright_text;
}

function setEnvValue(array $values)
{
    $envFile = app()->environmentFilePath();
    $str = file_get_contents($envFile);

    if (count($values) > 0) {
        foreach ($values as $envKey => $envValue) {

            $str .= "\n"; // In case the searched variable is in the last line without \n
            $keyPosition = strpos($str, "{$envKey}=");
            $endOfLinePosition = strpos($str, "\n", $keyPosition);
            $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);

            // If key does not exist, add it
            if (!$keyPosition || !$endOfLinePosition || !$oldLine) {
                $str .= "{$envKey}={$envValue}\n";
            } else {
                $str = str_replace($oldLine, "{$envKey}={$envValue}", $str);
            }

        }
    }

    $str = substr($str, 0, -1);
    if (!file_put_contents($envFile, $str)) return false;
    return true;
}

function getJson($url)
{
    // cache files are created like cache/abcdef123456...
    $cacheFile = 'cache' . DIRECTORY_SEPARATOR . md5($url);

    if (file_exists($cacheFile)) {
        $fh = fopen($cacheFile, 'r');
        $cacheTime = trim(fgets($fh));

        // if data was cached recently, return cached data
        if ($cacheTime > strtotime('-60 minutes')) {
            return fread($fh);
        }

        // else delete cache file
        fclose($fh);
        unlink($cacheFile);
    }

    $json = file_get_contents($url);

    $fh = fopen($cacheFile, 'w');
    fwrite($fh, time() . "\n");
    fwrite($fh, $json);
    fclose($fh);

    return $json;
}

function render_attachment_preview($id, $class = null, $size = 'full')
{
    $output = '<div class="img-wrap">';
    $image_details = get_attachment_image_by_id($id, $size);
    if (!empty($image_details)) {
        $class_list = !empty($class) ? 'class="' . $class . '"' : '';
        $output .= '<div class="attachment-preview"><div class="thumbnail"><div class="centered">';
        $output .= '<img src="' . $image_details['img_url'] . '" ' . $class_list . ' alt=""/>';
        $output .= '</div></div></div>';
    }
    $output .= '</div>';
    return $output;
}

function render_background_image_markup_by_attachment_id($id, $size = 'full')
{
    if (empty($id)) return '';
    $output = '';

    $image_details = get_attachment_image_by_id($id, $size);
    if (!empty($image_details)) {
        $output = 'style="background-image: url(' . $image_details['img_url'] . ');"';
    }
    return $output;
}

function get_blog_category_by_id($id, $type = '')
{
    $return_val = __('uncategorized');
    $blog_post = \App\Blog::find($id);
    $blog_cat = \App\BlogCategory::find($blog_post->blog_categories_id);
    if (!empty($blog_cat)) {
        $return_val = $blog_cat->name;
        if ($type == 'link') {
            $return_val = '<a href="' . route('frontend.blog.category', ['id' => $blog_cat->id, 'any' => Str::slug($blog_cat->name)]) . '">' . $blog_cat->name . '</a>';
        }
    }

    return $return_val;
}

function render_admin_panel_widgets_list(){
    return \App\WidgetsBuilder\WidgetBuilderSetup::get_admin_panel_widgets();
}
function get_admin_sidebar_list(){
    return \App\WidgetsBuilder\WidgetBuilderSetup::get_admin_widget_sidebar_list();
}
function render_admin_saved_widgets($location){
    $output = '';
    $all_widgets = \App\Widgets::where(['widget_location' => $location])->orderBy('widget_order', 'ASC')->get();
    foreach ($all_widgets as $widget){
        $output .= \App\WidgetsBuilder\WidgetBuilderSetup::render_widgets_by_name_for_admin([
            'name' => $widget->widget_name,
            'id' => $widget->id,
            'type' => 'update',
            'order' =>$widget->widget_order,
            'location' => $widget->widget_location
        ]);
    }

    return $output;
}
function render_frontend_sidebar($location,$args = []){
    $output = '';
    $all_widgets = \App\Widgets::where(['widget_location' => $location])->orderBy('widget_order', 'ASC')->get();
    foreach ($all_widgets as $widget){
        $output .= \App\WidgetsBuilder\WidgetBuilderSetup::render_widgets_by_name_for_frontend([
            'name' => $widget->widget_name,
            'location' => $location,
            'id' => $widget->id,
            'column' => $args['column'] ?? false
        ]);
    }
    return $output;
}

function render_menu_by_id($id)
{
    $default_lang = get_user_lang();
    $mega_menu_enable = '';

    if (empty($id)) {
        //load default home page if menu is empty
        return '<li><a href="' . url('/') . '">' . __('Home') . '</a></li>';
    }
    $output = '';
    $menu_details_from_db = \App\Menu::find($id);


    $menu_content = json_decode($menu_details_from_db->content);
    if (empty($menu_content)) {
        //load default home page if menu is empty
        return '<li><a href="' . url('/') . '">' . __('Home') . '</a></li>';
    }
    foreach ($menu_content as $menu_item) {
        $li_class = '';
        //set li class if page is current page

        $mega_menu_ids = [];
        if (property_exists($menu_item, 'items_id')) {
            $mega_menu_ids = explode(',', $menu_item->items_id);
        }


        if ($menu_item->ptype == 'static') {
            $menu_title = get_static_option($menu_item->pname);
            $menu_slug = url('/') . '/' . get_static_option($menu_item->pslug);
            $li_class .= (request()->path() == get_static_option($menu_item->pslug)) ? ' current-menu-item ' : '';
            //append login register

        } elseif ($menu_item->ptype == 'dynamic') {
            $menu_title = '';
            $menu_slug = '';
            $page_details = \App\Page::find($menu_item->pid);
            if (!empty($page_details)) {
                $menu_title = $page_details->title;
                $menu_slug = route('frontend.dynamic.page',  ['id' => $page_details->id, 'any' => $page_details->slug ? $page_details->slug : Str::slug($page_details->title)]);
                $li_class .= (request()->is(route('frontend.dynamic.page', ['id' => $page_details->id, 'any' => $page_details->slug ? $page_details->slug : Str::slug($page_details->title)]))) ? ' current-menu-item ' : '';
            }

        } elseif ($menu_item->ptype == 'custom') {
            $menu_title = __($menu_item->pname);
            $menu_slug = str_replace('@url', url('/'), $menu_item->purl);
            $li_class .= (request()->is($menu_slug)) ? ' current-menu-item ' : '';
        } elseif ($menu_item->ptype == 'service' || $menu_item->ptype == 'event' || $menu_item->ptype == 'work' || $menu_item->ptype == 'blog' || $menu_item->ptype == 'job' || $menu_item->ptype == 'knowledgebase' || $menu_item->ptype == 'product' || $menu_item->ptype == 'donation' || $menu_item->ptype == 'gig') {

            if ($menu_item->ptype == 'service') {
                $menu_title = '';
                $menu_slug = '';

                $page_details = \App\Services::find($menu_item->pid);
                if (!empty($page_details)) {
                    $menu_title = $page_details->title;
                    $menu_slug = route('frontend.services.single',['id'=>$page_details->id,'any'=>\Str::slug($page_details->slug)]);
                    $li_class .= (request()->is(route('frontend.services.single',['id'=>$page_details->id,'any'=>\Str::slug($page_details->slug)]))) ? ' current-menu-item ' : '';
                }


            } elseif ($menu_item->ptype == 'work') {
                $menu_title = '';
                $menu_slug = '';
                $page_details = Works::find($menu_item->pid);
                if (!empty($page_details)) {
                    $menu_title = $page_details->title;
                    $menu_slug = route('frontend.work.single',['id'=>$page_details->id,'any'=>\Str::slug($page_details->slug)]);
                    $li_class .= (request()->is(route('frontend.work.single',['id'=>$page_details->id,'any'=>\Str::slug($page_details->slug)]))) ? ' current-menu-item ' : '';
                }


            } elseif ($menu_item->ptype == 'blog') {
                $menu_title = '';
                $menu_slug = '';
                $page_details = \App\Blog::find($menu_item->pid);
                if (!empty($page_details)) {
                    $menu_title = $page_details->title;
                    $menu_slug = route('frontend.blog.single',['id'=>$page_details->id,'any'=> \Str::slug($page_details->slug)]);
                    $li_class .= (request()->is(route('frontend.blog.single',['id'=>$page_details->id,'any'=>\Str::slug($page_details->slug)]))) ? ' current-menu-item ' : '';
                }
            }
        }

        $li_class .= property_exists($menu_item, 'children') ? ' menu-item-has-children ' : '';
        $li_class .= property_exists($menu_item, 'items_id') ? ' menu-item-has-mega-menu ' : '';

        $indent_line = "\n";
        $indent_tab = "\t";
        //append class for account nav item
        if ($menu_item->ptype == 'static') {
            if (preg_match('/account/', $menu_item->pname)) {
                $li_class .= ' menu-item-has-children ';
            };
        }

        $li_class_markup = !empty($li_class) ? 'class="' . $li_class . '"' : '';
        //set li class if it has submenu
        $icon_value = property_exists($menu_item, 'icon') ? '<i class="' . $menu_item->icon . '"></i>' : '';

        if (!empty($menu_slug) && !empty($menu_title)) {//start condition

            $output .= $indent_tab . '<li ' . $li_class_markup . '>' . $indent_line;
            $output .= $indent_tab . '<a href="' . $menu_slug . '">' . $icon_value . ' ' . $menu_title . '</a>' . $indent_line;

            $user_select_lang_slug = get_user_lang();

            //check it has submenu
            if (property_exists($menu_item, 'children')) {
                $output .= render_submenu_children($menu_item->children);
            }
            //load li end tag
            $output .= $indent_tab . '</li>' . $indent_line;
        }// end condition
    }

    return $output;
}


/* render submenu */

function render_submenu_children($menu_children)
{
    $indent_line = "\n";
    $indent_tab = "\t";

    $output = $indent_tab . '<ul class="sub-menu">' . $indent_line;
    foreach ($menu_children as $menu_item) {

        $li_class = '';
        //set li class if page is current page

        if ($menu_item->ptype == 'static') {
            $menu_title = get_static_option($menu_item->pname);
            $menu_slug = url('/') . '/' . get_static_option($menu_item->pslug);
            $li_class .= (request()->path() == get_static_option($menu_item->pslug)) ? ' current-menu-item ' : '';
        } elseif ($menu_item->ptype == 'dynamic') {
            $page_details = \App\Page::find($menu_item->pid);
            $menu_title = !empty($page_details) ? $page_details->title : '';
            $menu_slug = !empty($page_details) ? route('frontend.dynamic.page', ['id' => $page_details->id, 'any' => $page_details->slug ? $page_details->slug : Str::slug($page_details->title)]) : '';
            if (!empty($page_details)) {
                $li_class .= (request()->is(route('frontend.dynamic.page',  ['id' => $page_details->id, 'any' => $page_details->slug ? $page_details->slug : Str::slug($page_details->title)]))) ? ' current-menu-item ' : '';
            }
        } elseif ($menu_item->ptype == 'custom') {
            $menu_title = __($menu_item->pname);
            $menu_slug = str_replace('@url', url('/'), $menu_item->purl);
            $li_class .= (request()->is($menu_slug)) ? ' current-menu-item ' : '';
        } elseif ($menu_item->ptype == 'service' || $menu_item->ptype == 'event' || $menu_item->ptype == 'work' || $menu_item->ptype == 'blog' ) {

            if ($menu_item->ptype == 'service') {

                $page_details = \App\Services::find($menu_item->pid);
                $menu_title = !empty($page_details) ? $page_details->title : '';
                $menu_slug = !empty($page_details) ? route('frontend.services.single', $page_details->slug) : '';
                $li_class .= !empty($page_details) && (request()->is(route('frontend.services.single', $page_details->slug))) ? ' current-menu-item ' : '';

            } elseif ($menu_item->ptype == 'work') {

                $page_details = Works::find($menu_item->pid);
                $menu_title = !empty($page_details) ? $page_details->title : '';
                $menu_slug = !empty($page_details) ? route('frontend.work.single', $page_details->slug) : '';
                $li_class .= !empty($page_details) && (request()->is(route('frontend.work.single', $page_details->slug))) ? ' current-menu-item ' : '';

            } elseif ($menu_item->ptype == 'blog') {

                $page_details = \App\Blog::find($menu_item->pid);
                $menu_title = !empty($page_details) ? $page_details->title : '';
                $menu_slug = !empty($page_details) ? route('frontend.blog.single', $page_details->slug) : '';
                $li_class .= !empty($page_details) && (request()->is(route('frontend.blog.single', $page_details->slug))) ? ' current-menu-item ' : '';

            }
        }


        $li_class .= property_exists($menu_item, 'children') ? ' menu-item-has-children ' : '';

        $indent_line = "\n";
        $indent_tab = "\t";

        $li_class_markup = !empty($li_class) ? 'class="' . $li_class . '"' : '';
        //set li class if it has submenu
        $icon_value = property_exists($menu_item, 'icon') ? '<i class="' . $menu_item->icon . '"></i>' : '';
        if (!empty($menu_slug) && !empty($menu_title)) {
            $output .= $indent_tab . '<li ' . $li_class_markup . '>' . $indent_line;
            $output .= $indent_tab . '<a href="' . $menu_slug . '">' . $icon_value . $menu_title . '</a>' . $indent_line;
        }
        //check it has submenu
        if (property_exists($menu_item, 'children')) {
            $output .= render_submenu_children($menu_item->children);
        }
        //load li end tag
        $output .= $indent_tab . '</li>' . $indent_line;
    }
    $output .= $indent_tab . '</ul>' . $indent_line;
    return $output;
}

/* render menu for drag & drop menu in admin panel */
function render_draggable_menu_by_id($id)
{
    $default_lang = get_default_language();

    $mega_menu_enable = '';
    $mega_menu_items = '';
    $output = '';
    $menu_details_from_db = \App\Menu::find($id);
    $default_lang = !empty($menu_details_from_db) ? $menu_details_from_db->lang : $default_lang;

    $menu_data = json_decode($menu_details_from_db->content);

    $page_id = 0;
    foreach ($menu_data as $menu):
        $page_id++;

         $menu_title = '';
         $menu_attr = 'data-ptype="' . $menu->ptype . '" ';

        if ($menu->ptype == 'static') {
            $menu_attr .= ' data-pname="' . $menu->pname . '"';
            $menu_attr .= ' data-pslug="' . $menu->pslug . '"';
            $menu_title = get_static_option($menu->pname);

        } elseif ($menu->ptype == 'dynamic') {

            $menu_attr .= ' data-pid="' . $menu->pid . '"';
            $menu_details = \App\Page::find($menu->pid);
            $menu_title = !empty($menu_details) ? $menu_details->title : '';

        } elseif ($menu->ptype == 'custom') {
            $menu_attr .= ' data-purl="' . $menu->purl . '"';
            $menu_attr .= ' data-pname="' . $menu->pname . '"';
            $menu_title = $menu->pname;
        } elseif ($menu->ptype == 'service' || $menu->ptype == 'work' || $menu->ptype == 'blog') {
            $menu_attr .= ' data-pid="' . $menu->pid . '"';

            if ($menu->ptype == 'service') {
                $menu_details = \App\Services::find($menu->pid);
                $menu_title = !empty($menu_details) ? $menu_details->title : '';
            }elseif ($menu->ptype == 'work') {
                $menu_details = \App\Works::find($menu->pid);
                $menu_title = !empty($menu_details) ? $menu_details->title : '';
            } elseif ($menu->ptype == 'blog') {
                $menu_details = \App\Blog::find($menu->pid);
                $menu_title = !empty($menu_details) ? $menu_details->title : '';
            }

        }

        $mega_menu_ids = [];
        if (property_exists($menu, 'items_id')) {
            $mega_menu_ids = explode(',', $menu->items_id);
            $menu_attr .= ' data-items_id="' . $menu->items_id . '" ';
        }

        $icon_value = property_exists($menu, 'icon') ? 'value="' . $menu->icon . '"' : '';
        $icon_data = property_exists($menu, 'icon') ? 'data-icon="' . $menu->icon . '"' : '';

        $indent_line = "\n";
        $indent_tab = "\t";

        if (!empty($menu_title)) {
            $output .= '<li class="dd-item" data-id="' . $page_id . '" ' . $menu_attr . ' ' . $icon_data . '>' . $indent_line;
            $output .= $indent_tab . '<div class="dd-handle">' . $menu_title . '</div>' . $indent_line;
            $output .= $indent_tab . '<span class="remove_item">x</span>' . $indent_line;
            $output .= $indent_tab . '<span class="expand"><i class="ti-angle-down"></i></span>' . $indent_line;
            $output .= $indent_tab . '<div class="dd-body hide">';
        }


            if (!empty($menu_title)) {
                $output .= '<input type="text" class="icon_picker" placeholder="eg: fas-fa-facebook" ' . $icon_value . '/>';
            }

        if (!empty($menu_title)) {
            $output .= '</div>' . $indent_line;
        }

        //check it has children or not
        if (property_exists($menu, 'children')) {
            $output .= render_draggable_menu_children($menu->children, $page_id);
        }
        $output .= '</li>' . $indent_line;

    endforeach;
    return $output;
}



/* render submenu of menu for drag & drop menu in admin panel */
function render_draggable_menu_children($children, $page_id)
{
    $indent_line = "\n";
    $indent_tab = "\t";

    $output = $indent_tab . '<ol class="dd-list">' . $indent_line;
    foreach ($children as $item) {
        $page_id++;
        $menu_title = '';
        $menu_attr = 'data-ptype="' . $item->ptype . '" ';

        if ($item->ptype == 'static') {

            $menu_attr .= ' data-pname="' . $item->pname . '"';
            $menu_attr .= ' data-pslug="' . $item->pslug . '"';
            $menu_title = get_static_option($item->pname);

        } elseif ($item->ptype == 'dynamic') {

            $menu_attr .= ' data-pid="' . $item->pid . '"';
            $menu_details = \App\Page::find($item->pid);
            $menu_title = !empty($menu_details) ? $menu_details->title : '';

        } elseif ($item->ptype == 'custom') {
            $menu_attr .= ' data-purl="' . $item->purl . '"';
            $menu_attr .= ' data-pname="' . $item->pname . '"';
            $menu_title = $item->pname;
        } elseif ($item->ptype == 'service' || $item->ptype == 'work' || $item->ptype == 'blog') {
            $menu_attr .= ' data-pid="' . $item->pid . '"';

            if ($item->ptype == 'service') {
                $menu_details = \App\Services::find($item->pid);
                $menu_title = !empty($menu_details) ? $menu_details->title : '';
            } elseif ($item->ptype == 'work') {
                $menu_details = \App\Works::find($item->pid);
                $menu_title = !empty($menu_details) ? $menu_details->title : '';
            } elseif ($item->ptype == 'blog') {
                $menu_details = \App\Blog::find($item->pid);
                $menu_title = !empty($menu_details) ? $menu_details->title : '';
            }
        }
        $icon_value = property_exists($item, 'icon') ? 'value="' . $item->icon . '"' : '';
        $icon_data = property_exists($item, 'icon') ? 'data-icon="' . $item->icon . '"' : '';
        if (!empty($menu_title)) {
            $output .= $indent_tab . $indent_tab . '<li class="dd-item" data-id="' . $page_id . '" ' . $menu_attr . ' ' . $icon_data . '>' . $indent_line;
            $output .= $indent_tab . $indent_tab . $indent_tab . '<div class="dd-handle">' . $menu_title . '</div>' . $indent_line;
            $output .= $indent_tab . $indent_tab . $indent_tab . '<span class="remove_item">x</span>' . $indent_line;
            $output .= $indent_tab . '<span class="expand"><i class="ti-angle-down"></i></span>' . $indent_line;
            $output .= $indent_tab . '<div class="dd-body hide"><input type="text" class="icon_picker" placeholder="eg: fas-fa-facebook" ' . $icon_value . '/></div>' . $indent_line;
        }

        if (property_exists($item, 'children')) {
            $output .= render_draggable_menu_children($item->children, $page_id);
        }
        if (!empty($menu_title)) {
            $output .= $indent_tab . $indent_tab . '</li>' . $indent_line;
        }
    }
    $output .= $indent_tab . '</ol>' . $indent_line;
    return $output;
}


function render_form_field_for_frontend($form_content)
{
    if (empty($form_content)) {
        return;
    }
    $output = '';
    $form_fields = json_decode($form_content);
    $select_index = 0;
    $options = [];

    foreach ($form_fields->field_type as $key => $value) {
        if (!empty($value)) {
            if ($value == 'select') {
                $options = explode("\n", $form_fields->select_options[$select_index]);
            }
            $required = isset($form_fields->field_required->$key) ? $form_fields->field_required->$key : '';
            $mimes = isset($form_fields->mimes_type->$key) ? $form_fields->mimes_type->$key : '';
            $output .= get_field_by_type($value, $form_fields->field_name[$key], $form_fields->field_placeholder[$key], $options, $required, $mimes);
            if ($value == 'select') {
                $select_index++;
            };
        }
    }

    return $output;
}
function render_form_contact_us_field_for_frontend($form_content)
{
    if (empty($form_content)) {
        return;
    }
    $output = '';
    $form_fields = json_decode($form_content);
    $select_index = 0;
    $options = [];

    foreach ($form_fields->field_type as $key => $value) {
        if (!empty($value)) {
            if ($value == 'select') {
                $options = explode("\n", $form_fields->select_options[$select_index]);
            }
            $required = isset($form_fields->field_required->$key) ? $form_fields->field_required->$key : '';
            $mimes = isset($form_fields->mimes_type->$key) ? $form_fields->mimes_type->$key : '';
            $output .= get_field_contact_us_by_type($value, $form_fields->field_name[$key], $form_fields->field_placeholder[$key], $options, $required, $mimes);
            if ($value == 'select') {
                $select_index++;
            };
        }
    }

    return $output;
}

function render_payment_gateway_for_form($cash_on_delivery = false)
{
    $output = '<div class="payment-gateway-wrapper">';
    if (empty(get_static_option('site_payment_gateway'))) {
        return;
    }

    $output .= '<input type="hidden" name="selected_payment_gateway" value="' . get_static_option('site_default_payment_gateway') . '">';
    $all_gateway = [
        'paypal', 'manual_payment', 'mollie', 'paytm', 'stripe', 'razorpay', 'flutterwave', 'paystack','midtrans','payfast','cashfree','instamojo','marcadopago'
    ];
    $output .= '<ul>';
    if ($cash_on_delivery) {
        $output .= '<li data-gateway="cash_on_delivery" ><div class="img-select">';
        $output .= render_image_markup_by_attachment_id(get_static_option('cash_on_delivery_preview_logo'));
        $output .= '</div></li>';
    }

    foreach ($all_gateway as $gateway) {
        if (!empty(get_static_option($gateway . '_gateway'))):
            $class = (get_static_option('site_default_payment_gateway') == $gateway) ? 'class="selected"' : '';

            $output .= '<li data-gateway="' . $gateway . '" ' . $class . '><div class="img-select">';
            $output .= render_image_markup_by_attachment_id(get_static_option($gateway . '_preview_logo'));
            $output .= '</div></li>';
        endif;
    }
    $output .= '</ul>';

    $output .= '</div>';
    return $output;
}

  function amount_with_currency_symbol($amount, $text = false)
  {
      $position = get_static_option('site_currency_symbol_position');
      $symbol = site_currency_symbol($text);
      $return_val = $symbol . $amount;
      if ($position == 'right') {
          $return_val = $amount . $symbol;
      }
      return $return_val;
  }

  function site_currency_symbol($text = false)
  {
      $all_currency = script_currency_list();

      $symbol = '$';
      $global_currency = get_static_option('site_global_currency');
      foreach ($all_currency as $currency => $sym) {
          if ($global_currency == $currency) {
              $symbol = $text ? $currency : $sym;
              break;
          }
      }
      return $symbol;
  }

  function script_currency_list(){
      return \App\PaymentGateway\GlobalCurrency::script_currency_list();
  }

  function check_page_permission($page)
{
    return true;
    if (Auth::check()) {
        $id = auth()->user()->id;
        $role_id = \App\Admin::where('id', $id)->first();
        $user_role = \App\AdminRole::where('id', $role_id->role)->first();
        $all_permission = json_decode($user_role->permission);
        if (in_array($page, $all_permission)) {
            return true;
        }
    }
    return false;
}



function render_drag_drop_form_builder_markup($content = '')
{
    $output = '';

    $form_fields = json_decode($content);
    $output .= '<ul id="sortable" class="available-form-field main-fields">';
    if (!empty($form_fields)) {
        $select_index = 0;
        foreach ($form_fields->field_type as $key => $ftype) {
            $args = [];
            $required_field = '';
            if (property_exists($form_fields, 'field_required')) {
                $filed_requirement = (array)$form_fields->field_required;
                $required_field = !empty($filed_requirement[$key]) ? 'on' : '';
            }
            if ($ftype == 'select') {
                $args['select_option'] = isset($form_fields->select_options[$select_index]) ? $form_fields->select_options[$select_index] : '';
                $select_index++;
            }
            if ($ftype == 'file') {
                $args['mimes_type'] = isset($form_fields->mimes_type->$key) ? $form_fields->mimes_type->$key : '';
            }
            $output .= render_drag_drop_form_builder_field_markup($key, $ftype, $form_fields->field_name[$key], $form_fields->field_placeholder[$key], $required_field, $args);
        }
    } else {
        $output .= render_drag_drop_form_builder_field_markup('1', 'text', 'your-name', 'Your Name', '');
    }

    $output .= '</ul>';
    return $output;
}

function render_drag_drop_form_builder_field_markup($key, $type, $name, $placeholder, $required, $args = [])
{
    $required_check = !empty($required) ? 'checked' : '';
    $output = '<li class="ui-state-default">
                     <span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
                    <span class="remove-fields">x</span>
                    <a data-toggle="collapse" href="#fileds_collapse_' . $key . '" role="button"
                       aria-expanded="false" aria-controls="collapseExample">
                        ' . ucfirst($type) . ': <span
                                class="placeholder-name">' . $placeholder . '</span>
                    </a>';
    $output .= '<div class="collapse" id="fileds_collapse_' . $key . '">
            <div class="card card-body margin-top-30">
                <input type="hidden" class="form-control" name="field_type[]"
                       value="' . $type . '">
                <div class="form-group">
                    <label>' . __('Name') . '</label>
                    <input type="text" class="form-control " name="field_name[]"
                           placeholder="' . __('enter field name') . '"
                           value="' . $name . '" >
                </div>
                <div class="form-group">
                    <label>' . __('Placeholder/Label') . '</label>
                    <input type="text" class="form-control field-placeholder"
                           name="field_placeholder[]" placeholder="' . __('enter field placeholder/label') . '"
                           value="' . $placeholder . '" >
                </div>
                <div class="form-group">
                    <label ><strong>' . __('Required') . '</strong></label>
                    <label class="switch">
                        <input type="checkbox" class="field-required" ' . $required_check . ' name="field_required[' . $key . ']">
                        <span class="slider onff"></span>
                    </label>
                </div>';
    if ($type == 'select') {
        $output .= '<div class="form-group">
                        <label>' . __('Options') . '</label>
                            <textarea name="select_options[]" class="form-control max-height-120" cols="30" rows="10"
                                required>' . $args['select_option'] . '</textarea>
                           <small>' . __('separate option by new line') . '</small>
                    </div>';
    }
    if ($type == 'file') {
        $output .= '<div class="form-group"><label>' . __('File Type') . '</label><select name="mimes_type[' . $key . ']" class="form-control mime-type">';
        $output .= '<option value="mimes:jpg,jpeg,png"';
        if (isset($args['mimes_type']) && $args['mimes_type'] == 'mimes:jpg,jpeg,png') {
            $output .= "selected";
        }
        $output .= '>' . __('mimes:jpg,jpeg,png') . '</option>';

        $output .= '<option value="mimes:txt,pdf"';
        if (isset($args['mimes_type']) && $args['mimes_type'] == 'mimes:txt,pdf') {
            $output .= "selected";
        }
        $output .= '>' . __('mimes:txt,pdf') . '</option>';

        $output .= '<option value="mimes:doc,docx"';
        if (isset($args['mimes_type']) && $args['mimes_type'] == 'mimes:doc,docx') {
            $output .= "selected";
        }
        $output .= '>' . __('mimes:doc,docx') . '</option>';
        $output .= '<option value="mimes:zip"';
        if (isset($args['mimes_type']) && $args['mimes_type'] == 'mimes:zip') {
            $output .= "selected";
        }
        $output .= '>' . __('mimes:zip') . '</option>';

        $output .= '</select></div>';
    }
    $output .= '</div></div></li>';

    return $output;
}


function get_field_by_type($type, $name, $placeholder, $options = [], $requried = null, $mimes = null)
{
    $markup = '';
    $required_markup_html = 'required="required"';
    switch ($type) {
        case('email'):
            $required_markup = !empty($requried) ? $required_markup_html : '';
            $markup = ' <div class="form-group"> <input type="email" id="' . $name . '" name="' . $name . '" class="form-control" placeholder="' . __($placeholder) . '" ' . $required_markup . '></div>';
            break;
        case('tel'):
            $required_markup = !empty($requried) ? $required_markup_html : '';
            $markup = ' <div class="form-group"> <input type="tel" id="' . $name . '" name="' . $name . '" class="form-control" placeholder="' . __($placeholder) . '" ' . $required_markup . '></div>';
            break;
        case('url'):
            $required_markup = !empty($requried) ? $required_markup_html : '';
            $markup = ' <div class="form-group"> <input type="url" id="' . $name . '" name="' . $name . '" class="form-control" placeholder="' . __($placeholder) . '" ' . $required_markup . '></div>';
            break;
        case('textarea'):
            $required_markup = !empty($requried) ? $required_markup_html : '';
            $markup = ' <div class="form-group textarea"><textarea name="' . $name . '" id="' . $name . '" cols="30" rows="10" class="form-control" placeholder="' . __($placeholder) . '" ' . $required_markup . '></textarea></div>';
            break;
        case('file'):
            $required_markup = !empty($requried) ? $required_markup_html : '';
            $mimes_type_markup = str_replace('mimes:', __('Accept File Type:') . ' ', $mimes);
            $markup = ' <div class="form-group file"> <label for="' . $name . '">' . $placeholder . '</label> <input type="file" id="' . $name . '" name="' . $name . '" ' . $required_markup . ' class="form-control" > <span class="help-info">' . $mimes_type_markup . '</span></div>';
            break;
        case('checkbox'):
            $required_markup = !empty($requried) ? $required_markup_html : '';
            $markup = ' <div class="form-group checkbox">  <input type="checkbox" id="' . $name . '" name="' . $name . '" class="form-control" ' . $required_markup . '> <label for="' . $name . '">' . __($placeholder) . '</label></div>';
            break;
        case('select'):
            $option_markup = '';
            $required_markup = !empty($requried) ? $required_markup_html : '';
            foreach ($options as $opt) {
                $option_markup .= '<option value="' . Str::slug($opt) . '">' . $opt . '</option>';
            }
            $markup = ' <div class="form-group select"> <label for="' . $name . '">' . __($placeholder) . '</label> <select id="' . $name . '" name="' . $name . '" class="form-control" ' . $required_markup . '>' . $option_markup . '</select></div>';
            break;
        default:
            $required_markup = !empty($requried) ? $required_markup_html : '';
            $markup = ' <div class="form-group"> <input type="text" id="' . $name . '" name="' . $name . '" class="form-control" placeholder="' . __($placeholder) . '" ' . $required_markup . '></div>';
            break;
    }

    return $markup;
}

function get_field_contact_us_by_type($type, $name, $placeholder, $options = [], $requried = null, $mimes = null)
{
    $markup = '';
    $required_markup_html = 'required="required"';
    switch ($type) {
        case('email'):
            $required_markup = !empty($requried) ? $required_markup_html : '';
            $markup = ' <div class="col-12 col-md-6"><div class="form-group"> <label>' . $name . '</label><input type="email" id="' . $name . '" name="' . $name . '" class="form-control" placeholder="' . __($placeholder) . '" ' . $required_markup . '></div></div>';
            break;
        case('tel'):
            $required_markup = !empty($requried) ? $required_markup_html : '';
            $markup = ' <div class="col-12 col-md-6"><div class="form-group"> <label>' . $name . '</label><input type="tel" id="' . $name . '" name="' . $name . '" class="form-control" placeholder="' . __($placeholder) . '" ' . $required_markup . '></div></div>';
            break;
        case('url'):
            $required_markup = !empty($requried) ? $required_markup_html : '';
            $markup = ' <div class="col-12 col-md-6"><div class="form-group"> <label>' . $name . '</label><input type="url" id="' . $name . '" name="' . $name . '" class="form-control" placeholder="' . __($placeholder) . '" ' . $required_markup . '></div></div>';
            break;
        case('textarea'):
            $required_markup = !empty($requried) ? $required_markup_html : '';
            $markup = ' <div class="col-12 col-md-12"><div class="form-group textarea"><label>' . $name . '</label><textarea name="' . $name . '" id="' . $name . '" cols="30" rows="10" class="form-control" placeholder="' . __($placeholder) . '" ' . $required_markup . '></textarea></div></div>';
            break;
        case('file'):
            $required_markup = !empty($requried) ? $required_markup_html : '';
            $mimes_type_markup = str_replace('mimes:', __('Accept File Type:') . ' ', $mimes);
            $markup = ' <div class="col-12 col-md-6"><div class="form-group file"> <label for="' . $name . '">' . $placeholder . '</label> <input type="file" id="' . $name . '" name="' . $name . '" ' . $required_markup . ' class="form-control" > <span class="help-info">' . $mimes_type_markup . '</span></div></div>';
            break;
        case('checkbox'):
            $required_markup = !empty($requried) ? $required_markup_html : '';
            $markup = ' <div class="col-12 col-md-6"><div class="form-group checkbox">  <input type="checkbox" id="' . $name . '" name="' . $name . '" class="form-control" ' . $required_markup . '> <label for="' . $name . '">' . __($placeholder) . '</label></div></div>';
            break;
        case('select'):
            $option_markup = '';
            $required_markup = !empty($requried) ? $required_markup_html : '';
            foreach ($options as $opt) {
                $option_markup .= '<option value="' . Str::slug($opt) . '">' . $opt . '</option>';
            }
            $markup = ' <div class="col-12 col-md-6"><div class="form-group select"> <label for="' . $name . '">' . __($placeholder) . '</label> <select id="' . $name . '" name="' . $name . '" class="form-control" ' . $required_markup . '>' . $option_markup . '</select></div></div>';
            break;
        default:
            $required_markup = !empty($requried) ? $required_markup_html : '';
            if($name=='subject'){
                $markup = ' <div class="col-12 col-md-12"><div class="form-group"> <label>' . $name . '</label><input type="text" id="' . $name . '" name="' . $name . '" class="form-control" placeholder="' . __($placeholder) . '" ' . $required_markup . '></div></div>';
            } else {
                $markup = ' <div class="col-12 col-md-6"><div class="form-group"> <label>' . $name . '</label><input type="text" id="' . $name . '" name="' . $name . '" class="form-control" placeholder="' . __($placeholder) . '" ' . $required_markup . '></div></div>';
            }

            break;
    }

    return $markup;
}


function paypal_gateway(){
    return \App\PaymentGateway\PaymentGatewaySetup::paypal();
}
function paytm_gateway(){
    return \App\PaymentGateway\PaymentGatewaySetup::paytm();
}
function stripe_gateway(){
    return \App\PaymentGateway\PaymentGatewaySetup::stripe();
}
function paystack_gateway(){
    return \App\PaymentGateway\PaymentGatewaySetup::paystack();
}
function razorpay_gateway(){
    return \App\PaymentGateway\PaymentGatewaySetup::razorpay();
}
function flutterwaverave_gateway(){
    return \App\PaymentGateway\PaymentGatewaySetup::flutterwaverev();
}
function mollie_gateway(){
    return \App\PaymentGateway\PaymentGatewaySetup::mollie();
}

function custom_number_format($amount)
{
    return number_format((float)$amount, 2, '.', '');
}

function render_blog_author($author)
{
    return !empty($author) ? $author : __('Anonymous');
}

function render_og_meta_image_by_attachment_id($id, $size = 'full')
{
    if (empty($id)) return '';
    $output = '';

    $image_details = get_attachment_image_by_id($id, $size);
    if (!empty($image_details)) {
        $output = ' <meta property="og:image" content="' . $image_details['img_url'] . '" />';
    }
    return $output;
}

function check_currency_support_by_payment_gateway($gateway)
{
    $output = false;
    if ($gateway == 'paypal') {
        $output = is_paypal_supported_currency();
    } elseif ($gateway == 'paytm') {
        $output = is_paytm_supported_currency();
    } elseif ($gateway == 'mollie') {
        $output = is_mollie_supported_currency();
    } elseif ($gateway == 'stripe') {
        $output = true;
    } elseif ($gateway == 'razorpay') {
        $output = is_razorpay_supported_currency();
    } elseif ($gateway == 'flutterwave') {
        $output = is_flutterwave_supported_currency();
    } elseif ($gateway == 'paystack') {
        $output = is_paystack_supported_currency();
    } else {
        $output = true;
    }

    return $output;
}

function is_paypal_supported_currency()
{
    $global_currency = get_static_option('site_global_currency');
    $supported_currency = ['AUD', 'BRL', 'CAD', 'CNY', 'CZK', 'DKK', 'EUR', 'HKD', 'HUF', 'INR', 'ILS', 'JPY', 'MYR', 'MXN', 'TWD', 'NZD', 'NOK', 'PHP', 'PLN', 'GBP', 'RUB', 'SGD', 'SEK', 'CHF', 'THB', 'USD'];
    return (in_array($global_currency, $supported_currency)) ? true : false;
}

function is_paytm_supported_currency()
{
    $global_currency = get_static_option('site_global_currency');
    $supported_currency = ['INR'];
    return (in_array($global_currency, $supported_currency)) ? true : false;
}

function get_charge_currency($gateway)
{
    $output = 'USD';
    if ($gateway == 'paypal') {
        $output = 'USD';
    } elseif ($gateway == 'paytm') {
        $output = 'INR';
    } elseif ($gateway == 'mollie') {
        $output = 'USD';
    } elseif ($gateway == 'razorpay') {
        $output = 'INR';
    } elseif ($gateway == 'flutterwave') {
        $output = 'USD';
    } elseif ($gateway == 'paystack') {
        $output = 'NGN';
    }

    return $output;
}

function get_charge_amount($amount, $gateway)
{
    $output = 0;
    if ($gateway == 'paypal') {
        $output = get_amount_in_usd($amount, get_static_option('site_global_currency'));
    } elseif ($gateway == 'paytm') {
        $output = get_amount_in_inr($amount, get_static_option('site_global_currency'));
    } elseif ($gateway == 'mollie') {
        $output = get_amount_in_usd($amount, get_static_option('site_global_currency'));
    } elseif ($gateway == 'razorpay') {
        $output = get_amount_in_inr($amount, get_static_option('site_global_currency'));
    } elseif ($gateway == 'flutterwave') {
        $output = get_amount_in_usd($amount, get_static_option('site_global_currency'));
    } elseif ($gateway == 'paystack') {
        $output = get_amount_in_ngn($amount, get_static_option('site_global_currency'));
    }

    return $output;
}

function get_amount_in_inr($amount, $currency)
{
    $output = 0;
    $all_currency = script_currency_list();
    foreach ($all_currency as $cur => $symbol) {
        if ($cur == 'INR') {
            continue;
        }
        if ($cur == $currency) {
            $exchange_rate = get_static_option('site_' . strtolower($cur) . '_to_inr_exchange_rate');
            $output = $amount * $exchange_rate;
        }
    }

    return $output;
}

function is_mollie_supported_currency()
{
    $global_currency = get_static_option('site_global_currency');
    $supported_currency = ['AED', 'AUD', 'BGN', 'BRL', 'CAD', 'CHF', 'CZK', 'DKK', 'EUR', 'GBP', 'HKD', 'HRK', 'HUF', 'ILS', 'ISK', 'JPY', 'MXN', 'MYR', 'NOK', 'NZD', 'PHP', 'PLN', 'RON', 'RUB', 'SEK', 'SGD', 'THB', 'TWD', 'USD', 'ZAR'];
    return (in_array($global_currency, $supported_currency)) ? true : false;
}

function is_razorpay_supported_currency()
{
    $global_currency = get_static_option('site_global_currency');
    $supported_currency = ['INR'];
    return (in_array($global_currency, $supported_currency)) ? true : false;
}

function is_flutterwave_supported_currency()
{
    $global_currency = get_static_option('site_global_currency');
    $supported_currency = ['BIF', 'CAD', 'CDF', 'CVE', 'EUR', 'GBP', 'GHS', 'GMD', 'GNF', 'KES', 'LRD', 'MWK', 'MZN', 'NGN', 'RWF', 'SLL', 'STD', 'TZS', 'UGX', 'USD', 'XAF', 'XOF', 'ZMK', 'ZMW', 'ZWD'];
    return (in_array($global_currency, $supported_currency)) ? true : false;
}

function getVisIpAddr()
{

    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

function is_paystack_supported_currency()
{
    $global_currency = get_static_option('site_global_currency');
    $supported_currency = ['NGN', 'GHS'];
    return (in_array($global_currency, $supported_currency)) ? true : false;
}

function get_amount_in_ngn($amount, $currency)
{
    $output = 0;
    $all_currency = script_currency_list();
    foreach ($all_currency as $cur => $symbol) {
        if ($cur == 'NGN') {
            continue;
        }
        if ($cur == $currency) {
            $exchange_rate = get_static_option('site_' . strtolower($cur) . '_to_ngn_exchange_rate');
            $output = $amount * $exchange_rate;
        }
    }
    return $output;
}

function get_user_name_by_id($id)
{
    $user = \App\User::find($id);
    return $user;
}

function render_embed_google_map($address, $zoom = 10)
{
    if (empty($address)) {
        return;
    }
    printf(
        '<div class="elementor-custom-embed"><iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?q=%s&amp;t=m&amp;z=%d&amp;output=embed&amp;iwloc=near" aria-label="%s"></iframe></div>',
        rawurlencode($address),
        $zoom,
        $address
    );
}

function get_footer_copyright_text()
{
    $footer_copyright_text = get_static_option('site_' . get_user_lang() . '_footer_copyright');
    $footer_copyright_text = str_replace(array('{copy}', '{year}'), array('&copy;', date('Y')), $footer_copyright_text);
    return $footer_copyright_text;
}

function get_user_lang_direction()
{
    $default = Language::where('default', 1)->first();
    $user_direction = Language::where('slug', session()->get('lang'))->first();
    return !empty(session()->get('lang')) ? $user_direction->direction : $default->direction;
}

function get_default_language_direction(){
    $default_lang = Language::where('default',1)->first();
    return !empty($default_lang) ? $default_lang->direction : 'ltr';
}

function filter_static_option_value(string $index, array $array = [])
{
    return $array[$index] ?? '';
}

function get_service_category($id)
{
    $return_val = __("uncategorized");
    $category = \App\ServiceCategory::find($id);

    if (!empty($category)) {
        $return_val = $category->name;
    }

    return $return_val;
}

function render_attachment_gallery_preview($ids, $class = null, $size = 'full')
{
    $output = '<div class="img-wrap">';
    $gallery_images = !empty($ids) ? explode('|', $ids) : [];
    foreach ($gallery_images as $gal_image) {
        $image_details = get_attachment_image_by_id($gal_image, $size);
        if (!empty($image_details)) {
            $class_list = !empty($class) ? 'class="' . $class . '"' : '';
            $output .= '<div class="attachment-preview"><div class="thumbnail"><div class="centered">';
            $output .= '<img src="' . $image_details['img_url'] . '" ' . $class_list . ' alt=""/>';
            $output .= '</div></div></div>';
        }
    }

    $output .= '</div>';
    return $output;
}
