<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Order;
use App\PaymentLogs;
use App\ContactInfoItem;
use App\Faq;
use App\Language;
use App\Quote;
use App\Menu;
use App\Newsletter;
use App\Page;
use App\ServiceCategory;
use App\Services;
use App\Blog;
use App\BlogCategory;
use App\Brand;
use App\HeaderSlider;
use App\KeyFeatures;
use App\PricePlan;
use App\TdsRequest;
use App\TeamMember;
use App\User;
use App\Counterup;
use App\Testimonial;
use App\Works;
use App\WorksImage;
use App\WorksSubcategory;
use PDF;
use App\WorksCategory;
use App\WorksSectors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;
use App\Mail\UserResetEmail;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMessage;
use App\Mail\RequestQuote;
use App\Mail\BasicMailTemplate;
use Illuminate\Support\Facades\Storage; 
use App\Mail\MyTdsMail;


class FrontendController extends Controller
{

    public function index(){
        $lang = !empty(session()->get('lang')) ? session()->get('lang') : Language::where('default',1)->first()->slug;
        $all_header_slider = HeaderSlider::where('lang',$lang)->get();
        $all_counterup = Counterup::where('lang',$lang)->get();
        $all_key_features = KeyFeatures::where('lang',$lang)->get();
        // $all_service = Services::where('lang',$lang)->orderBy('id','desc')->take(get_static_option('home_page_01_service_area_items'))->get();

        if(get_user_lang()=='en'){
            $all_service = Services::where(['categories_id'=>'4'])->orderBy('id','desc')->take(get_static_option('home_page_01_service_area_items'))->get();
        } else {
            $all_service = Services::where([ 'categories_id'=>'20'])->orderBy('id','desc')->take(get_static_option('home_page_01_service_area_items'))->get();
        }

        $all_testimonial = Testimonial::where('lang',$lang)->get();
        $all_price_plan = PricePlan::where([ 'lang' => $lang])->orderBy('id','desc')->take(get_static_option('home_page_01_price_plan_section_items'))->get();;
        $all_team_members = TeamMember::where('lang',$lang)->orderBy('id','desc')->take(get_static_option('home_page_01_team_member_section_items'))->get();;
        $all_brand_logo = Brand::all();
        $all_work = Works::where('lang',$lang)->get();
        $all_work_category = WorksCategory::where(['status'=> 'publish', 'lang' => $lang])->get();
        $all_blog = Blog::where('lang',$lang)->orderBy('id','desc')->take(3)->get();

        return view('frontend.frontend-home')->with([
            'all_header_slider' => $all_header_slider,
            'all_counterup' => $all_counterup,
            'all_key_features' => $all_key_features,
            'all_service' => $all_service,
            'all_testimonial' => $all_testimonial,
            'all_blog' => $all_blog,
            'all_price_plan' => $all_price_plan,
            'all_team_members' => $all_team_members,
            'all_brand_logo' => $all_brand_logo,
            'all_work' => $all_work,
            'all_work_category' => $all_work_category
        ]);
    }
    
    public function home_page_change($id){

        $lang = !empty(session()->get('lang')) ? session()->get('lang') : Language::where('default',1)->first()->slug;
        $all_header_slider = HeaderSlider::where('lang',$lang)->get();
        $all_counterup = Counterup::where('lang',$lang)->get();
        $all_key_features = KeyFeatures::where('lang',$lang)->get();
        $all_service = Services::where('lang',$lang)->orderBy('id','desc')->take(get_static_option('home_page_01_service_area_items'))->get();
        $all_testimonial = Testimonial::where('lang',$lang)->get();
        $all_price_plan = PricePlan::where([ 'lang' => $lang])->orderBy('id','desc')->take(get_static_option('home_page_01_price_plan_section_items'))->get();;
        $all_team_members = TeamMember::where('lang',$lang)->orderBy('id','desc')->take(get_static_option('home_page_01_team_member_section_items'))->get();;
        $all_brand_logo = Brand::all();
        $all_work = Works::where('lang',$lang)->get();
        $all_work_category = WorksCategory::where(['status'=> 'publish', 'lang' => $lang])->get();
        $all_blog = Blog::where('lang',$lang)->orderBy('id','desc')->take(3)->get();

        return view('frontend.frontend-home-demo')->with([
            'all_header_slider' => $all_header_slider,
            'all_counterup' => $all_counterup,
            'all_key_features' => $all_key_features,
            'all_service' => $all_service,
            'all_testimonial' => $all_testimonial,
            'all_blog' => $all_blog,
            'all_price_plan' => $all_price_plan,
            'all_team_members' => $all_team_members,
            'all_brand_logo' => $all_brand_logo,
            'all_work' => $all_work,
            'all_work_category' => $all_work_category,
            'home_page' => $id,
        ]);
    }


