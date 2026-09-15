@section('meta-name')
<?php
if(get_user_lang()=='en'){
?>
<meta name="title" content="Blue Coolant Indonesia - Best Radiator Coolant Solution">
<meta name="description" content="PT. Blue Coolant Indonesia provides solutions to your needs with several product variants including Radiator coolant, Degreaser and other complementary products.">
<?php
} else {
?>
<meta name="title" content="Blue Coolant Indonesia - Solusi Radiator Coolant Terbaik">
<meta name="description" content="PT. Blue Coolant Indonesia memberikan solusi kebutuhan Anda dengan beberapa varian produk di antaranya Radiator coolant, Degreaser dan produk pelengkap lainnya.">
<?php
}
?>
@endsection

@section('schema')
<script type="application/ld+json">
{
 "@context": "http://schema.org",
 "@type": "Organization",
 "name": "Bluecoolant Indonesia",
 "logo": "https://bluecoolant.com/assets/uploads/media-uploader/blue-coolant-logo-blue1694673523.png",
 "url": "https://bluecoolant.com/"
}
</script>
@endsection

<div  style="background:url('<?php echo env('ASSET_URL'); ?>/assets/frontend/img/bc/Home_bg01.png');background-position:top; background-size:100% auto; background-repeat:no-repeat;background-color:#f5f5f5;">

@include('frontend.partials.navbar')
<header class="header-area-wrapper header-carousel-two d-none">
    @foreach($all_header_slider as $data)
    <div class="header-area header-bg" {!! render_background_image_markup_by_attachment_id($data->image) !!}>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="header-inner">
                        <h1 class="title">
                            @php
                                $title = str_replace('{color}','<span class="base-color">',$data->title);
                                $title = str_replace('{/color}','</span>',$title);
                            @endphp
                            {!! $title !!}
                        </h1>
                        <p>{{$data->description}}</p>
                        <div class="btn-wrapper">
                            @if(!empty($data->btn_01_status))
                            <a href="{{$data->btn_01_url}}" class="boxed-btn btn-rounded">{{$data->btn_01_text}}</a>
                            @endif
                            @if(!empty($data->btn_02_status))
                            <a href="{{$data->btn_02_url}}" class="boxed-btn btn-rounded blank">{{$data->btn_02_text}}</a>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @endforeach
</header>
@if(!empty(get_static_option('home_page_key_feature_section_status')))
<div class="header-bottom-area d-none">
    <div class="container">
        <div class="row">
            @foreach($all_key_features as $data)
            <div class="col-lg-4 col-md-6">
                <div class="single-header-bottom-item">
                    <div class="icon">
                        <i class="{{$data->icon}}"></i>
                    </div>
                    <div class="content">
                        <h4 class="title">{{$data->title}}</h4>
                        <p>{{$data->description}}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif
