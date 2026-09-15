@extends('frontend.frontend-page-master')
@php $img_url = '';@endphp
@if(file_exists('assets/uploads/works/work-large-'.$work_item->id.'.'.$work_item->image))
    @php $img_url = asset('assets/uploads/works/work-large-'.$work_item->id.'.'.$work_item->image);@endphp
@endif
@section('og-meta')
    <meta property="og:url"  content="{{route('frontend.work.single',['id' => $work_item->id,'any' => Str::slug($work_item->title)])}}" />
    <meta property="og:type"  content="article" />
    <meta property="og:title"  content="{{$work_item->title}}" />
    <meta property="og:image" content="{{$img_url}}" />
@endsection
@section('site-title')
    {{$work_item->title}}
@endsection
@section('page-title')
    {{__('Work Single')}}
@endsection
@section('content')
    <div class="work-details-content-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="work-details-inner-area">
                        <div class="thumb">
                           {!! render_image_markup_by_attachment_id($work_item->image,'','large') !!}
                        </div>
                        <h2 class="title">{{$work_item->title}}</h2>
                        <div class="post-description">
                            {!! $work_item->description !!}
                        </div>
                        @php $gallery_item = $work_item->gallery ? explode('|',$work_item->gallery) : []; @endphp
                        @if(!empty($gallery_item))
                        
                        <div class="case-study-gallery-wrapper">
                            <h2 class="title mt-4">{{__('Image Gallery')}}</h2>
                            <div class="case-study-gallery-carousel global-carousel-init"
                                 data-loop="true"
                                 data-desktopitem="1"
                                 data-mobileitem="1"
                                 data-tabletitem="1"
                                 data-nav="true"
                                 data-autoplay="true"
                                 data-margin="0"
                            >
                                @foreach($gallery_item as $gall)
                                <div class="single-gallery-item">
                                    {!! render_image_markup_by_attachment_id($gall) !!}
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="project-details">
                        <h4 class="title">{{__('Project Details')}}</h4>
                        <ul class="details-list">
                            <li><strong>{{__('Start Date:')}}</strong>{{$work_item->start_date}} </li>
                            <li><strong>{{__('End Date:')}}</strong> {{$work_item->end_date}}</li>
                            <li><strong>{{__('Location:')}}</strong> {{$work_item->location}}</li>
                            <li><strong>{{__('Clients:')}}</strong> {{$work_item->clients}}</li>
                            <li><strong>{{__('Category:')}}</strong> {{get_work_category_by_id($work_item->id,'string')}}</li>
                        </ul>
                        <div class="share-area">
                            <h4 class="title">{{__('Share')}}</h4>
                            <ul class="share-icon">
                                {!! single_post_share(route('frontend.work.single',['id' => $work_item->id,'any' => Str::slug($work_item->title)]),$work_item->title,$img_url) !!}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