    public function blog_page(){
        $lang = !empty(session()->get('lang')) ? session()->get('lang') : Language::where('default',1)->first()->slug;
        $all_recent_blogs = Blog::where('lang',$lang)->orderBy('id','desc')->take(get_static_option('blog_page_recent_post_widget_item'))->get();
        // $all_blogs = Blog::where('lang',$lang)->orderBy('id','desc')->paginate(get_static_option('blog_page_item'));
        $all_blogs = Blog::where('lang',$lang)->orderBy('id','desc')->paginate(5);
        $all_category = BlogCategory::where(['status'=>'publish','lang' => $lang])->orderBy('id','desc')->get();
        return view('frontend.pages.blog')->with([
            'all_blogs' => $all_blogs,
            'all_categories' => $all_category,
            'all_recent_blogs' => $all_recent_blogs,
        ]);
    }
    public function category_wise_blog_page($id){
        $lang = !empty(session()->get('lang')) ? session()->get('lang') : Language::where('default',1)->first()->slug;
        $all_blogs = Blog::where(['blog_categories_id' => $id,'lang' => $lang])->orderBy('id','desc')->paginate(get_static_option('blog_page_item'));
        $all_recent_blogs = Blog::where('lang',$lang)->orderBy('id','desc')->take(get_static_option('blog_page_recent_post_widget_item'))->get();
        $all_category = BlogCategory::where(['status'=>'publish','lang' => $lang])->orderBy('id','desc')->get();
        $category_name = BlogCategory::where(['id'=>$id,'status' => 'publish'])->first()->name;
        return view('frontend.pages.blog-category')->with([
            'all_blogs' => $all_blogs,
            'all_categories' => $all_category,
            'category_name' => $category_name,
            'all_recent_blogs' => $all_recent_blogs,
        ]);
    }
    public function blog_search_page(Request $request){
        $lang = !empty(session()->get('lang')) ? session()->get('lang') : Language::where('default',1)->first()->slug;
        $all_recent_blogs = Blog::where('lang',$lang)->orderBy('id','desc')->take(get_static_option('blog_page_recent_post_widget_item'))->get();
        $all_category = BlogCategory::where(['status'=>'publish','lang' => $lang])->orderBy('id','desc')->get();
        $all_blogs = Blog::where('title','LIKE','%'.$request->search.'%')->where('lang', $lang)
            ->orWhere('content','LIKE','%'.$request->search.'%')
            ->orWhere('tags','LIKE','%'.$request->search.'%')
            ->orderBy('id','desc')->paginate(get_static_option('blog_page_item'));

        return view('frontend.pages.blog-search')->with([
            'all_blogs' => $all_blogs,
            'all_categories' => $all_category,
            'search_term' => $request->search,
            'all_recent_blogs' => $all_recent_blogs,
        ]);
    }

    public function blog_single_page($id,$any){

        $lang = !empty(session()->get('lang')) ? session()->get('lang') : Language::where('default',1)->first()->slug;
        $blog_post = Blog::findOrFail($id);
        $all_recent_blogs = Blog::where(['lang'=>$lang])->orderBy('id','desc')->paginate(get_static_option('blog_page_recent_post_widget_item'));
        $all_category = BlogCategory::where(['status'=>'publish','lang' => $lang])->orderBy('id','desc')->get();

        return view('frontend.pages.blog-single')->with([
            'blog_post' => $blog_post,
            'all_categories' => $all_category,
            'all_recent_blogs' => $all_recent_blogs
        ]);
    }

    public function service_single_page($id,$any){
        $service_post = Services::findOrFail($id);

        return view('frontend.pages.blog-single')->with([
            'service_post' => $service_post
        ]);
    }

    public function dynamic_single_page($id,$any){
        $page_post = Page::findOrFail($id);
        $lang = !empty(session()->get('lang')) ? session()->get('lang') : Language::where('default',1)->first()->slug;
        return view('frontend.pages.dynamic-single')->with([
            'page_post' => $page_post
        ]);
    }

    public function showAdminForgetPasswordForm(){
        return view('auth.admin.forget-password');
    }

    public function sendAdminForgetPasswordMail(Request $request){
        $this->validate($request,[
           'username' => 'required|string:max:191'
        ]);
        $user_info = Admin::where('username',$request->username)->orWhere('email',$request->username)->first();
        $token_id = Str::random(30);
        $existing_token = DB::table('password_resets')->where('email',$user_info->email)->delete();
        if (empty($existing_token)){
            DB::table('password_resets')->insert(['email' => $user_info->email, 'token' => $token_id]);
        }

        $message = __('Hello').' '.$user_info->username.'<br>';
        $message .= __('Here is you password reset link, If you did not request to reset your password just ignore this mail.') .'<a style="background-color:#444;color:#fff;text-decoration:none;padding: 10px 15px;border-radius: 3px;display: block;width: 130px;margin-top: 20px;" href="'.route('admin.reset.password',['user'=>$user_info->username,'token' => $token_id]).'">'.__('Click Reset Password').'</a>';

        Mail::to($user_info->email)->send(new BasicMailTemplate([
            'subject' => __('Reset Your Password'),
            'message' => $message
        ]));
        if (!Mail::failures()){
            return redirect()->back()->with([
                'msg' => __('Check Your Mail For Reset Password Link'),
                'type' => 'success'
            ]);
        }
        return redirect()->back()->with([
            'msg' => __('Something Wrong, Please Try Again!!'),
            'type' => 'danger'
        ]);
    }