@if(!empty(get_static_option('home_page_build_dream_section_status')))
    <section class="build-your-dream-area gray-bg style-two d-none">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="left-content-area">
                        <h3 class="title">{{get_static_option('home_page_01_'.get_user_lang().'_build_dream_title')}}</h3>
                        <p>{{get_static_option('home_page_01_'.get_user_lang().'_build_dream_description')}}</p>
                        @if(!empty(get_static_option('build_dream_'.get_user_lang().'_section_button_status')))
                            <div class="btn-wrapper">
                                <a href="{{get_static_option('home_page_01_'.get_user_lang().'_build_dream_btn_url')}}" class="btn-boxed">{{get_static_option('home_page_01_'.get_user_lang().'_build_dream_btn_title')}}</a>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="video-play-area-two">
                        <div class="img-wrapper">
                            {!! render_image_markup_by_attachment_id(get_static_option('home_page_01_'.get_user_lang().'_build_dream_right_image')) !!}
                            <div class="hover">
                                <a href="{{get_static_option('home_page_01_'.get_user_lang().'_build_dream_btn_url')}}" class="video-play-btn mfp-iframe"> <i class="fas fa-play"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="build-your-dream-area style-two">
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <div class="left-content-area">
                        <h3 class="title">{{get_static_option('home_page_01_'.get_user_lang().'_build_dream_title')}}</h3>
                        <!-- <p>{{get_static_option('home_page_01_'.get_user_lang().'_build_dream_description')}}</p> -->
                        <div>{!! get_static_option('home_page_01_'.get_user_lang().'_build_dream_description') !!}</div>
                        @if(!empty(get_static_option('build_dream_'.get_user_lang().'_section_button_status')))
                            <div class="btn-wrapper">
                                <a href="{{get_static_option('home_page_01_'.get_user_lang().'_build_dream_btn_url')}}" class="btn-boxed">{{get_static_option('home_page_01_'.get_user_lang().'_build_dream_btn_title')}}</a>
                            </div>
                        @endif
                    </div>
                    <div class="left-content-area d-none">
                        <h3 class="title">{{get_static_option('home_page_01_'.get_user_lang().'_build_dream_title')}}</h3>
                        <!-- <p>{{get_static_option('home_page_01_'.get_user_lang().'_build_dream_description')}}</p> -->
                        <div style="font-size:40px;color:#58595E;">Blue Coolant Indonesia</div>
                        <div style="color:#58595E;">PT. Blue Coolant Indonesia didirikan pada tahun 2010 sebagai bagian dari SEFAS Group. BCI memberikan solusi kebutuhan Anda dengan beberapa varian produk di antaranya Radiator coolant, Degreaser dan produk pelengkap lainnya.</div>
                        @if(!empty(get_static_option('build_dream_'.get_user_lang().'_section_button_status')))
                            <div class="btn-wrapper">
                                <a href="{{get_static_option('home_page_01_'.get_user_lang().'_build_dream_btn_url')}}" class="btn-boxed">{{get_static_option('home_page_01_'.get_user_lang().'_build_dream_btn_title')}}</a>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="video-play-area-two">
                        <div class="img-wrapper">
                            {!! render_image_markup_by_attachment_id(get_static_option('home_page_01_'.get_user_lang().'_build_dream_right_image')) !!}
                            <!-- <div class="hover">
                                <a href="{{get_static_option('home_page_01_'.get_user_lang().'_build_dream_btn_url')}}" class="video-play-btn mfp-iframe"> <i class="fas fa-play"></i></a>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endif
@if(!empty(get_static_option('home_page_service_section_status')))
<section class="service-area">
    <div class="container">
        <!-- <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="section-title">
                    <h2 class="title">{{get_static_option('home_page_01_'.get_user_lang().'_service_area_title')}}</h2>
                    <div class="separator">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>
        </div> -->
        <div class="row">
            @foreach($all_service as $data)
            <div class="col-lg-3 col-md-6">
                <div class="text-center p-3 divServc">
                    <div class="effect-5 bl-square">
                        <a href="@if ($data->title=='About') 
                                    {{ env("APP_URL").'/about' }}
                                @elseif ($data->title=='Products')
                                    {{ env("APP_URL").'/product' }}
                                @elseif ($data->title=='Services')
                                    {{ env("APP_URL").'/service' }}
                                @else
                                    {{ '' }}
                                @endif">
                            <div class="effect-img">
                                <img alt="<?php echo render_image_alt_by_attachment_id($data->image); ?>" src="<?php echo render_image_src_by_attachment_id($data->image); ?>">
                            </div>
                            <div class="effect-text pl-4 pr-4 pt-5 pb-5">
                                <h2 class="titleServ">{{$data->title}}</h2>
                                <!--<p class="text-white textServc">{{$data->excerpt}}</p> -->
                            </div>
                        </a>
                    </div>
                </div>

                <!-- <div class="text-center p-3 divServc">
                    <div class="bl-square" style="background:url('<?php echo render_image_src_by_attachment_id($data->image); ?>');background-position:center center; background-size:140% auto;">
                        <div class="container h-100">
                            <div class="row h-100 justify-content-center align-items-center">
                                <div class="pt-4 pb-4">
                                    <h3 class="mb-0 titleServ">{{$data->title}}</h3> 
                                    <div class="pl-3 pr-3 pb-3 pt-0 text-white textServc">{{$data->excerpt}}</div>
                                </div>

                                
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
            @endforeach
            <!-- <div class="col-lg-3 col-md-6">
                <div class="text-center p-3">
                    <div class="bl-square" style="background:url('https://picsum.photos/300');background-position:center center; background-size:120% auto;">
                        <div class="container h-100">
                            <div class="row h-100 justify-content-center align-items-center">
                                <h3>Test</h3> 
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
        <div class="row d-none">
            @foreach($all_service as $data)
            <div class="col-lg-4 col-md-6">
                <div class="single-service-item-three">
                    <div class="thumb">
                        {!! render_image_markup_by_attachment_id($data->image) !!}
                        <div class="icon">
                            <i class="{{$data->icon}}"></i>
                        </div>
                    </div>
                    <div class="content">
                        <a href="{{route('frontend.services.single',['id' => $data->id,'any' => Str::slug($data->title)])}}"><h4 class="title">{{$data->title}}</h4></a>
                        <div class="post-description">
                            <p>{{$data->excerpt}}</p>
                        </div>
                        <a href="{{route('frontend.services.single',['id' => $data->id,'any' => Str::slug($data->title)])}}" class="readmore">{{__('Read More')}}</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@if(!empty(get_static_option('home_page_counterup_section_status')))
