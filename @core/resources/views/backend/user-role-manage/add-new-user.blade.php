@extends('backend.admin-master')
@section('site-title')
    {{__('Add New User')}}
@endsection

@section('style')
  <link rel="stylesheet" href="{{asset('assets/backend/css/dropzone.css')}}">
  <link rel="stylesheet" href="{{asset('assets/backend/css/media-uploader.css')}}">
@endsection
@section('content')
    <div class="col-lg-12 col-ml-12 padding-bottom-30">
        <div class="row">
            <!-- basic form start -->
            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__('New User')}}</h4>
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
                        <form action="{{route('admin.new.user')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name">{{__('Name')}}</label>
                                <input type="text" class="form-control"  id="name" name="name" placeholder="{{__('Enter name')}}">
                            </div>
                            <div class="form-group">
                                <label for="username">{{__('Username')}}</label>
                                <input type="text" class="form-control"  id="username" name="username" placeholder="{{__('Username')}}">
                                <small class="text text-danger">{{__('Remember this username, user will login using this username')}}</small>
                            </div>
                            <div class="form-group">
                                <label for="email">{{__('Email')}}</label>
                                <input type="text" class="form-control"  id="email" name="email" placeholder="{{__('Email')}}">
                            </div>
                            <div class="form-group">
                                <label for="password">{{__('Password')}}</label>
                                <input type="password" class="form-control"  id="password" name="password" placeholder="{{__('Password')}}">
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">{{__('Password Confirm')}}</label>
                                <input type="password" class="form-control"  id="password_confirmation" name="password_confirmation" placeholder="{{__('Password Confirmation')}}">
                            </div>
                            <div class="form-group">
                                <label for="role">{{'Role'}}</label>
                                <select name="role" id="role" class="form-control">
                                    <option value="editor">Editor</option>
                                    <option value="admin">Admin</option>
                                    <option value="super_admin">Super Admin</option>
                                </select>
                                <ul class="text-danger">
                                    <li>{{'Editors ( Have all access except Admin Role Manage/Language/Menu/Page )'}}</li>
                                    <li>{{'Admin ( Have all access except Admin Role Manage/language/general settings )'}}</li>
                                    <li>{{'Super_Admin ( have everything access )'}}</li>
                                </ul>
                            </div>
                            <div class="form-group">
                                   <label for="edit_image">{{__('Image')}}</label>
                                   <div class="image-wrap">
                                       <div class="media-upload-btn-wrapper">
                                           <div class="img-wrap"></div>
                                           <input type="hidden" id="edit_image" name="image" value="">
                                           <button type="button" class="btn btn-info media_upload_form_btn" data-btntitle="Select Team Image" data-modaltitle="Upload Team Image" data-toggle="modal" data-target="#media_upload_modal">
                                               {{__('Upload Image')}}
                                           </button>
                                       </div>
                                   </div>
                               </div>

                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Add New User')}}</button>
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