    public function showAdminResetPasswordForm($username,$token){
        return view('auth.admin.reset-password')->with([
            'username' => $username,
            'token' => $token
        ]);
    }
    public function AdminResetPassword(Request $request){
        $this->validate($request, [
            'token' => 'required',
            'username' => 'required',
            'password' => 'required|string|min:8|confirmed'
        ]);
        $user_info = Admin::where('username',$request->username)->first();
        $user = Admin::findOrFail($user_info->id);
        $token_iinfo = DB::table('password_resets')->where(['email' => $user_info->email,'token' => $request->token])->first();
        if (!empty($token_iinfo)){
            $user->password = Hash::make($request->password);
            $user->save();
            return redirect()->route('admin.login')->with(['msg'=> __('Password Changed Successfully') ,'type'=> 'success']);
        }

        return redirect()->back()->with(['msg'=> __('Somethings Going Wrong! Please Try Again or Check Your Old Password'),'type'=> 'danger']);
    }

    public function lang_change(Request $request){
        session()->put('lang', $request->lang);
        return redirect()->route('homepage');
    }

    public function set_lang($name)
    {
        session()->put('lang', $name);
        return redirect()->back();
    }


    public function send_contact_message(Request $request)
    {
        $validated_data = $this->get_filtered_data_from_request(get_static_option('contact_page_contact_form_fields'), $request);
        $all_attachment = $validated_data['all_attachment'];
        $all_field_serialize_data = $validated_data['field_data'];
        $success_message = !empty($succ_msg) ? $succ_msg : __('Your message has been sent! We will get back to you soon.');
      //  $success_message = 'contact_mail_' . get_default_language() . '_success_message';
        Mail::to(get_static_option('site_global_email'))->send(new ContactMessage($all_field_serialize_data, $all_attachment, __('You Have Contact Message from') . ' ' . get_static_option('site_' . get_default_language() . '_title')));
        return redirect()->back()->with(['msg' => $success_message, 'type' => 'success']);
    }

    public function services_single_page($id,$any){
        $lang = !empty(session()->get('lang')) ? session()->get('lang') : Language::where('default',1)->first()->slug;
        $service_item = Services::findOrFail($id);
        $service_category = ServiceCategory::where(['status'=>'publish','lang' => $lang])->get();
        return view('frontend.pages.service-single')->with(['service_item' => $service_item,'service_category' => $service_category]);
    }

    public function category_wise_services_page($id,$any){
        $lang = !empty(session()->get('lang')) ? session()->get('lang') : Language::where('default',1)->first()->slug;
        $category_name = ServiceCategory::findOrFail($id)->name;
        $service_item = Services::where(['categories_id'=>$id,'lang' => $lang])->paginate(6);
        return view('frontend.pages.services')->with(['service_items' => $service_item,'category_name' => $category_name]);
    }

    public function work_single_page($id,$any){
        $work_item = Works::findOrFail($id);
        return view('frontend.pages.work-single')->with(['work_item' => $work_item]);
    }
    
    public function work_detail_page($name,$any){
        // $work_item = Works::findOrFail($id);
        $lang = get_user_lang();

        $work_item = DB::table('works')
        ->join('works_categories','works.category_id','=','works_categories.id')
        ->where('works.title',$name)
        ->where('works.lang',$lang)
        ->where('works.status','publish')
        ->select('*', 'works.id as work_id')
        ->first();

        if (!$work_item) {
            return view('errors.404');
        } 
        else {
            $sector = DB::table('works_sectors')
            ->whereIn('id',explode(',',$work_item->sectors_id))
            ->get();
            
            $similar_products = DB::table('works as a')
            ->join(DB::raw('(SELECT works_id, MIN(id) as min_id, image FROM works_image GROUP BY works_id) as b'), 'a.id', '=', 'b.works_id')
            ->select('*', 'a.id as id', 'a.lang as lang')
            ->where('a.category_id',$work_item->category_id)
            ->where('a.status','publish')
            ->get();

            $work_image = DB::table('works_image')
                            // ->leftJoin('media_uploads as b', 'a.image','=','b.id')
                            ->where('works_id', $work_item->work_id)
                            ->get();

            $oem_id = explode(',', $work_item->oem_id);
            $oems = DB::table('works_oem')
                    ->whereIn('id', $oem_id)
                    ->orderBy('spec', 'ASC')
                    ->get();
            
            $industry_id = explode(',', $work_item->industry_id);
            $industries = DB::table('works_industry')
                        ->whereIn('id', $industry_id)
                        ->orderBy('spec', 'ASC')
                        ->get();

            $packaging_id = explode(',', $work_item->packaging_id);
            $packagings = DB::table('works_packaging')
                        ->whereIn('id', $packaging_id)
                        ->get();

            return view('frontend.pages.work-detail')->with(['work_item' => $work_item, 'sector' => $sector, 'similar_products' => $similar_products, 'work_image' => $work_image, 'oems' => $oems, 'industries' => $industries, 'packagings' => $packagings]);
        }
    }

