<div class="sidebar-menu">
    <div class="sidebar-header">
        <div class="logo">
            <a href="{{route('admin.home')}}">
                {!! render_image_markup_by_attachment_id(get_static_option('site_logo')) !!}
            </a>
        </div>
    </div>
    <div class="main-menu">
        <div class="menu-inner">
            <nav>
                <ul class="metismenu" id="menu">
                    <li class="{{active_menu('admin-home')}}">
                        <a href="{{route('admin.home')}}"
                           aria-expanded="true">
                            <i class="ti-dashboard"></i>
                            <span>@lang('dashboard')</span>
                        </a>
                    </li>
                    @if('super_admin' == auth()->user()->role)
                    <!-- <li
                        class="
                        {{active_menu('admin-home/new-user')}}
                        {{active_menu('admin-home/all-user')}}
                        "
                    >
                        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-user"></i> <span>{{__('Admin Role Manage')}}</span></a>
                        <ul class="collapse">
                            <li class="{{active_menu('admin-home/all-user')}}"><a href="{{route('admin.all.user')}}">{{__('All Admin')}}</a></li>
                            <li class="{{active_menu('admin-home/new-user')}}"><a href="{{route('admin.new.user')}}">{{__('Add New Admin')}}</a></li>
                        </ul>
                    </li>
                        <li
                            class="
                            {{active_menu('admin-home/newsletter')}}
                            @if(request()->is('admin-home/newsletter/*')) active @endif
                            "
                        >
                            <a href="javascript:void(0)" aria-expanded="true"><i class="ti-email"></i> <span>{{__('Newsletter Manage')}}</span></a>
                            <ul class="collapse">
                                <li class="{{active_menu('admin-home/newsletter')}}"><a href="{{route('admin.newsletter')}}">{{__('All Subscriber')}}</a></li>
                                <li class="{{active_menu('admin-home/newsletter/all')}}"><a href="{{route('admin.newsletter.mail')}}">{{__('Send Mail To All')}}</a></li>
                            </ul>
                        </li> -->
                    @endif

                  <!-- <li class="main_dropdown @if(request()->is(['package/payment-logs','package/payment-logs/report/*','package/order-manage/*','package/order-page','package/order-report'])) active @endif">
                  <a href="javascript:void(0)" aria-expanded="true">
                      <i class="ti-package"></i>
                      <span>{{__('Package Orders Manage')}}</span></a>
                  <ul class="collapse">

                      <li class="{{active_menu('package/order-manage/all')}}"><a
                                  href="{{route('admin.package.order.manage.all')}}">{{__('All Order')}}</a></li>

                      <li class="{{active_menu('package/order-manage/pending')}}"><a
                                  href="{{route('admin.package.order.manage.pending')}}">{{__('Pending Order')}}</a></li>

                      <li class="{{active_menu('package/order-manage/in-progress')}}"><a
                                  href="{{route('admin.package.order.manage.in.progress')}}">{{__('In Progress Order')}}</a></li>

                      <li class="{{active_menu('package/order-manage/completed')}}"><a
                                  href="{{route('admin.package.order.manage.completed')}}">{{__('Completed Order')}}</a></li>

                      <li class="{{active_menu('package/order-manage/success-page')}}"><a
                                  href="{{route('admin.package.order.success.page')}}">{{__('Success Order Page')}}</a></li>

                      <li class="{{active_menu('package/order-manage/cancel-page')}}"><a
                                  href="{{route('admin.package.order.cancel.page')}}">{{__('Cancel Order Page')}}</a></li>

                      <li class="{{active_menu('package/order-page')}}">
                          <a href="{{route('admin.package.order.page')}}">{{__('Order Page Manage')}}</a>
                      </li>

                      <li class="{{active_menu('package/order-report')}}">
                          <a href="{{route('admin.package.order.report')}}">{{__('Order Report')}}</a>
                      </li>

                      <li class="{{active_menu('package/payment-logs')}}"><a
                                  href="{{route('admin.payment.logs')}}">{{__('All Payment Logs')}}</a></li>

                      <li class="{{active_menu('package/payment-logs/report')}}"><a
                                  href="{{route('admin.payment.report')}}">{{__('Payment Report')}}</a></li>
                  </ul>
                  </li> -->

                        <!-- <li class="{{active_menu('admin-home/home-variant')}}">
                            <a href="{{route('admin.home.variant')}}"
                               aria-expanded="true">
                                <i class="ti-file"></i>
                                <span>{{__('Home Variant')}}</span>
                            </a>
                        </li> -->

                        <!-- <li class="{{active_menu('admin-home/navbar-settings')}}">
                            <a href="{{route('admin.navbar.settings')}}"
                               aria-expanded="true">
                                <i class="ti-file"></i>
                                <span>{{__('Nabvar Settings')}}</span>
                            </a>
                        </li> -->
                        <li class="@if(request()->is('admin-home/home-page-01/*')  ) active @endif
                        {{active_menu('admin-home/header')}}
                        {{active_menu('admin-home/keyfeatures')}}
                                ">
                            <a href="javascript:void(0)"
                               aria-expanded="true">
                                <i class="ti-home"></i>
                                <span>{{__('Home Page Manage')}}</span>
                            </a>
                            <ul class="collapse">
                                <!-- <li class="{{active_menu('admin-home/header')}}">
                                    <a href="{{route('admin.header')}}" >
                                        {{__('Header Area')}}
                                    </a>
                                </li> -->
                                <!-- <li class="{{active_menu('admin-home/keyfeatures')}}">
                                    <a href="{{route('admin.keyfeatures')}}">{{__('Key Features')}}</a>
                                </li> -->

                                <li class="{{active_menu('admin-home/home-page-01/build-dream')}}"><a href="{{route('admin.homeone.build.dream')}}">Home Hero Area</a></li>
                                <!-- <li class="{{active_menu('admin-home/home-page-01/build-dream')}}"><a href="{{route('admin.homeone.build.dream')}}">{{__('Build Dream Area')}}</a></li> -->

                                
                                <!-- <li class="{{active_menu('admin-home/home-page-01/service-area')}}"><a href="{{route('admin.homeone.service.area')}}">{{__('Service Area')}}</a></li> -->
                                <!-- <li class="{{active_menu('admin-home/home-page-01/counterup')}}"><a href="{{route('admin.homeone.counterup')}}">{{__('Counterup Area')}}</a></li> -->
                                <!-- <li class="{{active_menu('admin-home/home-page-01/recent-work')}}"><a href="{{route('admin.homeone.recent.work')}}">{{__('Recent Work Area')}}</a></li> -->
                                <li class="{{active_menu('admin-home/home-page-01/testimonial')}}"><a href="{{route('admin.homeone.testimonial')}}">{{__('Testimonial Area')}}</a></li>
                                <!-- <li class="{{active_menu('admin-home/home-page-01/latest-news')}}"><a href="{{route('admin.homeone.latest.news')}}">{{__('Latest News Area')}}</a></li> -->
                                <!-- @if(get_static_option('home_page_variant') == '02' || get_static_option('home_page_variant') == '03')
                                <li class="{{active_menu('admin-home/home-page-01/price-plan')}}"> <a href="{{route('admin.homeone.price.plan')}}">{{__('Price Plan Area')}}</a></li>
                                @endif
                                @if(get_static_option('home_page_variant') == '03')
                                    <li class="{{active_menu('admin-home/home-page-01/team-member')}}"> <a href="{{route('admin.homeone.team.member')}}">{{__('Team Member Area')}}</a></li>
                                @endif
                                <li class="{{active_menu('admin-home/home-page-01/newsletter')}}"> <a href="{{route('admin.homeone.newsletter')}}">{{__('Newsletter Area')}}</a></li>
                                <li class="{{active_menu('admin-home/home-page-01/section-manage')}}"> <a href="{{route('admin.homeone.section.manage')}}">{{__('Section Manage')}}</a></li> -->
                            </ul>
                        </li>

                        <!-- <li class="@if(request()->is('admin-home/about-page/*')  ) active @endif ">
                            <a href="javascript:void(0)"
                               aria-expanded="true">
                                <i class="ti-home"></i>
                                <span>{{__('About Page Manage')}}</span>
                            </a>
                            <ul class="collapse">
                                <li class="{{active_menu('admin-home/about-page/about-us')}}"><a href="{{route('admin.about.page.about')}}">{{__('About Us Section')}}</a></li>
                                <li class="{{active_menu('admin-home/about-page/team-member')}}"><a href="{{route('admin.about.team.member')}}">{{__('Team Member Section')}}</a></li>

                            </ul>
                        </li> -->
                        <!-- <li class="@if(request()->is('admin-home/service-page/*')  ) active @endif
                                ">
                            <a href="javascript:void(0)"
                               aria-expanded="true">
                                <i class="ti-home"></i>
                                <span>{{__('Service Page Manage')}}</span>
                            </a>
                            <ul class="collapse">
                                <li class="{{active_menu('admin-home/service-page/price-plan')}}"><a href="{{route('admin.service.page.price.plan')}}">{{__('Price Plan Section')}}</a></li>
                                <li class="{{active_menu('admin-home/service-page/cta')}}"><a href="{{route('admin.service.page.cta')}}">{{__('Call TO Action Section')}}</a></li>
                            </ul>
                        </li> -->
                        <!-- <li class="@if(request()->is('admin-home/team-page/*')  ) active @endif">
                            <a href="javascript:void(0)"
                               aria-expanded="true">
                                <i class="ti-home"></i>
                                <span>{{__('Team Page Manage')}}</span>
                            </a>
                            <ul class="collapse">
                                <li class="{{active_menu('admin-home/team-page/about-team')}}"><a href="{{route('admin.team.page.about')}}">{{__('About Team Section')}}</a></li>
                                <li class="{{active_menu('admin-home/team-page/team-member')}}"><a href="{{route('admin.team.page.team.member')}}">{{__('Team Members Section')}}</a></li>
                            </ul>
                        </li> -->
                        <!-- <li class="@if(request()->is('admin-home/contact-page/*')  ) active @endif">
                            <a href="javascript:void(0)"
                               aria-expanded="true">
                                <i class="ti-home"></i>
                                <span>{{__('Contact Page Manage')}}</span>
                            </a>
                            <ul class="collapse">
                                <li class="{{active_menu('admin-home/contact-page/contact-info')}}"><a href="{{route('admin.contact.info')}}">{{__('Contact Info')}}</a></li>
                                <li class="{{active_menu('admin-home/contact-page/form-area')}}"><a href="{{route('admin.contact.page.form.area')}}">{{__('Form Area')}}</a></li>
                                <li class="{{active_menu('admin-home/contact-page/map')}}"><a href="{{route('admin.contact.page.map')}}">{{__('Google Map Area')}}</a></li>
                            </ul>
                        </li> -->

                        <!-- <li class="main_dropdown @if(request()->is('admin-home/quote-manage/*','admin-home/quote-page')) active @endif ">
                         <a href="javascript:void(0)" aria-expanded="true"><i class="ti-home"></i>
                             <span>{{__('Quote Manage')}}</span></a>
                         <ul class="collapse">
                             <li class="{{active_menu('admin-home/quote-manage/all')}}"><a
                                         href="{{route('admin.quote.manage.all')}}">{{__('All Quote')}}</a></li>
                             <li class="{{active_menu('admin-home/quote-manage/pending')}}"><a
                                         href="{{route('admin.quote.manage.pending')}}">{{__('Pending Quote')}}</a>
                             </li>
                             <li class="{{active_menu('admin-home/quote-manage/completed')}}"><a
                                         href="{{route('admin.quote.manage.completed')}}">{{__('Complete Quote')}}</a>
                             </li>
                             <li class="{{active_menu('admin-home/quote-page')}}">
                                 <a href="{{route('admin.quote.page')}}">{{__('Quote Page Manage')}}</a>

                             </li>
                         </ul>
                     </li> -->

                        <!-- <li class="{{active_menu('admin-home/order-page')}}">
                            <a href="{{route('admin.order.page')}}"
                               aria-expanded="true">
                                <i class="ti-dashboard"></i>
                                <span>{{__('Order Page Manage')}}</span>
                            </a>
                        </li> -->
                    <li class="{{active_menu('admin-home/topbar')}}">
                        <a href="{{route('admin.topbar')}}"
                           aria-expanded="true">
                            <i class="ti-dashboard"></i>
                            <!-- <span>{{__('Top Bar Settings')}}</span> -->
                            <span>Icon Settings</span>
                        </a>
                    </li>
                    <!-- <li class="{{active_menu('admin-home/widgets')}}">
                        <a href="{{route('admin.widgets')}}"
                           aria-expanded="true">
                            <i class="ti-dashboard"></i>
                            <span>{{__('Widget Builder')}}</span>
                        </a>
                    </li> -->

                    <li class="
                    @if(request()->is('admin-home/services/*')) active @endif
                    {{active_menu('admin-home/services')}}
                            ">
                        <a href="javascript:void(0)"
                           aria-expanded="true">
                            <i class="ti-layout"></i>
                            <span>{{__('Services')}}</span>
                        </a>
                        <ul class="collapse">
                            <li class="{{active_menu('admin-home/services')}}"><a href="{{route('admin.services')}}">{{__('All Services')}}</a></li>
                            <li class="{{active_menu('admin-home/services-new')}}"><a href="{{route('admin.services.new')}}">{{__('Add New')}}</a></li>
                            <li class="{{active_menu('admin-home/services/category')}}"><a href="{{route('admin.service.category')}}">{{__('Category')}}</a></li>
                        </ul>
                    </li>


                    <!-- <li class="
                    @if(request()->is('admin-home/works/*')) active @endif
                    {{active_menu('admin-home/works')}}
                            ">
                        <a href="javascript:void(0)"
                           aria-expanded="true">
                            <i class="ti-layout"></i>
                            <span>{{__('Works')}}</span>
                        </a>
                        <ul class="collapse">
                            <li class="{{active_menu('admin-home/works')}}"><a href="{{route('admin.work')}}">{{__('All Works')}}</a></li>
                            <li class="{{active_menu('admin-home/works/add')}}"><a href="{{route('admin.work.add')}}">{{__('Add New Work')}}</a></li>
                            <li class="{{active_menu('admin-home/works/category')}}"><a href="{{route('admin.work.category')}}">{{__('Category')}}</a></li>
                        </ul>
                    </li> -->
                    <li class="
                    @if(request()->is('admin-home/works/*')) active @endif
                    {{active_menu('admin-home/works')}}
                            ">
                        <a href="javascript:void(0)"
                           aria-expanded="true">
                            <i class="ti-layout"></i>
                            <span>Products</span>
                        </a>
                        <ul class="collapse">
                            <li class="{{active_menu('admin-home/works')}}"><a href="{{route('admin.work')}}">All Products</a></li>
                            <li class="{{active_menu('admin-home/works/image')}}"><a href="{{route('admin.work.image')}}">All Product Images</a></li>
                            <li class="{{active_menu('admin-home/works/add')}}"><a href="{{route('admin.work.add')}}">Add New Product</a></li>
                            <li class="{{active_menu('admin-home/works/add_image')}}"><a href="{{route('admin.work.add_image')}}">Add New Product Image</a></li>
                            <li class="{{active_menu('admin-home/works/category')}}"><a href="{{route('admin.work.category')}}">{{__('Category')}}</a></li>
                            <li class="{{active_menu('admin-home/works/subcategory')}}"><a href="{{route('admin.work.subcategory')}}">Subcategory</a></li>
                            <li class="{{active_menu('admin-home/works/sectors')}}"><a href="{{route('admin.work.sectors')}}">Sectors</a></li>
                            <li class="{{active_menu('admin-home/works/oem')}}"><a href="{{route('admin.work.oem')}}">OEMs</a></li>
                            <li class="{{active_menu('admin-home/works/industry')}}"><a href="{{route('admin.work.industry')}}">Industries</a></li>
                            <li class="{{active_menu('admin-home/works/packaging')}}"><a href="{{route('admin.work.packaging')}}">Packagings</a></li>
                        </ul>
                    </li>

                    <li class="{{active_menu('admin-home/tds-requests')}}">
                        <a href="{{route('admin.tdsrequests')}}" aria-expanded="true"><i class="ti-agenda"></i> <span>{{__('TDS Requests')}}</span></a>
                    </li>

                    
                    <!-- <li class="{{active_menu('admin-home/faq')}}">
                        <a href="{{route('admin.faq')}}" aria-expanded="true"><i class="ti-control-forward"></i> <span>{{__('Faq')}}</span></a>
                    </li> -->
                    <!-- <li class="{{active_menu('admin-home/brands')}}">
                        <a href="{{route('admin.brands')}}" aria-expanded="true"><i class="ti-control-forward"></i> <span>{{__('Brand Logos')}}</span></a>
                    </li> -->
                    <!-- <li class="{{active_menu('admin-home/price-plan')}}">
                        <a href="{{route('admin.price.plan')}}" aria-expanded="true"><i class="ti-control-forward"></i> <span>{{__('Price Plan')}}</span></a>
                    </li> -->
                    <!-- <li class="{{active_menu('admin-home/team-member')}}">
                        <a href="{{route('admin.team.member')}}" aria-expanded="true"><i class="ti-control-forward"></i> <span>{{__('Team Members')}}</span></a>
                    </li> -->


                    <li class="{{active_menu('admin-home/testimonial')}}">
                        <a href="{{route('admin.testimonial')}}" aria-expanded="true"><i class="ti-control-forward"></i> <span>{{__('Testimonial')}}</span></a>
                    </li>


                    <!-- <li class="{{active_menu('admin-home/blog-page')}}">
                        <a href="{{route('admin.blog.page')}}"
                           aria-expanded="true">
                            <i class="ti-file"></i>
                            <span>{{__('Blog Page')}}</span>
                        </a>
                    </li>
                    <li class="{{active_menu('admin-home/counterup')}}">
                        <a href="{{route('admin.counterup')}}" aria-expanded="true"><i class="ti-exchange-vertical"></i> <span>{{__('Counterup')}}</span></a>
                    </li> -->

                    @if('super_admin' == auth()->user()->role || 'admin' == auth()->user()->role || 'editor' == auth()->user()->role)
                        <li
                                class="
                        {{active_menu('admin-home/blog')}}
                                {{active_menu('admin-home/blog-category')}}
                                {{active_menu('admin-home/new-blog')}}
                                @if(request()->is('admin-home/blog-edit/*')) active @endif
                                        "
                        >
                            <a href="javascript:void(0)" aria-expanded="true"><i class="ti-write"></i> <span>{{__('Blogs')}}</span></a>
                            <ul class="collapse">
                                <li class="{{active_menu('admin-home/blog')}}"><a href="{{route('admin.blog')}}">{{__('All Blog')}}</a></li>
                                <li class="{{active_menu('admin-home/blog-category')}}"><a href="{{route('admin.blog.category')}}">{{__('Category')}}</a></li>
                                <li class="{{active_menu('admin-home/new-blog')}}"><a href="{{route('admin.blog.new')}}">{{__('Add New Post')}}</a></li>
                            </ul>
                        </li>
                    @endif
                  <!-- <li class="main_dropdown @if(request()->is('admin-home/form-builder/*')) active @endif">
                      <a href="javascript:void(0)"
                         aria-expanded="true">
                          <i class="ti-layout"></i>
                          <span>{{__('Form Builder')}}</span>
                      </a>
                      <ul class="collapse">
                          <li class="{{active_menu('admin-home/form-builder/order-form')}}"><a
                                      href="{{route('admin.form.builder.order')}}">{{__('Order Form')}}</a></li>
                          </li>

                          <li class="{{active_menu('admin-home/form-builder/contact-form')}}"><a
                                      href="{{route('admin.form.builder.contact')}}">{{__('Contact Form')}}</a>
                          </li>

                          <li class="{{active_menu('admin-home/form-builder/quote-form')}}"><a
                                     href="{{route('admin.form.builder.quote')}}">{{__('Quote Form')}}</a></li>

                      </ul>
                  </li> -->
                    @if(!empty(get_static_option('site_maintenance_mode')))
                        <li class="main_dropdown {{active_menu('admin-home/maintains-page/settings')}}">
                            <a href="{{route('admin.maintains.page.settings')}}"
                               aria-expanded="true">
                                {{__('Maintain Page Manage')}}
                            </a>
                        </li>
                    @endif
                    @if('super_admin' == auth()->user()->role || 'admin' == auth()->user()->role)
                        <!-- <li class="@if(request()->is('admin-home/footer/*')) active @endif">
                            <a href="javascript:void(0)"
                               aria-expanded="true">
                                <i class="ti-layout"></i>
                                <span>{{__('Footer Area')}}</span>
                            </a>
                            <ul class="collapse">
                                <li class="{{active_menu('admin-home/footer/general')}}"><a href="{{route('admin.footer.general')}}">{{__('General Settings')}}</a></li>
                            </ul>
                        </li> -->
                        <!-- <li
                        class="
                        {{active_menu('admin-home/menu')}}
                        @if(request()->is('admin-home/menu-edit/*')) active @endif
                        "
                        >
                            <a href="javascript:void(0)" aria-expanded="true"><i class="ti-write"></i> <span>{{__('Menus Manage')}}</span></a>
                            <ul class="collapse">
                                <li class="{{active_menu('admin-home/menu')}}"><a href="{{route('admin.menu')}}">{{__('All Menus')}}</a></li>
                            </ul>
                        </li>
                        <li
                        class="
                        {{active_menu('admin-home/page')}}
                        {{active_menu('admin-home/new-page')}}
                        @if(request()->is('admin-home/page-edit/*')) active @endif
                        "
                        >
                            <a href="javascript:void(0)" aria-expanded="true"><i class="ti-write"></i> <span>{{__('Pages')}}</span></a>
                            <ul class="collapse">
                                <li class="{{active_menu('admin-home/page')}}"><a href="{{route('admin.page')}}">{{__('All Pages')}}</a></li>
                                <li class="{{active_menu('admin-home/new-page')}}"><a href="{{route('admin.page.new')}}">{{__('Add New Page')}}</a></li>
                            </ul>
                        </li> -->
                    @endif
                     @if('super_admin' == auth()->user()->role )
                    <!-- <li class="@if(request()->is('admin-home/general-settings/*')) active @endif">
                        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-settings"></i> <span>{{__('General Settings')}}</span></a>
                        <ul class="collapse ">
                            <li class="{{active_menu('admin-home/general-settings/site-identity')}}"><a href="{{route('admin.general.site.identity')}}">{{__('Site Identity')}}</a></li>
                            <li class="{{active_menu('admin-home/general-settings/basic-settings')}}"><a href="{{route('admin.general.basic.settings')}}">{{__('Basic Settings')}}</a></li>
                            <li class="{{active_menu('admin-home/general-settings/typography-settings')}}"><a href="{{route('admin.general.typography.settings')}}">{{__('Typography Settings')}}</a></li>
                            <li class="{{active_menu('admin-home/general-settings/seo-settings')}}"><a href="{{route('admin.general.seo.settings')}}">{{__('SEO Settings')}}</a></li>
                            <li class="{{active_menu('admin-home/general-settings/scripts')}}"><a href="{{route('admin.general.scripts.settings')}}">{{__('Third Party Scripts')}}</a></li>
                            <li class="{{active_menu('admin-home/general-settings/email-template')}}"><a href="{{route('admin.general.email.template')}}">{{__('Email Template')}}</a></li>
                            <li class="{{active_menu('admin-home/general-settings/smtp-settings')}}"><a href="{{route('admin.general.smtp.settings')}}">{{__('SMTP Settings')}}</a></li>
                            <li class="{{active_menu('admin-home/general-settings/page-settings')}}"><a href="{{route('admin.general.page.settings')}}">{{__('Page Settings')}}</a></li>
                            <li class="{{active_menu('admin-home/general-settings/custom-css')}}"><a href="{{route('admin.general.custom.css')}}">{{__('Custom Css')}}</a></li>
                            <li class="{{active_menu('admin-home/general-settings/payment-settings')}}"><a href="{{route('admin.general.payment.settings')}}">{{__('Payment Gateway Settings')}}</a></li>
                            <li class="{{active_menu('admin-home/general-settings/cache-settings')}}"><a href="{{route('admin.general.cache.settings')}}">{{__('Cache Settings')}}</a></li>
                            <li class="{{active_menu('admin-home/general-settings/license-setting')}}"><a href="{{route('admin.general.license.settings')}}">{{__('Licence Settings')}}</a></li>
                        </ul>
                    </li> -->
                        <!-- <li
                            class="@if(request()->is('admin-home/languages/*') || request()->is('admin-home/languages') ) active @endif">
                            <a href="{{route('admin.languages')}}" aria-expanded="true"><i class="ti-signal"></i> <span>{{__('Languages')}}</span></a>
                        </li> -->
                    @endif 

                        <!-- <li
                            class="@if(request()->is('admin-home/languages/*') || request()->is('admin-home/languages') ) active @endif">
                            <a href="{{route('admin.languages')}}" aria-expanded="true"><i class="ti-signal"></i> <span>{{__('Languages')}}</span></a>
                        </li> -->

                </ul>
            </nav>
        </div>
    </div>
</div>
