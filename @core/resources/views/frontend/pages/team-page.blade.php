@extends('frontend.frontend-page-master')
@section('site-title')
    {{__('Team')}}
@endsection
@section('page-title')
    {{__('Team')}}
@endsection
@section('content')
    <section class="team-page-content-area">
        <div class="container">
            <div class="row reorder-xs justify-content-between ">
                <div class="col-lg-6">
                    <div class="left-content-area">
                        <h4 class="title">{{get_static_option('team_page_'.get_user_lang().'_about_section_title')}}</h4>
                        <div class="description">
                            {!! get_static_option('team_page_'.get_user_lang().'_about_section_description') !!}
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="right-content-area">
                        <div class="img-wrapper">
                            {!! render_image_markup_by_attachment_id(get_static_option('team_page_'.get_user_lang().'_about_section_image')) !!}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="team-member-area gray-bg team-page">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="section-title">
                        <h2 class="title">{{get_static_option('team_page_'.get_user_lang().'_team_member_section_title')}}</h2>
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
                <div class="col-lg-12">
                    <div class="pagination-wrapper">
                        {{$all_team_members->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
