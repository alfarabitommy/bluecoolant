@extends('backend.admin-master')
@section('site-title')
    {{__('General Settings')}}
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
                        <h4 class="header-title">{{__('General Settings')}}</h4>
                        <form action="{{route('admin.footer.general')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="site_logo"><strong>{{__('Footer Background Image')}}</strong></label>
                                <div class="media-upload-btn-wrapper">
                                    <div class="img-wrap">
                                        @php
                                            $blog_img = get_attachment_image_by_id(get_static_option('footer_background_image'),null,true);
                                            $blog_image_btn_label = 'Upload Image';
                                        @endphp
                                        @if (!empty($blog_img))
                                            <div class="attachment-preview">
                                                <div class="thumbnail">
                                                    <div class="centered">
                                                        <img class="avatar user-thumb" src="{{$blog_img['img_url']}}" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                            @php  $blog_image_btn_label = 'Change Image'; @endphp
                                        @endif
                                    </div>
                                    <input type="hidden" id="footer_background_image" name="footer_background_image" value="{{get_static_option('footer_background_image')}}">
                                    <button type="button" class="btn btn-info media_upload_form_btn" data-btntitle="Select Footer Background Image" data-modaltitle="Upload footer_background_image" data-toggle="modal" data-target="#media_upload_modal">
                                        {{__($blog_image_btn_label)}}
                                    </button>
                                </div>
                                 <small>{{__('Recommended image size 270x280')}}</small>
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
