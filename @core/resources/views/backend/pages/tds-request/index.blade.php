@extends('backend.admin-master')
@section('style')
    <link rel="stylesheet" href="{{asset('assets/backend/css/summernote-bs4.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/nice-select.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/dropzone.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/media-uploader.css')}}">
    @include('backend.partials.datatable.style')

    <style>
    .select-box-wrap select {
      height: 38px;
      border: none;
      position: relative;
      top: 2px;
      width: 150px;
      border: 1px solid #e2e2e2;
    }

    input[type="checkbox"]{
    height: 15px;
     width: 15px;
 }
    </style>
@endsection
@section('site-title')
    TDS Requests
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

            <div class="col-lg-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">TDS Requests</h4>
                        <div class="tab-content margin-top-40" id="myTabContent">
                            <div class="tab-pane fade show active" role="tabpanel">
                                <div class="table-wrap table-responsive">
                                    <table class="table table-default">
                                        <thead>
                                            <th>{{__('ID')}}</th>
                                            <th>{{__('Product')}}</th>
                                            <th>{{__('Name')}}</th>
                                            <th>{{__('Email')}}</th>
                                            <th>{{__('Company')}}</th>
                                            <th>{{__('Request Date')}}</th>
                                        </thead>
                                        <tbody>
                                            @foreach($requests as $data)
                                                <tr>
                                                    <td>{{$data->id}}</td>
                                                    <td>{{$data->title}}</td>
                                                    <td>{{$data->name}}</td>
                                                    <td>{{$data->email}}</td>
                                                    <td>{{$data->company}}</td>
                                                    <td>{{date('d M Y', strtotime($data->created_at))}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @include('backend.partials.media-upload.media-upload-markup')
@endsection
@section('script')
    @include('backend.partials.datatable.script')
    <script src="{{asset('assets/backend/js/dropzone.js')}}"></script>
    <script src="{{asset('assets/backend/js/summernote-bs4.js')}}"></script>
    <script src="{{asset('assets/backend/js/jquery.nice-select.min.js')}}"></script>
    @include('backend.partials.media-upload.media-js')
@endsection