    public function request_tds(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:191',
            'email' => 'required|email',
            'company' => 'required|string|max:191',
        ]);

        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');

        $tdsRequest = TdsRequest::create([
            'works_id' => $request->works_id,
            'name' => $request->name,
            'email' => $request->email,
            'company' => $request->company,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $cek = DB::table('works')->where('id', $request->works_id)->first();

        // Path ke file yang akan di-attach
        $attachmentPath = base_path('../assets/uploads/tds/' . $cek->tds);

        // Kirim email
        Mail::to($request->email)->send(new MyTdsMail($tdsRequest, $attachmentPath));

        return response()->json([
            'success_tds' => 'TDS Request sent and email delivered successfully!',
        ]);
    }

    public function tds_download($id)
    {
        $cek = DB::table('works')->where('id', $id)->first();

        if (!$cek || !$cek->tds) {
            abort(404, "File doesn't exist!");
        }
        
        $path = base_path('../assets/uploads/tds/' . $cek->tds);

        if (file_exists($path)) {
            return response()->download($path, $cek->tds, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $cek->tds . '"',
            ]);

        } else {
            abort(404);
        }
    }

    public function about_page(){
        $lang = !empty(session()->get('lang')) ? session()->get('lang') : Language::where('default',1)->first()->slug;
        $all_counterup = Counterup::where('lang',$lang)->get();
        $all_brand_logo = Brand::all();
        $all_team_members = TeamMember::where('lang',$lang)->orderBy('id','desc')->take(4)->get();
        // $all_value = Services::where(['lang'=>$lang, 'categories_id'=>'15'])->orderBy('id','asc')->get();
        // $all_misi = Services::where(['lang'=>$lang, 'categories_id'=>'16'])->orderBy('id','asc')->get();
        // $all_visi = Services::where(['lang'=>$lang, 'categories_id'=>'18'])->orderBy('id','asc')->get();
        // $all_about = Services::where(['lang'=>$lang, 'categories_id'=>'19'])->orderBy('id','asc')->get();


        if(get_user_lang()=='en'){
            $all_value = Services::where(['categories_id'=>'15'])->orderBy('id','asc')->get();
            $all_misi = Services::where(['categories_id'=>'16'])->orderBy('id','asc')->get();
            $all_visi = Services::where(['categories_id'=>'18'])->orderBy('id','asc')->get();
            $all_about = Services::where(['categories_id'=>'19'])->orderBy('id','asc')->get();
        } else {
            $all_value = Services::where(['categories_id'=>'21'])->orderBy('id','asc')->get();
            $all_misi = Services::where(['categories_id'=>'22'])->orderBy('id','asc')->get();
            $all_visi = Services::where(['categories_id'=>'24'])->orderBy('id','asc')->get();
            $all_about = Services::where(['categories_id'=>'25'])->orderBy('id','asc')->get();
        }

        //hide category creation and fixed en id , if en if id
        return view('frontend.pages.about')
                ->with([
                    'all_counterup' => $all_counterup,
                    'all_brand_logo' => $all_brand_logo,
                    'all_team_members' => $all_team_members, 
                    'all_value' => $all_value, 
                    'all_misi' => $all_misi,
                    'all_visi' => $all_visi,
                    'all_about' => $all_about
                ]);
    }
    public function service_page(){
        $lang = !empty(session()->get('lang')) ? session()->get('lang') : Language::where('default',1)->first()->slug;
        // $all_services = Services::where(['lang'=>$lang, 'categories_id'=>'17'])->orderBy('id','asc')->get();

        if(get_user_lang()=='en'){
            $all_services = Services::where(['categories_id'=>'17'])->orderBy('id','asc')->get();
        } else {
            $all_services = Services::where(['categories_id'=>'23'])->orderBy('id','asc')->get();
        }


        $all_price_plan = PricePlan::where('lang',$lang)->get();
        return view('frontend.pages.service')->with(['all_services' => $all_services,'all_price_plan' => $all_price_plan]);
    }
    public function work_page(){


        $lang = !empty(session()->get('lang')) ? session()->get('lang') : Language::where('default',1)->first()->slug;
       
        // foreach ($_GET as $key => $value) {
        //     //$all_products->where("where(field_{$i},".$value."_1)");

        //     if($key=='search'){
        //         $all_products->where('title', 'like', '%' . $_GET['search'] . '%');
        //     }
        //     if($key=='cat'){
        //         $all_products->where('category_id', $_GET['cat']);
        //     }
        //     if($key=='sector'){
        //         $sector = $_GET['sector'];
        //         //$all_products->where('sectors_id', $_GET['sector']);
        //         // $all_products->whereRaw("FIND_IN_SET(sectors_id,'".$_GET['sector']."')");
        //         //$all_products->whereRaw("FIND_IN_SET('".$_GET['sector']."',sectors_id)");
        //         //$all_products->whereRaw("FIND_IN_SET(?, sectors_id) > 0", [$sector]);
        //         $all_products->whereRaw("find_in_set('".$sector."',sectors_id)");
        //         //$all_products->whereRaw('FIND_IN_SET(?, sectors_id)', [$_GET['sector']]);


        //     }

        // }

        // $all_products = $all_products->orderBy('id','desc')->toSql();
        // var_dump($all_products);
        // die();
        // $all_products = $all_products->orderBy('id','desc')->paginate(12);

        // die();

        // if(isset($_GET['cat'])){
        //     //var_dump(serialize($_GET['cat'])); die();
        //     $all_products = Works::where(['lang' => $lang])
        //             ->where('category_id', $_GET['cat'])
        //             //->WhereIn(['categories_id',serialize($_GET['cat'])])
        //             //->whereIn('categories_id', serialize($_GET['cat']))
        //             ->orderBy('id','desc')->paginate(12);
        // } 
        // else if(isset($_GET['search'])){
        //     //var_dump(serialize($_GET['cat'])); die();
        //     $all_products = Works::where(['lang' => $lang])
        //             ->where('title', 'like', '%' . $_GET['search'] . '%')
        //             //->WhereIn(['categories_id',serialize($_GET['cat'])])
        //             //->whereIn('categories_id', serialize($_GET['cat']))
        //             ->orderBy('id','desc')->paginate(12);
        // }     
        // else {
        //     $all_products = Works::where(['lang' => $lang])->orderBy('id','desc')->paginate(12);
        // }

        $all_work_category = WorksCategory::where(['status' => 'publish', 'lang' => $lang])->orderBy('name')->get();
        $all_work_sectors = WorksSectors::where(['status' => 'publish', 'lang' => $lang])->get();
        
        $arr_product = array();
        foreach ($all_work_category as $category) {
            $subcategories =  WorksSubcategory::where(['status' => 'publish', 'lang' => $lang, 'category_id' => $category->id])->get();
            if ($subcategories->count() > 0) {
                $arr_product[$category->id]['sub'] =  true; // if subcategory exist

                foreach ($subcategories as $sub) {
                    $arr_product[$category->id]['data'][$sub->name] = DB::table('works as a')
                                ->join(DB::raw('(SELECT works_id, MIN(id) as min_id, image FROM works_image GROUP BY works_id) as b'), 'a.id', '=', 'b.works_id')
                                ->select('*', 'a.id as id', 'a.lang as lang')
                                ->where('a.lang', $lang)
                                ->where('a.category_id', $category->id)
                                ->where('a.subcategory_id', $sub->id)
                                ->where('a.status', 'publish')
                                ->get();
                }
            } else {
                $arr_product[$category->id]['sub'] =  false;
                $arr_product[$category->id]['data'] = DB::table('works as a')
                                ->join(DB::raw('(SELECT works_id, MIN(id) as min_id, image FROM works_image GROUP BY works_id) as b'), 'a.id', '=', 'b.works_id')
                                ->select('*', 'a.id as id', 'a.lang as lang')
                                ->where('a.lang', $lang)
                                ->where('a.category_id', $category->id)
                                ->where('a.status', 'publish')
                                ->get();
            }
            
        }

        return view('frontend.pages.work')->with(['products' => $arr_product,'all_work_category' => $all_work_category,'all_work_sectors' => $all_work_sectors]);
    }
    public function product_page(){
        $lang = !empty(session()->get('lang')) ? session()->get('lang') : Language::where('default',1)->first()->slug;
        $all_work = Works::where(['lang' => $lang])->orderBy('id','desc')->paginate(12);
        $all_work_category = WorksCategory::where(['status' => 'publish', 'lang' => $lang])->get();
        return view('frontend.pages.product')->with(['all_work' => $all_work,'all_work_category' => $all_work_category]);
    }

    public function team_page(){
        $lang = !empty(session()->get('lang')) ? session()->get('lang') : Language::where('default',1)->first()->slug;
        $all_team_members = TeamMember::where('lang',$lang)->orderBy('id','desc')->paginate(get_static_option('team_page_team_member_section_item'));

        return view('frontend.pages.team-page')->with(['all_team_members' => $all_team_members]);
    }
    public function faq_page(){
        $lang = !empty(session()->get('lang')) ? session()->get('lang') : Language::where('default',1)->first()->slug;
        $all_faq = Faq::where('lang',$lang)->get();
        $all_brand_logo = Brand::all();
        $all_testimonial = Testimonial::where('lang',$lang)->get();
        return view('frontend.pages.faq-page')->with([
            'all_brand_logo' => $all_brand_logo,
            'all_testimonial' => $all_testimonial,
            'all_faqs' => $all_faq
        ]);
    }

    public function contact_page(){
        $lang = !empty(session()->get('lang')) ? session()->get('lang') : Language::where('default',1)->first()->slug;
        $all_contact_info = ContactInfoItem::where('lang',$lang)->get();
        return view('frontend.pages.contact-page')->with([
            'all_contact_info' => $all_contact_info
        ]);
    }
    public function plan_order($id){
        $order_details = PricePlan::find($id);
        return view('frontend.pages.order-page')->with([
            'order_details' => $order_details
        ]);
    }

    public function request_quote(){
        $lang = !empty(session()->get('lang')) ? session()->get('lang') : Language::where('default',1)->first()->slug;
        $contact_info = ContactInfoItem::where('lang',$lang)->get();
        return view('frontend.pages.quote-page')->with(['all_contact_info' => $contact_info]);
    }

    public function send_quote_message(Request $request)
{

    $all_quote_form_fields = json_decode(get_static_option('quote_page_form_fields'));
    $required_fields = [];
    $fileds_name = [];
    $attachment_list = [];
    foreach ($all_quote_form_fields->field_type as $key => $value) {
        if (is_object($all_quote_form_fields->field_required) && !empty($all_quote_form_fields->field_required->$key) && $value != 'file') {

            $sanitize_rule = ($value == 'email') ? 'email' : 'string';
            $required_fields[$all_quote_form_fields->field_name[$key]] = 'required|' . $sanitize_rule;

        } elseif (is_object($all_quote_form_fields->field_required) && $value == 'file') {

            $file_required = isset($all_quote_form_fields->field_required->$key) ? 'required|' : '';
            $file_mimes_type = isset($all_quote_form_fields->mimes_type->$key) ? $all_quote_form_fields->mimes_type->$key : '';
            $required_fields[$all_quote_form_fields->field_name[$key]] = $file_required . $file_mimes_type . '|max:6054';

        } elseif (is_array($all_quote_form_fields->field_required) && $value == 'file') {

            $file_required = isset($all_quote_form_fields->field_required->$key) ? 'required|' : '';
            $file_mimes_type = isset($all_quote_form_fields->mimes_type->$key) ? $all_quote_form_fields->mimes_type->$key : '';
            $required_fields[$all_quote_form_fields->field_name[$key]] = $file_required . $file_mimes_type . '|max:6054';

        } else if (is_array($all_quote_form_fields->field_required) && !empty($all_quote_form_fields->field_required[$key]) && $value != 'file') {

            $sanitize_rule = ($value == 'email') ? 'email' : 'string';
            $required_fields[$all_quote_form_fields->field_name[$key]] = 'required|' . $sanitize_rule;

        }
    }
    $this->validate($request, $required_fields);
    //have to insert quote data to database to show all quote in backend;
    $all_field_serialize_data = $request->all();
     unset($all_field_serialize_data['_token']);
     unset($all_field_serialize_data['captcha_token']);
    foreach($all_field_serialize_data as $field_name => $field_value){
        if ($request->hasFile($field_name)){
            unset($all_field_serialize_data[$field_name]);
        }
    }
    $quote_id = Quote::create([
        'custom_fields' => serialize($all_field_serialize_data),
        'status' => 'pending'
    ])->id;

    foreach ($all_quote_form_fields->field_type as $key => $value) {
        if ($value != 'file') {
            $singule_field_name = $all_quote_form_fields->field_name[$key];
            $checkbox_value = ($value == 'checkbox' && !empty($request->$singule_field_name)) ? 'Yes' : 'No';
            $fileds_name[$singule_field_name] = ($value != 'checkbox') ? $request->$singule_field_name : $checkbox_value;

        } elseif ($value == 'file') {
            $singule_field_name = $all_quote_form_fields->field_name[$key];
            if ($request->hasFile($singule_field_name)) {
                $filed_instance = $request->file($singule_field_name);
                $file_extenstion = $filed_instance->getClientOriginalExtension();
                $attachment_name = 'attachment-' . $quote_id .'-'.$singule_field_name. '.' . $file_extenstion;
                $filed_instance->move('assets/uploads/attachment/', $attachment_name);

                $attachment_list[$singule_field_name] = 'assets/uploads/attachment/' . $attachment_name;
            }
        }
    }

    Quote::find($quote_id)->update(['attachment' => serialize($attachment_list)]);
    //
     $google_captcha_result = google_captcha_check($request->captcha_token);
     if ($google_captcha_result['success']) {
        $succ_msg = get_static_option('quote_mail_' . get_user_lang() . '_subject');
        $success_message = !empty($succ_msg) ? $succ_msg : 'Thanks for your quote. we will get back to you very soon.';

        Mail::to(get_static_option('quote_page_form_mail'))->send(new RequestQuote($fileds_name, $attachment_list));

        return redirect()->back()->with(['msg' => $success_message, 'type' => 'success']);

     }

     return redirect()->back()->with(['msg' => 'Something went wrong, Please try again later !!', 'type' => 'danger']);

}


    public function send_order_message(Request $request)
    {
        $validated_data = $this->get_filtered_data_from_request(get_static_option('order_page_form_fields'),$request);
        $all_attachment = $validated_data['all_attachment'];
        $all_field_serialize_data = $validated_data['field_data'];
        $package_detials = PricePlan::find($request->package);
        $order_id =Order::create([
            'custom_fields' => serialize($all_field_serialize_data),
            'attachment' => serialize($all_attachment),
            'status' => 'pending',
            'package_name' => $package_detials->title,
            'package_price' => $package_detials->price,
            'package_id' => $package_detials->id,
            'checkout_type' => !empty($request->checkout_type) ? $request->checkout_type : '',
            'user_id' => Auth::guard('web')->check() ? Auth::guard('web')->user()->id : 0,
        ])->id;
        if (!empty(get_static_option('site_payment_gateway'))) {
            return redirect()->route('frontend.order.confirm', $order_id);
        }
        $google_captcha_result = google_captcha_check($request->captcha_token);
        if ($google_captcha_result['success']) {
            $succ_msg = get_static_option('order_mail_' . get_user_lang() . '_success_message');
            $success_message = !empty($succ_msg) ? $succ_msg : __('Thanks for your order. we will get back to you very soon.');
            $order_rmail = get_static_option('order_page_form_mail');
            $order_mail = $order_rmail ? $order_rmail : get_static_option('site_global_email');
            //have to set condition for redirect in payment page with payment information
            if (!empty(get_static_option('site_payment_gateway'))) {
                return redirect()->route('frontend.order.confirm', $order_id);
            }
            Mail::to($order_mail)->send(new BasicMail([
                'subject' => __('You have a package order from').' '.get_static_option('site_'.get_default_language().'_title'),
                'message' => '',
            ]));
            return redirect()->back()->with(['msg' => $success_message, 'type' => 'success']);
        } else {
            return redirect()->back()->with(['msg' => __('Something goes wrong, Please try again later !!'), 'type' => 'danger']);
        }
    }

    public function subscribe_newsletter(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string|email|max:191|unique:newsletters'
        ]);
        $verify_token = Str::random(32);
        Newsletter::create([
            'email' => $request->email,
            'verified' => 0,
            'verify_token' => $verify_token
        ]);
        $message = __('verify your email to get all news from '). get_static_option('site_'.get_default_language().'_title') . '<div class="btn-wrap"> <a class="anchor-btn" href="' . route('subscriber.verify', ['token' => $verify_token]) . '">' . __('verify email') . '</a></div>';
        $data = [
            'message' => $message,
            'subject' => __('verify your email')
        ];
        //send verify mail to newsletter subscriber
        Mail::to($request->email)->send(new BasicMailTemplate($data,__('Verify your email')));

        return response()->json([
            'msg' => __('Thanks for Subscribe Our Newsletter'),
            'type' => 'success'
        ]);
    }


      public function subscriber_verify(Request $request){
      Newsletter::where('verify_token',$request->token)->update([
          'verified' => 1
      ]);
      return view('frontend.thankyou');
    }


    public function showUserForgetPasswordForm()
    {
        return view('frontend.user.forget-password');
    }

    public function sendUserForgetPasswordMail(Request $request)
    {
      $this->validate($request, [
          'username' => 'required|string:max:191'
      ]);

    $user_info = User::where('username', $request->username)->orWhere('email', $request->username)->first();
    if (!empty($user_info)) {
        $token_id = Str::random(30);
        $existing_token = DB::table('password_resets')->where('email', $user_info->email)->delete();
        if (empty($existing_token)) {
            DB::table('password_resets')->insert(['email' => $user_info->email, 'token' => $token_id]);
        }
        $message = __('Here is you password reset link, If you did not request to reset your password just ignore this mail.') . ' <a class="btn" href="' . route('user.reset.password', ['user' => $user_info->username, 'token' => $token_id]) . '">' . __('Click Reset Password') . '</a>';
        $data = [
            'username' => $user_info->username,
            'message' => $message
        ];
        Mail::to($user_info->email)->send(new UserResetEmail($data));

        return redirect()->back()->with([
            'msg' => __('Check Your Mail For Reset Password Link'),
            'type' => 'success'
        ]);
    }
    return redirect()->back()->with([
        'msg' => __('Your Username or Email Is Wrong!!!'),
        'type' => 'danger'
    ]);
}

