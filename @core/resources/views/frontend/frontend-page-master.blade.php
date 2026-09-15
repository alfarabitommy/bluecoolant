
@include('frontend.partials.header')
@include('frontend.partials.navbar')
<!-- <section class="breadcrumb-area breadcrumb-bg"{!! render_background_image_markup_by_attachment_id(get_static_option('site_breadcrumb_bg')) !!}>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-inner">
                    <h1 class="title">@yield('page-title')</h1>
                    <div class="page-list">
                        <a href="{{url('/')}}"><span>{{__('Home')}}</span></a>
                        -
                        <span class="current-item">@yield('page-title')</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> -->
@yield('content')

@include('frontend.partials.footer')