<section class="d-none counterup-area counterup-bg"{!! render_background_image_markup_by_attachment_id(get_static_option('home_01_counterup_bg_image')) !!}>
    <div class="container">
        <div class="row">
            @foreach($all_counterup as $data)
            <div class="col-lg-3 col-md-6">
                <div class="single-counterup-item">
                    <div class="icon">
                        <i class="{{$data->icon}}"></i>
                    </div>
                    <div class="content">
                        <div class="count-num">{{$data->number}}</div>
                        <h5 class="name">{{$data->title}}</h5>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@if(!empty(get_static_option('home_page_recent_work_section_status')))
  <section class="d-none recent-works-area">
      <div class="container">
          <div class="row">
              <div class="col-lg-12">
                  <div class="recent-work-nav-area">
                      <ul>
                          <li class="active" data-filter="*">{{__('All work')}}</li>
                          @foreach($all_work_category as $data)
                              <li data-filter=".{{Str::slug($data->name)}}">{{$data->name}}</li>
                          @endforeach
                      </ul>
                  </div>
              </div>
          </div>
          <div class="row">
              <div class="col-lg-12">
                  <div class="recent-work-masonry" >
                      @foreach($all_work as $data)
                          <!-- <div class="single-recent-wrok-item col-lg-4  col-md-6 get_work_category_by_id($data->id,'slug') "> -->
                          <div class="single-recent-wrok-item col-lg-4  col-md-6">
                              <div class="thumb">
                                {!! render_image_markup_by_attachment_id($data->image) !!}
                                @php
                                  $image_id = get_attachment_image_by_id($data->image);
                                  $image_url = isset($image_id["img_url"]) ? $image_id["img_url"] : '';
                                @endphp
                                  <div class="hover">
                                      <ul>
                                          <li><a href="{{$image_url}}" class="image-popup"> <i class="flaticon-image"></i> </a></li>
                                          <li><a href="{{route('frontend.work.single',['id' => $data->id,'any' => Str::slug($data->title)])}}"> <i class="flaticon-link-symbol"></i> </a></li>
                                      </ul>
                                  </div>
                              </div>
                          </div>
                      @endforeach
                  </div>
              </div>
          </div>
      </div>
  </section>
@endif

@if(!empty(get_static_option('home_page_testimonial_section_status')))
<section class="testimonial-area gray-bg d-none">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="section-title">
                    <h2 class="title">{{get_static_option('home_page_01_'.get_user_lang().'_testimonial_title')}}</h2>
                    <div class="separator">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-between">
            <div class="col-lg-6">
                <div class="testimonial-carousel">
                    @foreach($all_testimonial as $data)
                    <div class="single-tesitmoial-item">
                        <div class="thumb">
                              {!! render_image_markup_by_attachment_id($data->image) !!}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-5">
                <div class="right-content-area">
                    @foreach($all_testimonial as $key => $data)
                    <div class="single-testimonial-quote @if($key == 0) active @endif" data-owl-item="{{$key}}">
                        <p>{{$data->description}}</p>
                        <h4 class="title">{{$data->name}}</h4>
                        <span class="post">{{$data->designation}}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>