public function showUserResetPasswordForm($username, $token)
{
  return view('frontend.user.reset-password')->with([
      'username' => $username,
      'token' => $token
  ]);
}

public function UserResetPassword(Request $request)
  {
    $this->validate($request, [
        'token' => 'required',
        'username' => 'required',
        'password' => 'required|string|min:8|confirmed'
    ]);
    $user_info = User::where('username', $request->username)->first();
    $user = User::findOrFail($user_info->id);
    $token_iinfo = DB::table('password_resets')->where(['email' => $user_info->email, 'token' => $request->token])->first();
    if (!empty($token_iinfo)) {
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->route('user.login')->with(['msg' => __('Password Changed Successfully'), 'type' => 'success']);
    }

    return redirect()->back()->with(['msg' => __('Somethings Going Wrong! Please Try Again or Check Your Old Password'), 'type' => 'danger']);
  }

  public function ajax_login(Request $request)
{
    $this->validate($request, [
        'username' => 'required|string',
        'password' => 'required|min:6'
    ], [
        'username.required'   => __('username required'),
        'password.required' => __('password required'),
        'password.min' => __('password length must be 6 characters')
    ]);
    if (Auth::guard('web')->attempt(['username' => $request->username, 'password' => $request->password],
      $request->get('remember'))) {
        return response()->json([
            'msg' => __('login Success Redirecting'),
            'type' => 'danger',
            'status' => 'valid'
        ]);
    }
    return response()->json([
        'msg' => __('Username Or Password Doest Not Matched !!!'),
        'type' => 'danger',
        'status' => 'invalid'
    ]);
}

