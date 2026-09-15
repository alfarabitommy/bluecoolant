<?php
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['setlang','globalVariable','maintains_mode']],function (){
    //frontend routes
    Route::get('/','FrontendController@index')->name('homepage');
    Route::get('/p/{id}/{any}','FrontendController@dynamic_single_page')->name('frontend.dynamic.page');

    $work_page_slug = get_static_option('work_page_slug') ?? 'work';
    $about_page_slug = get_static_option('about_page_slug') ?? 'about';
    $service_page_slug = get_static_option('service_page_slug') ?? 'service';
    $team_page_slug = get_static_option('team_page_slug') ?? 'team';
    $faq_page_slug = get_static_option('faq_page_slug') ?? 'faq';
    $blog_page_slug = get_static_option('blog_page_slug') ?? 'blog';
    $contact_page_slug = get_static_option('contact_page_slug') ?? 'contact';
    $quote_page_slug = get_static_option('quote_page_slug') ?? 'quote';



    Route::get('/'.$work_page_slug,'FrontendController@work_page')->name('frontend.work');
    Route::get('/'.$work_page_slug.'/{id}/{any?}','FrontendController@work_single_page')->name('frontend.work.single');
    Route::get('/'.$work_page_slug.'/detail/{name}/{any?}','FrontendController@work_detail_page')->name('frontend.work.detail');


    Route::get('/'.$about_page_slug,'FrontendController@about_page')->name('frontend.about');
    Route::get('/'.$service_page_slug,'FrontendController@service_page')->name('frontend.service');
    Route::get('/'.$service_page_slug.'/{id}/{any?}','FrontendController@services_single_page')->name('frontend.services.single');
    Route::get('/'.$service_page_slug.'/category/{id}/{any?}','FrontendController@category_wise_services_page')->name('frontend.services.category');

    Route::get('/'.$faq_page_slug,'FrontendController@faq_page')->name('frontend.faq');
    Route::get('/'.$contact_page_slug,'FrontendController@contact_page')->name('frontend.contact');
    Route::get('/plan-order/{id}','FrontendController@plan_order')->name('frontend.plan.order');
    Route::get('/'.$quote_page_slug,'FrontendController@request_quote')->name('frontend.request.quote');
    Route::get('/'.$team_page_slug,'FrontendController@team_page')->name('frontend.team');

    Route::post('/package-user/generate-invoice','FrontendController@generate_package_invoice')->name('frontend.package.invoice.generate');
    Route::get('/order-details/{id}','FrontendController@order_details')->name('frontend.order.view');
    Route::get('/order-confirm/{id}','FrontendController@order_confirm')->name('frontend.order.confirm');

    Route::get('/sitemap.xml', 'SitemapController@index');

    //Blog
    Route::get('/'.$blog_page_slug,'FrontendController@blog_page')->name('frontend.blog');
    Route::get('/'.$blog_page_slug.'/{id}/{any}','FrontendController@blog_single_page')->name('frontend.blog.single');
    Route::get('/'.$blog_page_slug.'/search/','FrontendController@blog_search_page')->name('frontend.blog.search');
    Route::get('/'.$blog_page_slug.'/category/{id}/{any}','FrontendController@category_wise_blog_page')->name('frontend.blog.category');

    //language change
    Route::get('/lang','FrontendController@lang_change')->name('frontend.langchange');
    Route::get('/home/{id}','FrontendController@home_page_change');
    Route::post('/contact-message','FrontendController@send_contact_message')->name('frontend.contact.message');
    Route::post('/subscribe-newsletter','FrontendController@subscribe_newsletter')->name('frontend.subscribe.newsletter');
    Route::post('/request-quote','FrontendController@send_quote_message')->name('frontend.quote.message');
    Route::post('/place-order','FrontendController@send_order_message')->name('frontend.order.message');

    //user email verify
    Route::get('/user/email-verify','UserDashboardController@user_email_verify_index')->name('user.email.verify');
    Route::get('/user/resend-verify-code','UserDashboardController@reset_user_email_verify_code')->name('user.resend.verify.mail');
    Route::post('/user/email-verify','UserDashboardController@user_email_verify');
    Route::get('/subscriber/email-verify/{token}','FrontendController@subscriber_verify')->name('subscriber.verify');
    Route::post('/package-order/cancel','UserDashboardController@package_order_cancel')->name('user.dashboard.package.order.cancel');

    //user login
    Route::get('/login','Auth\LoginController@showLoginForm')->name('user.login');
    Route::post('/login','Auth\LoginController@login');
    Route::post('/ajax-login','FrontendController@ajax_login')->name('user.ajax.login');

    Route::get('/register','Auth\RegisterController@showRegistrationForm')->name('user.register');
    Route::post('/register','Auth\RegisterController@register');
    Route::get('/login/forget-password','FrontendController@showUserForgetPasswordForm')->name('user.forget.password');
    Route::get('/login/reset-password/{user}/{token}','FrontendController@showUserResetPasswordForm')->name('user.reset.password');
    Route::post('/login/reset-password','FrontendController@UserResetPassword')->name('user.reset.password.change');
    Route::post('/login/forget-password','FrontendController@sendUserForgetPasswordMail');
    Route::post('/logout','Auth\LoginController@logout')->name('user.logout');

    //User Home
    Route::prefix('user-home')->middleware(['userEmailVerify'])->group(function (){
        Route::get('/', 'UserDashboardController@user_index')->name('user.home');
        Route::post('/profile-update','UserDashboardController@user_profile_update')->name('user.profile.update');
        Route::post('/password-change','UserDashboardController@user_password_change')->name('user.password.change');
    });

//payment status route
Route::get('/order-success/{id}','FrontendController@order_payment_success')->name('frontend.order.payment.success');
Route::get('/order-cancel/{id}','FrontendController@order_payment_cancel')->name('frontend.order.payment.cancel');
Route::get('/order-confirm/{id}','FrontendController@order_confirm')->name('frontend.order.confirm');
//payment
Route::post('/order-confirm','PaymentLogController@order_payment_form')->name('frontend.order.payment.form');

    //ipn route
    Route::post('/paytm-ipn','PaymentLogController@paytm_ipn')->name('frontend.paytm.ipn');
    Route::get('/mollie-ipn','PaymentLogController@mollie_ipn')->name('frontend.mollie.ipn');
    Route::post('/stripe','PaymentLogController@stripe_charge')->name('frontend.stripe.charge');
    Route::get('/stripe/pay','PaymentLogController@stripe_ipn')->name('frontend.stripe.ipn');
    Route::post('/razorpay','PaymentLogController@razorpay_ipn')->name('frontend.razorpay.ipn');
    Route::post('/payfast-ipn','PaymentLogController@payfast_ipn')->name('frontend.payfast.ipn');
    Route::get('/flutterwave/ipn','PaymentLogController@flutterwave_ipn')->name('frontend.flutterwave.ipn');
    Route::get('/paystack-ipn','PaymentLogController@paystack_ipn')->name('frontend.paystack.ipn');
    Route::get('/midtrans-ipn','PaymentLogController@midtrans_ipn')->name('frontend.midtrans.ipn');
    Route::post('/cashfree-ipn','PaymentLogController@cashfree_ipn')->name('frontend.cashfree.ipn');
    Route::get('/instamojo-ipn','PaymentLogController@instamojo_ipn')->name('frontend.instamojo.ipn');
    Route::get('/paypal-ipn','PaymentLogController@paypal_ipn')->name('frontend.paypal.ipn');
    Route::get('/marcadopago-ipn','PaymentLogController@marcadopago_ipn')->name('frontend.marcadopago.ipn');;
    Route::get('/order-cancel-static','FrontendController@order_payment_cancel_static')->name('frontend.order.payment.cancel.static');

});

