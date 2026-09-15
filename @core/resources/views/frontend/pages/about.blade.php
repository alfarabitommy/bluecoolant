@extends('frontend.frontend-page-master')
@section('site-title')
    {{__('About')}}
@endsection
@section('page-title')
    {{__('About')}}
@endsection

@section('meta-name')
<?php
if(get_user_lang()=='en'){
?>
<meta name="title" content="About Us | Blue Coolant Indonesia - Best Radiator Coolant Solution">
<meta name="description" content="PT. Blue Coolant Indonesia was founded in 2010 as part of the SEFAS Group. We provide solutions to your needs with products including Radiator coolant, Degreaser and other products.">
<?php
} else {
?>
<meta name="title" content="Tentang Kami | Blue Coolant Indonesia - Solusi Radiator Coolant Terbaik">
<meta name="description" content="PT. Blue Coolant Indonesia didirikan pada tahun 2010 sebagai bagian dari SEFAS Group. Kami memberikan solusi kebutuhan Anda dengan produk di antaranya Radiator coolant, Degreaser dan produk lainnya.">
<?php
}
?>
@endsection

@section('schema')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "Bluecoolant Indonesia",
  "url": "https://bluecoolant.com/",
  "logo": "https://bluecoolant.com/assets/uploads/media-uploader/blue-coolant-logo-blue1694673523.png"
}
</script>
@endsection

@section('content')


    <div class="divabout">
        <section class="about-breadcrumb-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="breadcrumb-inner">
                            <!-- <h1 class="title">{{get_static_option('about_page_'.$user_select_lang_slug.'_name')}}</h1> -->
                            <h1 class="title">{{ get_user_lang()=='en'?'About Us.':'Tentang Kami.' }}</h1>
                            <!-- <div class="page-list">
                                <a href="{{url('/')}}"><span>Home</span></a>
                                -
                                <span class="current-item">page-title</span>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="aboutcontent text-center pb-5 container">
            <div class="row justify-content-center mb-5 pb-5">

                @foreach($all_about as $data)
                    <div class="col-12 abouttext">
                    {{$data->excerpt}}
                    </div>
                @endforeach

            </div>
        </div>

 

        


        <div class="divabout-value pt-5 pb-4">
            <div class="container">
                <div class="row">
                <div class="col-12 text-center mt-5 mb-4"><h2 class="h2">Value</h2></div>
                    @foreach($all_value as $data)
                        <div class="col-12 valuebox p-4 mt-4 mb-4">
                            <div class="row h-100 justify-content-center align-items-center">
                                <div class="col-4 p-4">
                                    <div class="thumbv">
                                        {!! render_image_markup_by_attachment_id($data->image) !!}
                                    </div>
                                </div>
                                <div class="col-8 p-4">
                                    <h3>{{$data->title}}</h3>
                                    <p>{{$data->excerpt}}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
 

        <div class="aboutcontent text-center pt-5  mt-5 container">
            <!-- <div class="row justify-content-center mb-5">
                <div class="col-12">
                    <h2>{{get_static_option('about_page_'.get_user_lang().'_about_section_title')}}</h2>
                </div>
                <div class="col-12 abouttext">
                    {{get_static_option('about_page_'.get_user_lang().'_about_section_description')}}
                </div>
            </div> -->

            <div class="row justify-content-center mb-5">
                <div class="col-12">
                    <h2>Visi</h2>
                </div>
                @foreach($all_visi as $data)
                    <div class="col-12 abouttext">
                    {{$data->excerpt}}
                    </div>
                @endforeach
            </div>

            
        </div>

        <div class="divabout-misi pt-5 pb-5">
        <div class="container pb-5">
                <div class="row justify-content-md-center">
                    <div class="col-12 text-center mt-5 mb-4"><h2 class="h2">Misi</h2></div>
                    @foreach($all_misi as $data)
                        <div class="col-12 col-sm-4 valuebox">
                            <div class="row h-100 justify-content-center align-items-center">
                                <div class="col-3 p-4 divmisi">
                                    <div class="thumb">
                                        {!! render_image_markup_by_attachment_id($data->image) !!}
                                    </div>
                                    <div class="thumbhover">
                                        {!! render_image_markup_by_attachment_id($data->image) !!}
                                    </div>
                                </div>
                                <div class="col-9 p-4">
                                    <h3 class="mb-0">{{$data->title}}</h3>
                                    <div class="underlinetitle"></div>
                                    <p>{{$data->excerpt}}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>

        </div>




    </div>

<div class="aboutcontent d-none">
    <section class="about-page-conent about-page">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="left-content-area">
                       {!! render_image_markup_by_attachment_id(get_static_option('about_page_'.$user_select_lang_slug.'_about_section_left_image')) !!}
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="right-content-area">
                        <h2 class="title">{{get_static_option('about_page_'.get_user_lang().'_about_section_title')}}</h2>
                        <p>{{get_static_option('about_page_'.get_user_lang().'_about_section_description')}}</p>
                        @if(!empty(get_static_option('about_page_'.get_user_lang().'_about_section_btn_status')))
                        <div class="btn-wrapper">
                            <a href="{{get_static_option('about_page_'.get_user_lang().'_about_section_btn_url')}}" class="boxed-btn">{{get_static_option('about_page_'.get_user_lang().'_about_section_btn_text')}}</a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="counterup-area counterup-bg"
            {!! render_background_image_markup_by_attachment_id(get_static_option('home_01_counterup_bg_image')) !!}
    >
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

    <div class="team-member-area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="section-title">
                        <h2 class="title">{{get_static_option('about_page_'.get_user_lang().'_team_section_title')}}</h2>
                        <div class="separator">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach($all_team_members as $data)
                <div class="col-lg-3 col-md-6">
                    <div class="single-team-member">
                        <div class="thumb">
                            {!! render_image_markup_by_attachment_id($data->image) !!}
                        </div>
                        <div class="content">
                            <h4 class="name">{{$data->name}}</h4>
                            <span class="post">{{$data->designation}}</span>
                            <p>{{$data->description}}</p>
                            <ul class="social-icon">
                                @if(!empty($data->icon_one) && !empty($data->icon_one_url))
                                    <li><a href="{{$data->icon_one_url}}"><i class="{{$data->icon_one}}"></i></a></li>
                                @endif
                                @if(!empty($data->icon_two) && !empty($data->icon_two_url))
                                    <li><a href="{{$data->icon_two_url}}"><i class="{{$data->icon_two}}"></i></a></li>
                                @endif
                                @if(!empty($data->icon_three) && !empty($data->icon_three_url))
                                    <li><a href="{{$data->icon_three_url}}"><i class="{{$data->icon_three}}"></i></a></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="brand-carousel-area gray-bg">
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

</div>
@endsection
