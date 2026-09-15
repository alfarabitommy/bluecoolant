@extends('backend.admin-master')
@section('site-title')
    Home Hero Area
@endsection
@section('style')
    <link rel="stylesheet" href="{{asset('assets/backend/css/dropzone.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/media-uploader.css')}}">
@endsection
@section('content')
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <div class="col-lg-12">
                <div class="margin-top-40"></div>
                @include('backend/partials/message')
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            <div class="col-lg-12 mt-t">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Home Hero Area</h4>
                        <form action="{{route('admin.homeone.build.dream')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                @foreach(get_all_language() as $key => $lang)
                                <li class="nav-item">
                                    <a class="nav-link @if($key == 0) active @endif" data-toggle="tab" href="#tab_{{$key}}" role="tab"  aria-selected="true">{{$lang->name}}</a>
                                </li>
                                @endforeach
                            </ul>
                            <div class="tab-content margin-top-30" id="myTabContent">
                                @foreach(get_all_language() as $key => $lang)
                                <div class="tab-pane fade @if($key == 0) show active @endif" id="tab_{{$key}}" role="tabpanel" >
                                    <div class="form-group">
                                        <label for="home_page_01_build_dream_title">{{__('Title')}}</label>
                                        <input type="text" name="home_page_01_{{$lang->slug}}_build_dream_title" class="form-control" value="{{get_static_option('home_page_01_'.$lang->slug.'_build_dream_title')}}" id="home_page_01_build_dream_title">
                                    </div>
                                    <div class="form-group">
                                        <label for="home_page_01_build_dream_description">{{__('Description')}}</label>
                                        <textarea name="home_page_01_{{$lang->slug}}_build_dream_description" class="form-control" rows="10" id="home_page_01_build_dream_description">{{get_static_option('home_page_01_'.$lang->slug.'_build_dream_description')}}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="build_dream_section_button_status"><strong>{{__('Button Show/Hide')}}</strong></label>
                                        <label class="switch">
                                            <input type="checkbox" name="build_dream_{{$lang->slug}}_section_button_status"  @if(!empty(get_static_option('build_dream_'.$lang->slug.'_section_button_status'))) checked @endif id="build_dream_section_button_status">
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label for="home_page_01_build_dream_btn_title">{{__('Button Title')}}</label>
                                        <input type="text" name="home_page_01_{{$lang->slug}}_build_dream_btn_title" class="form-control" value="{{get_static_option('home_page_01_'.$lang->slug.'_build_dream_btn_title')}}" id="home_page_01_build_dream_btn_title">
                                    </div>
                                    <div class="form-group">
                                        <label for="home_page_01_build_dream_btn_url">{{__('Button URL')}}</label>
                                        <input type="text" name="home_page_01_{{$lang->slug}}_build_dream_btn_url" class="form-control" value="{{get_static_option('home_page_01_'.$lang->slug.'_build_dream_btn_url')}}" id="home_page_01_build_dream_btn_url">
                                    </div>
                                    @if(get_static_option('home_page_variant') != '01')
                                        <div class="form-group">
                                            <label for="home_page_01_build_dream_video_url">{{__('Video URL')}}</label>
                                            <input type="text" name="home_page_01_{{$lang->slug}}_build_dream_video_url" class="form-control" value="{{get_static_option('home_page_01_'.$lang->slug.'_build_dream_video_url')}}" id="home_page_01_build_dream_video_url">
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <label for="home_page_01_{{$lang->slug}}_build_dream_right_image">{{__('Right Image')}}</label>
                                        @php $signature_image_upload_btn_label = 'Upload Right Image'; @endphp
                                        <div class="media-upload-btn-wrapper">
                                            <div class="img-wrap">
                                                @php
                                                    $signature_img = get_attachment_image_by_id(get_static_option('home_page_01_'.$lang->slug.'_build_dream_right_image'),null,false);
                                                @endphp
                                                @if (!empty($signature_img))
                                                    <div class="attachment-preview">
                                                        <div class="thumbnail">
                                                            <div class="centered">
                                                                <img class="avatar user-thumb" src="{{$signature_img['img_url']}}" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @php $signature_image_upload_btn_label = 'Change Right Image'; @endphp
                                                @endif
                                            </div>
                                            <input type="hidden" name="home_page_01_{{$lang->slug}}_build_dream_right_image" value="{{get_static_option('home_page_01_'.$lang->slug.'_build_dream_right_image')}}">
                                            <button type="button" class="btn btn-info media_upload_form_btn" data-btntitle="Select Right Image" data-modaltitle="Upload Right Image" data-imgid="{{get_static_option('home_page_01_'.$lang->slug.'_build_dream_right_image')}}" data-toggle="modal" data-target="#media_upload_modal">
                                                {{__($signature_image_upload_btn_label)}}
                                            </button>
                                        </div>
                                        <small>{{__('recommended image size is 470x590 pixel')}}</small>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update Settings')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('backend.partials.media-upload.media-upload-markup')
    @endsection

    @section('script')
        <script src="{{asset('assets/backend/js/dropzone.js')}}"></script>
        @include('backend.partials.media-upload.media-js')
    @endsection
