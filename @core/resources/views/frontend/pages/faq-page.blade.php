@extends('frontend.frontend-page-master')
@section('site-title')
    {{__('Faq')}}
@endsection
@section('page-title')
    {{__('Faq')}}
@endsection
@section('content')
    <div class="faq-page-content-area">
        <div class="container">
            <div class="row">
                @foreach($all_faqs->chunk(5) as $chunked_faq)
                <div class="col-lg-6">
                    <div class="accordion-wrapper">
                        @php $rand_number = rand(9999,99999999); @endphp
                        <div id="accordion_{{$rand_number}}">
                            @foreach($chunked_faq as $key => $data)
                                @php
                                    $aria_expanded = 'false';
                                    if($data->is_open == 'on'){ $aria_expanded = 'true'; }
                                @endphp
                                <div class="card">
                                    <div class="card-header" id="headingOne_{{$key}}">
                                        <h5 class="mb-0">
                                            <a data-toggle="collapse" data-target="#collapseOne_{{$key}}" role="button"
                                               aria-expanded="{{$aria_expanded}}" aria-controls="collapseOne_{{$key}}">
                                                {{$data->title}}
                                            </a>
                                        </h5>
                                    </div>

                                    <div id="collapseOne_{{$key}}" class="collapse @if($data->is_open == 'on') show @endif "
                                         aria-labelledby="headingOne_{{$key}}" data-parent="#accordion_{{$rand_number}}">
                                        <div class="card-body">
                                            {{$data->description}}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <section class="testimonial-area gray-bg">
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
    <div class="brand-carousel-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="brand-carousel">
                        @foreach($all_brand_logo as $data)
                            <div class="single-brand-item">
                                @if(file_exists('assets/uploads/brands/brand-image-'.$data->id.'.'.$data->image))
                                    <img src="{{asset('assets/uploads/brands/brand-image-'.$data->id.'.'.$data->image)}}" alt="{{$data->title}}">
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