public function get_filtered_data_from_request($option_value,$request){
    $all_attachment = [];
    $all_quote_form_fields = (array) json_decode($option_value);
    $all_field_type = isset($all_quote_form_fields['field_type']) ? (array) $all_quote_form_fields['field_type'] : [];
    $all_field_name = isset($all_quote_form_fields['field_name']) ? $all_quote_form_fields['field_name'] : [];
    $all_field_required = isset($all_quote_form_fields['field_required'])  ? (object) $all_quote_form_fields['field_required'] : [];
    $all_field_mimes_type = isset($all_quote_form_fields['mimes_type']) ? (object) $all_quote_form_fields['mimes_type'] : [];
    //get field details from, form request
    $all_field_serialize_data = $request->all();
    unset($all_field_serialize_data['_token']);
    if (isset($all_field_serialize_data['captcha_token'])){
        unset($all_field_serialize_data['captcha_token']);
    }
    if (!empty($all_field_name)){
        foreach ($all_field_name as $index => $field){
            $is_required = !empty($all_field_required) && property_exists($all_field_required,$index) ? $all_field_required->$index : '';
            $mime_type = !empty($all_field_mimes_type) && property_exists($all_field_mimes_type,$index) ? $all_field_mimes_type->$index : '';
            $field_type = isset($all_field_type[$index]) ? $all_field_type[$index] : '';
            if (!empty($field_type) && $field_type == 'file'){
                unset($all_field_serialize_data[$field]);
            }
            $validation_rules = !empty($is_required) ? 'required|': '';
            $validation_rules .= !empty($mime_type) ? $mime_type : '';
            //validate field
            $this->validate($request,[
                $field => $validation_rules
            ]);
            if ($field_type == 'file' && $request->hasFile($field)) {
                $filed_instance = $request->file($field);
                $file_extenstion = $filed_instance->getClientOriginalExtension();
                $attachment_name = 'attachment-'.Str::random(32).'-'. $field .'.'. $file_extenstion;
                $filed_instance->move('assets/uploads/attachment/applicant', $attachment_name);
                $all_attachment[$field] = 'assets/uploads/attachment/applicant/' . $attachment_name;
            }
        }
    }
    return [
        'all_attachment' => $all_attachment,
        'field_data' => $all_field_serialize_data
    ];
}

