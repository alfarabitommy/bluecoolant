@extends('backend.admin-master')
@section('site-title')
    {{__('About Team Section')}}
@endsection

@section('style')
  <link rel="stylesheet" href="{{asset('assets/backend/css/dropzone.css')}}">
  <link rel="stylesheet" href="{{asset('assets/backend/css/media-uploader.css')}}">
  <link rel="stylesheet" href="{{asset('assets/backend/css/summernote-bs4.css')}}">
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
                        <h4 class="header-title">{{__('About Team Section Settings')}}</h4>
                        <form action="{{route('admin.team.page.about')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    @foreach($all_language as $key => $lang)
                                    <a class="nav-item nav-link @if($key == 0) active @endif" data-toggle="tab" href="#nav-home-{{$lang->slug}}" role="tab" aria-selected="true">{{$lang->name}}</a>
                                    @endforeach
                                </div>
                            </nav>
                            <div class="tab-content margin-top-30" id="nav-tabContent">
                                @foreach($all_language as $key => $lang)
                                <div class="tab-pane fade @if($key == 0) show active @endif" id="nav-home-{{$lang->slug}}" role="tabpanel" >
                                    <div class="form-group">
                                        <label for="team_page_{{$lang->slug}}_about_section_title">{{__('Title')}}</label>
                                        <input type="text" name="team_page_{{$lang->slug}}_about_section_title" value="{{get_static_option('team_page_'.$lang->slug.'_about_section_title')}}" class="form-control" id="team_page_{{$lang->slug}}_about_section_title">
                                    </div>
                                    <div class="form-group">
                                        <label>{{__('Description')}}</label>
                                        <input type="hidden" name="team_page_{{$lang->slug}}_about_section_description" value="{{get_static_option('team_page_'.$lang->slug.'_about_section_description')}}">
                                        <div class="summernote" data-content='{{get_static_option('team_page_'.$lang->slug.'_about_section_description')}}'></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="team_page_{{$lang->slug}}_about_section_image">{{__('Right Image')}}</label>
                                        @php $signature_image_upload_btn_label = 'Upload Right Image'; @endphp
                                        <div class="media-upload-btn-wrapper">
                                            <div class="img-wrap">
                                                @php
                                                    $signature_img = get_attachment_image_by_id(get_static_option('team_page_'.$lang->slug.'_about_section_image'),null,false);
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
                                            <input type="hidden" name="team_page_{{$lang->slug}}_about_section_image" value="{{get_static_option('team_page_'.$lang->slug.'_about_section_image')}}">
                                            <button type="button" class="btn btn-info media_upload_form_btn" data-btntitle="Select Right Image" data-modaltitle="Upload Right Image" data-imgid="{{get_static_option('team_page_'.$lang->slug.'_about_section_image')}}" data-toggle="modal" data-target="#media_upload_modal">
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
    <script src="{{asset('assets/backend/js/summernote-bs4.js')}}"></script>

    <script>
        $(document).ready(function () {
            $('.summernote').summernote({
                height: 400,   //set editable area's height
                codemirror: { // codemirror options
                    theme: 'monokai'
                },
                callbacks: {
                    onChange: function(contents, $editable) {
                        $(this).prev('input').val(contents);
                    }
                }
            });
            if($('.summernote').length > 0){
                $('.summernote').each(function(index,value){
                    $(this).summernote('code', $(this).data('content'));
                });
            }
        });
    </script>
@endsection