// get image in product detail
Route::get('/get-product-detail-image', function (Illuminate\Http\Request $request) {
    $imageId = $request->get('id');
    return response()->json([
        'html' => render_image_markup_by_attachment_id($imageId),
    ]);
});

// request tds & email
Route::post('/request-tds', 'FrontEndController@request_tds')->name('frontend.request.tds');
// Route::get('/tds-download/{id}', 'FrontEndController@tds_download')->name('download.tds');

// send email attachment TDS
// Route::get('/send-email-tds', function(){
//     $details = [
//         'title' => 'Title',
//         'body' => 'This is body'
//     ];
//     \Mail::to('yopie.alamsyah@sefasgroup.com')->send(new \App\Mail\MyTdsMail($details));
// });

//admin login
Route::get('/login/admin','Auth\LoginController@showAdminLoginForm')->name('admin.login');
Route::get('/login/admin/forget-password','FrontendController@showAdminForgetPasswordForm')->name('admin.forget.password');
Route::get('/login/admin/reset-password/{user}/{token}','FrontendController@showAdminResetPasswordForm')->name('admin.reset.password');
Route::post('/login/admin/reset-password','FrontendController@AdminResetPassword')->name('admin.reset.password.change');
Route::post('/login/admin/forget-password','FrontendController@sendAdminForgetPasswordMail');
Route::post('/logout/admin','AdminDashboardController@adminLogout')->name('admin.logout');
Route::post('/login/admin','Auth\LoginController@adminLogin');