<section class="testimonial-area">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="section-title">
                    <!-- <h2 class="title">{{get_static_option('home_page_01_'.get_user_lang().'_testimonial_title')}}</h2> -->
                    <h2 class="title">{{get_static_option('home_page_01_'.get_user_lang().'_testimonial_title')}}</h2>
                    <br>
                    <!-- <div class="separator">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div> -->
                </div>
            </div>
        </div>
        <div class="row justify-content-between">
            <div class="col-12">

            

                <div class="homepage-carousel">
                    @foreach($all_testimonial as $data)
                        <div class="single-homepage-item">
                            <div class="row p-3 testimonial_bc">
                                <div class="col-sm-5 p-0">
                                    <div class="thumb">
                                    {!! render_image_markup_by_attachment_id($data->image) !!}
                                    </div>                                
                                </div>
                                <div class="col-sm-7">
                                    <h4 class="title pt-4 pt-sm-0">{{$data->name}}</h4>
                                    <p class="text-secondary">{{$data->description}}</p>
                                    <span class="post">{{$data->designation}}</span>
                                </div>
                            </div>
                        </div>
                    <!-- <div class="single-homepage-item">
                        <div class="thumb">
                              {!! render_image_markup_by_attachment_id($data->image) !!}
                        </div>
                    </div> -->
                    @endforeach
                </div>
            </div>
            <!-- <div class="col-lg-5">
                <div class="right-content-area">
                    @foreach($all_testimonial as $key => $data)
                    <div class="single-testimonial-quote @if($key == 0) active @endif" data-owl-item="{{$key}}">
                        <p>{{$data->description}}</p>
                        <h4 class="title">{{$data->name}}</h4>
                        <span class="post">{{$data->designation}}</span>
                    </div>
                    @endforeach
                </div>
            </div> -->
        </div>
    </div>
</section>
@endif
@if(!empty(get_static_option('home_page_latest_news_section_status')))
<section class="latest-news-area d-none">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="section-title">
                    <h2 class="title">{{get_static_option('home_page_01_'.get_user_lang().'_latest_news_title')}}</h2>
                    <div class="separator">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach($all_blog as $data)
            <div class="col-lg-4 col-md-6">
                <div class="single-latest-news-grid-item">
                    <div class="thumb">
                        {!! render_image_markup_by_attachment_id($data->image) !!}
                    </div>
                    <div class="content">
                        <ul class="post-meta">
                            <li>{{__('By')}} <a href="{{route('frontend.blog.single',['id' => $data->id,'any' => Str::slug($data->title)])}}">{{$data->user->name ?? 'Anonymous'}}</a></li>
                            <li><a href="{{route('frontend.blog.single',['id' => $data->id,'any' => Str::slug($data->title)])}}">{{$data->created_at->diffForHumans()}}</a></li>
                        </ul>
                        <a href="{{route('frontend.blog.single',['id' => $data->id,'any' => Str::slug($data->title)])}}"><h4 class="title">{{$data->title}}</h4></a>
                        <div class="post-description">
                            <p>{{$data->excerpt}}</p>
                        </div>
                        <a href="{{route('frontend.blog.single',['id' => $data->id,'any' => Str::slug($data->title)])}}" class="readmore">{{__('Read more')}} <i class="flaticon-right-arrow"></i></a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@if(!empty(get_static_option('home_page_brand_logo_section_status')))
<div class="brand-carousel-area gray-bg d-none">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="brand-carousel">
                    @foreach($all_brand_logo as $data)
                    <div class="single-brand-item">
                          {!! render_image_markup_by_attachment_id($data->image) !!}
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endif
<!-- @include('frontend.partials.newsletter') -->



</div>
