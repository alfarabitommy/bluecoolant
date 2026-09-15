@extends('frontend.frontend-page-master')
@section('site-title')
    {{get_static_option('service_page_'.$user_select_lang_slug.'_name')}}
@endsection
@section('page-title')
    {{get_static_option('service_page_'.$user_select_lang_slug.'_name')}}
@endsection

@section('meta-name')
<?php
if(get_user_lang()=='en'){
?>
<meta name="title" content="Services | Blue Coolant Indonesia - Best Radiator Coolant Solution">
<meta name="description" content="PT. Blue Coolant Indonesia provides solutions to your needs with several product variants including Radiator coolant, Degreaser and other complementary products.">
<?php
} else {
?>
<meta name="title" content="Layanan Kami | Blue Coolant Indonesia - Solusi Radiator Coolant Terbaik">
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


@section('content')



    <div class="divservices">



        <section class="service-breadcrumb-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="breadcrumb-inner">
                            <!-- <h1 class="title">{{get_static_option('service_page_'.$user_select_lang_slug.'_name')}}</h1> -->
                            <h1 class="title">{{ get_user_lang()=='en'?'Services.':'Layanan.' }}</h1>
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


        <section class="service-area service-page service-bc">

            <div class="container">
                @foreach($all_services as $index => $data)
                    <div class="mt-4 mb-4 row h-100 justify-content-center align-items-center">
                        <div class="col-6 p-4 {{ $index % 2 == 0 ? 'order-1':'order-2'}}">
                            @php
                                $brand_img = get_attachment_image_by_id($data->image,null,true);
                            @endphp
                            @if (!empty($brand_img))
                                <div class="attachment-preview">
                                    <div class="thumbnail">
                                        <div class="centered">
                                            <img class="avatar user-thumb" src="{{$brand_img['img_url']}}" alt="{{$brand_img['title']}}">
                                        </div>
                                    </div>
                                </div>
                                @php  $img_url = $brand_img['img_url']; @endphp
                            @endif
                        </div>
                        <div class="col-6 p-4 service-content-bc {{ $index % 2 == 0 ? 'order-2':'order-1'}}">
                            <h2 class="mb-1 pb-0">{{$data->title}}</h2>   
                            <p class="mt-1 pt-0">{{$data->excerpt}}</p> 
                            <!-- <div class="single-service-item">
                                <div class="icon">
                                    <i class="{{$data->icon}}"></i>
                                </div>

                                <div class="content">
                                    <a href="{{route('frontend.services.single',['id' => $data->id,'any' => Str::slug($data->title)])}}"><h4 class="title">{{$data->title}}</h4></a>
                                    <div class="post-description">
                                        <p>{{$data->excerpt}}</p>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                @endforeach
            </div>


            <div class="container d-none">
                <div class="row">
                    @foreach($all_services as $data)
                        <div class="col-lg-4 col-md-6">
                            <div class="single-service-item">
                                <div class="icon">
                                    <i class="{{$data->icon}}"></i>
                                </div>

                                <div class="content">
                                    <a href="{{route('frontend.services.single',['id' => $data->id,'any' => Str::slug($data->title)])}}"><h4 class="title">{{$data->title}}</h4></a>
                                    <div class="post-description">
                                        <p>{{$data->excerpt}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <div class="pb-5"></div>

    </div>



    <section class="pricing-plan-area gray-bg d-none">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="section-title">
                        <h2 class="title">{{get_static_option('service_page_'.get_user_lang().'_price_plan_section_title')}}</h2>
                        <div class="separator">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach($all_price_plan as $data)
                <div class="col-lg-4 col-md-6">
                    <div class="single-price-plan-01">
                        <div class="price-header">
                            <div class="icon">
                                <i class="{{$data->icon ?? ''}}"></i>
                            </div>
                            <h4 class="name">{{$data->title ?? ''}}</h4>
                            <div class="price"> {{amount_with_currency_symbol($data->price ?? 0)}} </div>
                        </div>
                        <div class="price-body">
                            <ul>
                                @php
                                    $features = explode(';',$data->features);
                                @endphp
                                @foreach($features as $feat)
                                <li>{{$feat}}</li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="price-footer">
                            @php $button_url = !empty($data->url_status) ? route('frontend.plan.order',$data->id) : $data->btn_url ;  @endphp
                            <a href="{{$button_url}}" class="btn-boxed blank">{{$data->btn_text}}</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    <section class="call-to-action-area d-none">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="call-to-action-one">
                        <div class="left-content-area">
                            <h3 class="title">{{get_static_option('service_page_'.get_user_lang().'_cta_title')}}</h3>
                            <p>{{get_static_option('service_page_'.get_user_lang().'_cta_description')}}</p>
                        </div>
                        @if(!empty(get_static_option('service_page_'.get_user_lang().'_cta_button_status')))
                        <div class="right-content-area">
                            <div class="btn-wrapper">
                                <a href="{{url('/contact')}}" class="boxed-btn">{{get_static_option('service_page_'.get_user_lang().'_cta_button_text')}}</a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