//admin dashboard routes
Route::group(['prefix'=>'admin-home'],function (){

    Route::get('/', 'AdminDashboardController@adminIndex')->name('admin.home');
    // maintains page
    Route::get('/maintains-page/settings', 'MaintainsPageController@maintains_page_settings')->name('admin.maintains.page.settings');
    Route::post('/maintains-page/settings', 'MaintainsPageController@update_maintains_page_settings');

    //home page variant select
    Route::get('/home-variant',"AdminDashboardController@home_variant")->name('admin.home.variant');
    Route::post('/home-variant',"AdminDashboardController@update_home_variant");
    //navbar settings
    Route::get('/navbar-settings',"AdminDashboardController@navbar_settings")->name('admin.navbar.settings');
    Route::post('/navbar-settings',"AdminDashboardController@update_navbar_settings");

    Route::get('/blog-page','AdminDashboardController@blog_page')->name('admin.blog.page');
    Route::post('/blog-page','AdminDashboardController@blog_page_update');
    Route::get('/counterup','CounterUpController@index')->name('admin.counterup');
    Route::post('/counterup','CounterUpController@store');
    Route::post('/update-counterup','CounterUpController@update')->name('admin.counterup.update');
    Route::post('/delete-counterup/{id}','CounterUpController@delete')->name('admin.counterup.delete');
    Route::post('/counterup/bulk-action','CounterUpController@bulk_action')->name('admin.counterup.bulk.action');

    //Testimonial
    Route::get('/testimonial','TestimonialController@index')->name('admin.testimonial');
    Route::post('/testimonial','TestimonialController@store');
    Route::post('/update-testimonial','TestimonialController@update')->name('admin.testimonial.update');
    Route::post('/delete-testimonial/{id}','TestimonialController@delete')->name('admin.testimonial.delete');
    Route::post('/testimonial/bulk-action','TestimonialController@bulk_action')->name('admin.testimonial.bulk.action');

    //key features
    Route::get('/keyfeatures','KeyFeaturesController@index')->name('admin.keyfeatures');
    Route::post('/keyfeatures','KeyFeaturesController@store');
    Route::post('/update-keyfeatures','KeyFeaturesController@update')->name('admin.keyfeatures.update');
    Route::post('/delete-keyfeatures/{id}','KeyFeaturesController@delete')->name('admin.keyfeatures.delete');
    Route::post('/feater-key/bulk-action','KeyFeaturesController@bulk_action')->name('admin.feature.key.bulk.action');
    //contact info
    Route::get('/contact-page/contact-info','ContactInfoController@index')->name('admin.contact.info');
    Route::post('/contact-page/contact-info','ContactInfoController@store');
    Route::post('/contact-page/contact-info/title','ContactInfoController@contact_info_title')->name('admin.contact.info.title');
    Route::post('contact-page/contact-info/update','ContactInfoController@update')->name('admin.contact.info.update');
    Route::post('contact-page/contact-info/delete/{id}','ContactInfoController@delete')->name('admin.contact.info.delete');
    Route::post('/contact-page/contact-info/bulk-action','ContactInfoController@bulk_action')->name('admin.contact.info.bulk.action');

    //services
    Route::get('/services-new','ServiceController@AddNew')->name('admin.services.new');
    Route::get('/services','ServiceController@index')->name('admin.services');
    Route::post('/services','ServiceController@store');
    Route::post('/services-cat-by-slug','ServiceController@category_by_slug')->name('admin.service.category.by.slug');
    Route::get('/edit-services/{id}','ServiceController@EditService')->name('admin.services.edit');
    Route::post('/update-services','ServiceController@update')->name('admin.services.update');
    Route::post('/delete-services/{id}','ServiceController@delete')->name('admin.services.delete');
    Route::post('/services/bulk-action','ServiceController@bulk_action')->name('admin.services.bulk.action');
    Route::get('/services/category','ServiceController@category_index')->name('admin.service.category');
    Route::post('/services/category','ServiceController@category_store');
    Route::post('/update-services-category','ServiceController@category_update')->name('admin.service.category.update');
    Route::post('/delete-services-category/{id}','ServiceController@category_delete')->name('admin.service.category.delete');
    Route::post('/service-category/bulk-action','ServiceController@category_bulk_action')->name('admin.service.category.bulk.action');
    Route::post('/services/clone','ServiceController@clone')->name('admin.services.clone');

    //form builder
    Route::group(['prefix' => '/'],function (){
        //form builder routes
        Route::get('/form-builder/quote-form','FormBuilderController@quote_form_index')->name('admin.form.builder.quote');
        Route::post('/form-builder/quote-form','FormBuilderController@update_quote_form');
        Route::get('/form-builder/order-form','FormBuilderController@order_form_index')->name('admin.form.builder.order');
        Route::post('/form-builder/order-form','FormBuilderController@update_order_form');
        Route::get('/form-builder/contact-form','FormBuilderController@contact_form_index')->name('admin.form.builder.contact');
        Route::post('/form-builder/contact-form','FormBuilderController@update_contact_form');
    });


    //works
    Route::get('/works','WorksController@index')->name('admin.work');
    Route::get('/works/add','WorksController@add')->name('admin.work.add');
    Route::post('/works','WorksController@store');
    Route::post('/works/clone','WorksController@clone')->name('admin.work.clone');
    Route::get('/works/edit/{id}','WorksController@edit')->name('admin.work.edit');
    Route::post('/update-works','WorksController@update')->name('admin.work.update');
    Route::post('/delete-works/{id}','WorksController@delete')->name('admin.work.delete');
    Route::post('/works/bulk-action','WorksController@bulk_action')->name('admin.work.bulk.action');
    Route::post('/works-cat-by-slug','WorksController@category_by_slug')->name('admin.work.category.by.slug');
    //works image
    Route::get('/works/image','WorksController@works_image')->name('admin.work.image');
    Route::get('/works/add_image','WorksController@add_image')->name('admin.work.add_image');
    Route::post('/works/add_image','WorksController@store_image')->name('admin.work.store_image');
    Route::get('/works/edit_image/{id}','WorksController@edit_image')->name('admin.work.edit_image');
    Route::post('/works/edit_image/{id}','WorksController@update_image')->name('admin.work.update_image');
    Route::post('/delete-works-image/{id}','WorksController@delete_image')->name('admin.work.delete.image');
    Route::post('/works/bulk-action-image','WorksController@bulk_action_image')->name('admin.work.bulk.action.image');
    Route::get('/works/image/get_product_by_lang_ajax','WorksController@get_product_by_lang_ajax')->name('admin.work.image.get_product_by_lang_ajax');

    Route::get('/works/oem','WorksController@oem_index')->name('admin.work.oem');
    Route::post('/works/oem','WorksController@store_oem')->name('admin.work.store.oem');
    Route::post('/update-works-oem','WorksController@update_oem')->name('admin.work.update.oem');
    Route::post('/delete-works-oem/{id}','WorksController@delete_oem')->name('admin.work.delete.oem');
    Route::post('/works/oem/bulk-action','WorksController@oem_bulk_action')->name('admin.work.oem.bulk.action');

    Route::get('/works/industry','WorksController@industry_index')->name('admin.work.industry');
    Route::post('/works/industry','WorksController@store_industry')->name('admin.work.store.industry');
    Route::post('/update-works-industry','WorksController@update_industry')->name('admin.work.update.industry');
    Route::post('/delete-works-industry/{id}','WorksController@delete_industry')->name('admin.work.delete.industry');
    Route::post('/works/industry/bulk-action','WorksController@industry_bulk_action')->name('admin.work.industry.bulk.action');

    Route::get('/works/packaging','WorksController@packaging_index')->name('admin.work.packaging');
    Route::post('/works/packaging','WorksController@store_packaging')->name('admin.work.store.packaging');
    Route::post('/update-works-packaging','WorksController@update_packaging')->name('admin.work.update.packaging');
    Route::post('/delete-works-packaging/{id}','WorksController@delete_packaging')->name('admin.work.delete.packaging');
    Route::post('/works/packaging/bulk-action','WorksController@packaging_bulk_action')->name('admin.work.packaging.bulk.action');

    Route::get('/works/category','WorksController@category_index')->name('admin.work.category');
    Route::post('/works/category','WorksController@category_store');
    Route::post('/update-works-category','WorksController@category_update')->name('admin.work.category.update');
    Route::post('/delete-works-category/{id}','WorksController@category_delete')->name('admin.work.category.delete');
    Route::post('/works/category/bulk-action','WorksController@category_bulk_action')->name('admin.work.category.bulk.action');

    Route::get('/works/subcategory','WorksController@subcategory_index')->name('admin.work.subcategory');
    Route::post('/works/subcategory','WorksController@subcategory_store');
    Route::post('/update-works-subcategory','WorksController@subcategory_update')->name('admin.work.subcategory.update');
    Route::post('/delete-works-subcategory/{id}','WorksController@subcategory_delete')->name('admin.work.subcategory.delete');
    Route::post('/works/subcategory/bulk-action','WorksController@subcategory_bulk_action')->name('admin.work.subcategory.bulk.action');
    Route::get('/works/subcategory/get_category_by_lang_ajax','WorksController@get_category_by_lang_ajax')->name('admin.work.subcategory.get_category_by_lang_ajax');

    
    Route::get('/works/sectors','WorksController@sectors_index')->name('admin.work.sectors');
    Route::post('/works/sectors','WorksController@sectors_store');
    Route::post('/update-works-sectors','WorksController@sectors_update')->name('admin.work.sectors.update');
    Route::post('/delete-works-sectors/{id}','WorksController@sectors_delete')->name('admin.work.sectors.delete');
    Route::post('/works/sectors/bulk-action','WorksController@sectors_bulk_action')->name('admin.work.sectors.bulk.action');

    // TDS Requests
    Route::get('/tds-requests','TdsRequestsController@index')->name('admin.tdsrequests');

    // Session lang change
    Route::get('/set_lang/{name}', 'FrontendController@set_lang')->name('set.lang');

    //brand logos
    Route::get('/brands','BrandController@index')->name('admin.brands');
    Route::post('/brands','BrandController@store');
    Route::post('/update-brands','BrandController@update')->name('admin.brands.update');
    Route::post('/delete-brands/{id}','BrandController@delete')->name('admin.brands.delete');
    Route::post('/brands/bulk-action','BrandController@bulk_action')->name('admin.brands.bulk.action');

    //faq
    Route::get('/faq','FaqController@index')->name('admin.faq');
    Route::post('/faq','FaqController@store');
    Route::post('/update-faq','FaqController@update')->name('admin.faq.update');
    Route::post('/delete-faq/{id}','FaqController@delete')->name('admin.faq.delete');
    Route::post('/faq/bulk-action','FaqController@bulk_action')->name('admin.faq.bulk.action');

    //header slider
    Route::get('/header','HeaderSliderController@index')->name('admin.header');
    Route::post('/header','HeaderSliderController@store');
    Route::post('/update-header','HeaderSliderController@update')->name('admin.header.update');
    Route::post('/delete-header/{id}','HeaderSliderController@delete')->name('admin.header.delete');
    Route::post('/header/bulk-action','HeaderSliderController@bulk_action')->name('admin.header.bulk.action');

    //price plan
    Route::get('/price-plan','PricePlanController@index')->name('admin.price.plan');
    Route::post('/price-plan','PricePlanController@store');
    Route::post('/update-price-plan','PricePlanController@update')->name('admin.price.plan.update');
    Route::post('/delete-price-plan/{id}','PricePlanController@delete')->name('admin.price.plan.delete');
    Route::post('/price-plan/bulk-action','PricePlanController@bulk_action')->name('admin.price.plan.bulk.action');

    //team member
    Route::get('/team-member','TeamMemberController@index')->name('admin.team.member');
    Route::post('/team-member','TeamMemberController@store');
    Route::post('/update-team-member','TeamMemberController@update')->name('admin.team.member.update');
    Route::post('/delete-team-member/{id}','TeamMemberController@delete')->name('admin.team.member.delete');
    Route::post('/team-member/bulk-action','TeamMemberController@bulk_action')->name('admin.team.member.bulk.action');

    //home page one
    Route::get('/home-page-01/counterup','HomePageController@home_01_counterup')->name('admin.homeone.counterup');
    Route::post('/home-page-01/counterup','HomePageController@home_01_update_counterup');
    Route::get('/home-page-01/latest-news','HomePageController@home_01_latest_news')->name('admin.homeone.latest.news');
    Route::post('/home-page-01/latest-news','HomePageController@home_01_update_latest_news');
    Route::get('/home-page-01/testimonial','HomePageController@home_01_testimonial')->name('admin.homeone.testimonial');
    Route::post('/home-page-01/testimonial','HomePageController@home_01_update_testimonial');
    Route::get('/home-page-01/service-area','HomePageController@home_01_service_area')->name('admin.homeone.service.area');
    Route::post('/home-page-01/service-area','HomePageController@home_01_update_service_area');
    Route::get('/home-page-01/recent-work','HomePageController@home_01_recent_work')->name('admin.homeone.recent.work');
    Route::post('/home-page-01/recent-work','HomePageController@home_01_update_recent_work');
    Route::get('/home-page-01/build-dream','HomePageController@home_01_build_dream')->name('admin.homeone.build.dream');
    Route::post('/home-page-01/build-dream','HomePageController@home_01_update_build_dream');

    Route::get('/home-page-01/newsletter','HomePageController@home_01_newsletter')->name('admin.homeone.newsletter');
    Route::post('/home-page-01/newsletter','HomePageController@home_01_update_newsletter');

    //section manage
    Route::get('/home-page-01/section-manage','HomePageController@home_01_section_manage')->name('admin.homeone.section.manage');
    Route::post('/home-page-01/section-manage','HomePageController@home_01_update_section_manage');
    Route::get('/home-page-01/price-plan','HomePageController@home_01_price_plan')->name('admin.homeone.price.plan');
    Route::post('/home-page-01/price-plan','HomePageController@home_01_update_price_plan');

    Route::get('/home-page-01/team-member','HomePageController@home_01_team_member')->name('admin.homeone.team.member');
    Route::post('/home-page-01/team-member','HomePageController@home_01_update_team_member');

    //about page
    Route::get('/about-page/about-us','AboutPageController@about_page_about_section')->name('admin.about.page.about');
    Route::post('/about-page/about-us','AboutPageController@about_page_update_about_section');
    Route::get('/about-page/team-member','AboutPageController@about_page_team_member_section')->name('admin.about.team.member');
    Route::post('/about-page/team-member','AboutPageController@about_page_update_team_member_section');

    //service page
    Route::get('/service-page/price-plan','ServicePageController@service_page_price_plan_section')->name('admin.service.page.price.plan');
    Route::post('/service-page/price-plan','ServicePageController@service_page_update_price_plan_section');
    Route::get('/service-page/cta','ServicePageController@service_page_cta_section')->name('admin.service.page.cta');
    Route::post('/service-page/cta','ServicePageController@service_page_update_cta_section');

    //team page
    Route::get('/team-page/about-team','TeamPageController@team_page_about_section')->name('admin.team.page.about');
    Route::post('/team-page/about-team','TeamPageController@team_page_update_about_section');
    Route::get('/team-page/team-member','TeamPageController@team_page_team_section')->name('admin.team.page.team.member');
    Route::post('/team-page/team-member','TeamPageController@team_page_update_team_section');

    //team page
    Route::get('/contact-page/form-area','ContactPageController@contact_page_form_area')->name('admin.contact.page.form.area');
    Route::post('/contact-page/form-area','ContactPageController@contact_page_update_form_area');
    Route::get('/contact-page/map','ContactPageController@contact_page_map_area')->name('admin.contact.page.map');
    Route::post('/contact-page/map','ContactPageController@contact_page_update_map_area');

    //footer
    Route::get('/footer/about','FooterController@about_widget')->name('admin.footer.about');
    Route::post('/footer/about','FooterController@update_about_widget');
    Route::get('/footer/general','FooterController@general_widget')->name('admin.footer.general');
    Route::post('/footer/general','FooterController@update_general_widget');
    Route::get('/footer/useful-links','FooterController@useful_links_widget')->name('admin.footer.useful.link');
    Route::post('/footer/useful-links/widget','FooterController@update_widget_useful_links')->name('admin.footer.useful.link.widget');
    Route::post('/footer/useful-links','FooterController@new_useful_links_widget');
    Route::post('/footer/useful-links/update','FooterController@update_useful_links_widget')->name('admin.footer.useful.link.update');
    Route::post('/footer/useful-links/update/{delete}','FooterController@delete_useful_links_widget')->name('admin.footer.useful.link.delete');
    Route::post('/footer/useful-links/menu','FooterController@useful_links_widget_menu_by_slug')->name('admin.footer.useful.link.menus');
    Route::get('/footer/recent-post','FooterController@recent_post_widget')->name('admin.footer.recent.post');
    Route::post('/footer/recent-post','FooterController@update_recent_post_widget');

    Route::get('/footer/important-links','FooterController@important_links_widget')->name('admin.footer.important.link');
    Route::post('/footer/important-links/widget','FooterController@update_widget_important_links')->name('admin.footer.important.link.widget');
    Route::post('/footer/important-links','FooterController@new_important_links_widget');
    Route::post('/footer/important-links/update','FooterController@update_important_links_widget')->name('admin.footer.important.link.update');
    Route::post('/footer/important-links/slug','FooterController@important_links_widget_menu_by_slug')->name('admin.footer.important.link.menu');
    Route::post('/footer/important-links/update/{delete}','FooterController@delete_important_links_widget')->name('admin.footer.important.link.delete');

    //newsletter
    Route::get('/newsletter','NewsletterController@index')->name('admin.newsletter');
    Route::post('/newsletter/delete/{id}','NewsletterController@delete')->name('admin.newsletter.delete');
    Route::post('/newsletter/new','NewsletterController@add_new_sub')->name('admin.newsletter.new.add');
    Route::post('/newsletter/single','NewsletterController@send_mail')->name('admin.newsletter.single.mail');
    Route::get('/newsletter/all','NewsletterController@send_mail_all_index')->name('admin.newsletter.mail');
    Route::post('/newsletter/all','NewsletterController@send_mail_all');
    Route::post('/newsletter/verify-mail-send','NewsletterController@verify_mail_send')->name('admin.newsletter.verify.mail.send');
    Route::post('/newsletter/bulk-action','NewsletterController@bulk_action')->name('admin.newsletter.bulk.action');

    //quote
    Route::get('/quote-manage/all','QuoteManageController@all_quotes')->name('admin.quote.manage.all');
    Route::get('/quote-manage/pending','QuoteManageController@pending_quotes')->name('admin.quote.manage.pending');
    Route::get('/quote-manage/completed','QuoteManageController@completed_quotes')->name('admin.quote.manage.completed');
    Route::post('/quote-manage/change-status','QuoteManageController@change_status')->name('admin.quote.manage.change.status');
    Route::post('/quote-manage/send-mail','QuoteManageController@send_mail')->name('admin.quote.manage.send.mail');
    Route::post('/quote-manage/delete/{id}','QuoteManageController@quote_delete')->name('admin.quote.manage.delete');
    Route::post('/quote-manage/bulk-action','QuoteManageController@bulk_action')->name('admin.quote.manage.bulk.action');

    Route::get('/quote-page','QuotePageController@index')->name('admin.quote.page');
    Route::post('/quote-page','QuotePageController@udpate');

    //order
    Route::get('/order-page','OrderPageController@index')->name('admin.order.page');
    Route::post('/order-page','OrderPageController@udpate');

    //topbar
    Route::get('/topbar','TopBarController@index')->name('admin.topbar');
    Route::post('/topbar/new-support-info','TopBarController@new_support_info')->name('admin.new.support.info');
    Route::post('/topbar/update-support-info','TopBarController@update_support_info')->name('admin.update.support.info');
    Route::post('/topbar/delete-support-info/{id}','TopBarController@delete_support_info')->name('admin.delete.support.info');
    Route::post('/topbar/new-social-item','TopBarController@new_social_item')->name('admin.new.social.item');
    Route::post('/topbar/update-social-item','TopBarController@update_social_item')->name('admin.update.social.item');
    Route::post('/topbar/delete-social-item/{id}','TopBarController@delete_social_item')->name('admin.delete.social.item');

    //menu manage
    Route::get('/menu','MenuController@index')->name('admin.menu');
    Route::post('/new-menu','MenuController@store_new_menu')->name('admin.menu.new');
    Route::get('/menu-edit/{id}','MenuController@edit_menu')->name('admin.menu.edit');
    Route::post('/menu-update/{id}','MenuController@update_menu')->name('admin.menu.update');
    Route::post('/menu-delete/{id}','MenuController@delete_menu')->name('admin.menu.delete');
    Route::post('/menu-default/{id}','MenuController@set_default_menu')->name('admin.menu.default');
    Route::post('/mega-menu','MenuController@mega_menu_item_select_markup')->name('admin.mega.menu.item.select.markup');

    //pages
    Route::get('/page','PagesController@index')->name('admin.page');
    Route::get('/new-page','PagesController@new_page')->name('admin.page.new');
    Route::post('/new-page','PagesController@store_new_page');
    Route::get('/page-edit/{id}','PagesController@edit_page')->name('admin.page.edit');
    Route::post('/page-update/{id}','PagesController@update_page')->name('admin.page.update');
    Route::post('/page-delete/{id}','PagesController@delete_page')->name('admin.page.delete');

    //blog
    Route::get('/blog','BlogController@index')->name('admin.blog');
    Route::get('/new-blog','BlogController@new_blog')->name('admin.blog.new');
    Route::post('/new-blog','BlogController@store_new_blog');
    Route::get('/blog-edit/{id}','BlogController@edit_blog')->name('admin.blog.edit');
    Route::post('/blog-update/{id}','BlogController@update_blog')->name('admin.blog.update');
    Route::post('/blog-delete/{id}','BlogController@delete_blog')->name('admin.blog.delete');
    Route::get('/blog-category','BlogController@category')->name('admin.blog.category');
    Route::post('/blog-category','BlogController@new_category');
    Route::post('/delete-blog-category/{id}','BlogController@delete_category')->name('admin.blog.category.delete');
    Route::post('/update-blog-category','BlogController@update_category')->name('admin.blog.category.update');
    Route::post('/blog-lang-by-cat','BlogController@Language_by_slug')->name('admin.blog.lang.cat');
    Route::post('/blog/clone','BlogController@clone_blog')->name('admin.blog.clone');
    //bulk action
    Route::post('/blog/bulk-action','BlogController@bulk_action')->name('admin.blog.bulk.action');
    Route::post('/blog/category/bulk-action','BlogController@category_bulk_action')->name('admin.blog.category.bulk.action');

    //user role management
    Route::get('/new-user','UserRoleManageController@new_user')->name('admin.new.user');
    Route::post('/new-user','UserRoleManageController@new_user_add');
    Route::post('/user-update','UserRoleManageController@user_update')->name('admin.user.update');
    Route::post('/user-password-chnage','UserRoleManageController@user_password_change')->name('admin.user.password.change');
    Route::post('/delete-user/{id}','UserRoleManageController@new_user_delete')->name('admin.delete.user');
    Route::get('/all-user','UserRoleManageController@all_user')->name('admin.all.user');

    //admin settings
    Route::get('/settings','AdminDashboardController@admin_settings')->name('admin.profile.settings');
    Route::get('/profile-update','AdminDashboardController@admin_profile')->name('admin.profile.update');
    Route::post('/profile-update','AdminDashboardController@admin_profile_update');
    Route::get('/password-change','AdminDashboardController@admin_password')->name('admin.password.change');
    Route::post('/password-change','AdminDashboardController@admin_password_chagne');


    //general settings
    Route::get('/general-settings/site-identity','AdminDashboardController@site_identity')->name('admin.general.site.identity');
    Route::post('/general-settings/site-identity','AdminDashboardController@update_site_identity');
    Route::get('/general-settings/basic-settings','AdminDashboardController@basic_settings')->name('admin.general.basic.settings');
    Route::post('/general-settings/basic-settings','AdminDashboardController@update_basic_settings');
    Route::get('/general-settings/seo-settings','AdminDashboardController@seo_settings')->name('admin.general.seo.settings');
    Route::post('/general-settings/seo-settings','AdminDashboardController@update_seo_settings');
    Route::get('/general-settings/scripts','AdminDashboardController@scripts_settings')->name('admin.general.scripts.settings');
    Route::post('/general-settings/scripts','AdminDashboardController@update_scripts_settings');
    Route::get('/general-settings/page-settings','AdminDashboardController@page_settings')->name('admin.general.page.settings');
    Route::post('/general-settings/page-settings','AdminDashboardController@update_page_settings');
    Route::get('/general-settings/email-template','AdminDashboardController@email_template_settings')->name('admin.general.email.template');
    Route::post('/general-settings/email-template','AdminDashboardController@update_email_template_settings');

    Route::get('/general-settings/payment-settings', 'GeneralSettingsController@payment_settings')->name('admin.general.payment.settings');
    Route::post('/general-settings/payment-settings', 'GeneralSettingsController@update_payment_settings');
    Route::post('/general-settings/email-settings', 'GeneralSettingsController@update_email_settings');
    Route::get('/general-settings/typography-settings', 'GeneralSettingsController@typography_settings')->name('admin.general.typography.settings');
    Route::post('/general-settings/typography-settings', 'GeneralSettingsController@update_typography_settings');
    Route::post('/general-settings/typography-settings/single', 'GeneralSettingsController@get_single_font_variant')->name('admin.general.typography.single');



    /* media upload routes */
    Route::post('/media-upload/all','MediaUploadController@all_upload_media_file')->name('admin.upload.media.file.all');
    Route::post('/media-upload','MediaUploadController@upload_media_file')->name('admin.upload.media.file');
    Route::get('/media-upload/page','MediaUploadController@all_upload_media_images_for_page')->name('admin.upload.media.images.page');

    Route::post('/media-upload/delete','MediaUploadController@delete_upload_media_file')->name('admin.upload.media.file.delete');
    Route::post('/media-upload/alt','MediaUploadController@alt_change_upload_media_file')->name('admin.upload.media.file.alt.change');
    /* media upload routes end */

    //new settings
    Route::get('/general-settings/cache-settings','AdminDashboardController@cache_settings')->name('admin.general.cache.settings');
    Route::post('/general-settings/cache-settings','AdminDashboardController@update_cache_settings');
    Route::get('/general-settings/update-system','AdminDashboardController@update_system')->name('admin.general.update.system');
    Route::post('/general-settings/update-system','AdminDashboardController@update_system_version');
    Route::get('/general-settings/license-setting','GeneralSettingsController@license_settings')->name('admin.general.license.settings');
    Route::post('/general-settings/license-setting','GeneralSettingsController@update_license_settings');
    Route::get('/general-settings/custom-css','AdminDashboardController@custom_css_settings')->name('admin.general.custom.css');
    Route::post('/general-settings/custom-css','AdminDashboardController@update_custom_css_settings');
    //smtp settings
    Route::get('/general-settings/smtp-settings','AdminDashboardController@smtp_settings')->name('admin.general.smtp.settings');
    Route::post('/general-settings/smtp-settings','AdminDashboardController@update_smtp_settings');

    //language
     Route::get('/languages','LanguageController@index')->name('admin.languages');
     Route::get('/languages/words/frontend/{id}','LanguageController@frontend_edit_words')->name('admin.languages.words.frontend');
     Route::get('/languages/words/backend/{id}','LanguageController@backend_edit_words')->name('admin.languages.words.backend');
     Route::post('/languages/words/update/{id}','LanguageController@update_words')->name('admin.languages.words.update');
     Route::post('/languages/new','LanguageController@store')->name('admin.languages.new');
     Route::post('/languages/update','LanguageController@update')->name('admin.languages.update');
     Route::post('/languages/delete/{id}','LanguageController@delete')->name('admin.languages.delete');
     Route::post('/languages/default/{id}','LanguageController@make_default')->name('admin.languages.default');
     Route::post('/languages/clone','LanguageController@clone_languages')->name('admin.languages.clone');
     Route::post('/languages/add-new-string','LanguageController@add_new_string')->name('admin.languages.add.string');

});