public function order_confirm($id)
    {
        $order_details = Order::find($id);
        return view('frontend.payment.order-confirm')->with(['order_details' => $order_details]);
    }

    public function order_payment_success($id)
{
    $order_details = Order::find(substr($id,6,-6));
    return view('frontend.payment.payment-success')->with(['order_details' => $order_details]);
}

public function order_payment_cancel($id)
{
    $order_details = Order::find($id);
    return view('frontend.payment.payment-cancel')->with(['order_details' => $order_details]);
}
public function generate_package_invoice(Request $request)
{
    $payment_details = PaymentLogs::where(['order_id' => $request->id])->first();
    $order_details = Order::where(['id' => $request->id])->first();
    if (empty($order_details)) {
        return redirect_404_page();
    }
    $pdf = PDF::loadView('invoice.package-order', ['order_details' => $order_details, 'payment_details' => $payment_details]);
    return $pdf->download('package-invoice.pdf');
}

public function order_details($id)
{

    $order_details = Order::find($id);
    if(empty($order_details)){
        abort(404);
    }
    $package_details = PricePlan::find($order_details->package_id);
    $payment_details = PaymentLogs::where('order_id', $id)->first();
    return view('frontend.pages.package.view-order')->with(
        [
            'order_details' => $order_details,
            'package_details' => $package_details,
            'payment_details' => $payment_details,
        ]
    );
}

    public function order_payment_cancel_static()
    {
        return view('frontend.payment.payment-cancel-static');
    }

}//end class