Route::prefix('admin-home')->group(function (){
    //widger manage
    Route::get('/widgets','WidgetsController@index')->name('admin.widgets');
    Route::post('/widgets/create','WidgetsController@new_widget')->name('admin.widgets.new');
    Route::post('/widgets/markup','WidgetsController@widget_markup')->name('admin.widgets.markup');
    Route::post('/widgets/update','WidgetsController@update_widget')->name('admin.widgets.update');
    Route::post('/widgets/update/order','WidgetsController@update_order_widget')->name('admin.widgets.update.order');
    Route::post('/widgets/delete','WidgetsController@delete_widget')->name('admin.widgets.delete');
});

/*----------------------------------------------------------------------------------------------------------------------------
| PACKAGE ORDER MANAGE
|----------------------------------------------------------------------------------------------------------------------------*/
Route::prefix('package')->group(function (){

    //payment log route
    Route::get('/payment-logs','OrderManageController@all_payment_logs')->name('admin.payment.logs');
    Route::post('/payment-logs/delete/{id}','OrderManageController@payment_logs_delete')->name('admin.payment.delete');
    Route::post('/payment-logs/approve/{id}','OrderManageController@payment_logs_approve')->name('admin.payment.approve');
    Route::post('/payment-logs/bulk-action','OrderManageController@payment_log_bulk_action')->name('admin.payment.bulk.action');
    Route::get('/payment-logs/report','OrderManageController@payment_report')->name('admin.payment.report');

    Route::get('/order-manage/all','OrderManageController@all_orders')->name('admin.package.order.manage.all');
    Route::get('/order-manage/pending','OrderManageController@pending_orders')->name('admin.package.order.manage.pending');
    Route::get('/order-manage/completed','OrderManageController@completed_orders')->name('admin.package.order.manage.completed');
    Route::get('/order-manage/in-progress','OrderManageController@in_progress_orders')->name('admin.package.order.manage.in.progress');
    Route::post('/order-manage/change-status','OrderManageController@change_status')->name('admin.package.order.manage.change.status');
    Route::post('/order-manage/send-mail','OrderManageController@send_mail')->name('admin.package.order.manage.send.mail');
    Route::post('/order-manage/delete/{id}','OrderManageController@order_delete')->name('admin.package.order.manage.delete');
    //thank you page
    Route::get('/order-manage/success-page','OrderManageController@order_success_payment')->name('admin.package.order.success.page');
    Route::post('/order-manage/success-page','OrderManageController@update_order_success_payment');
    //cancel page
    Route::get('/order-manage/cancel-page','OrderManageController@order_cancel_payment')->name('admin.package.order.cancel.page');
    Route::post('/order-manage/cancel-page','OrderManageController@update_order_cancel_payment');
    Route::get('/order-page','OrderPageController@index')->name('admin.package.order.page');
    Route::post('/order-page','OrderPageController@udpate');
    Route::post('/order-manage/bulk-action','OrderManageController@bulk_action')->name('admin.package.order.bulk.action');
    Route::post('/order-manage/reminder','OrderManageController@order_reminder')->name('admin.package.order.reminder');
    Route::get('/order-report','OrderManageController@order_report')->name('admin.package.order.report');
});
