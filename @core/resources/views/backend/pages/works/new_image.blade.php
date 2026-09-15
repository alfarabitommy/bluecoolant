@extends('backend.admin-master')
@section('style')
    <link rel="stylesheet" href="{{asset('assets/backend/css/bootstrap-tagsinput.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/summernote-bs4.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/nice-select.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/dropzone.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/media-uploader.css')}}">
    <link rel="stylesheet" href="{{asset('//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css')}}">
@endsection
@section('site-title')
    New Product Image
@endsection
@section('content')
<div class="col-lg-12 col-ml-12 padding-bottom-30">
    <div class="row">
        <div class="col-lg-12">
            <div class="margin-top-40"></div>
            @include('backend/partials/message')
            <x-error-msg/>
        </div>
        <div class="col-lg-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Add New Product Image
                        <a class="btn btn-info btn-sm pull-right" href="{{ route('admin.work.image') }}">All Products Images</a>
                    </h4>
                    <form action="{{route('admin.work.store_image')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="language">{{__('Language')}}</label>
                            <select name="lang" id="language" class="form-control"style="height:42px;">
                                @foreach(get_all_language() as $language)
                                    <option value="{{$language->slug}}">{{$language->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="product">Product</label>
                            <select name="product" id="product" class="form-control"style="height:42px;">
                                <option value="">Select Product</option>
                                @foreach($en_works as $work)
                                    <option value="{{$work->id}}">{{$work->title}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="image">{{__('Image')}}</label>
                            <div class="media-upload-btn-wrapper">
                                <div class="img-wrap"></div>
                                <input type="hidden" name="image">
                                <button type="button" class="btn btn-info media_upload_form_btn" data-btntitle="Select Product Image" data-modaltitle="Upload Product Image" data-toggle="modal" data-target="#media_upload_modal">
                                    {{__('Upload Image')}}
                                </button>
                            </div>
                            <!-- <small>{{__('Recommended image size 1920x1280')}}</small> -->
                            <small>{{__('Recommended image size 800x800')}}</small>
                        </div>
                        <div class="form-group d-none">
                            <label for="image">{{__('Gallery')}}</label>
                            <div class="media-upload-btn-wrapper gallery">
                                <div class="img-wrap"></div>
                                <input type="hidden" name="gallery">
                                <button type="button" class="btn btn-info media_upload_form_btn" data-mulitple="true" data-btntitle="Select Image" data-modaltitle="Upload Image" data-toggle="modal" data-target="#media_upload_modal">
                                    {{__('Upload Imagess')}}
                                </button>
                            </div>
                            <!-- <small>{{__('Recommended image size 1920x1280')}}</small> -->
                            <small>{{__('Recommended image size 800x800')}}</small>
                        </div>

                        <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Add Product Image</button>
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
    <script>
        $('#language').on('change', function() {
            $.ajax({
                method   :'GET',
                url      : '{{ route("admin.work.image.get_product_by_lang_ajax") }}',
                async    : false,
                dataType : 'json',
                data     : { lang: $('#language').val() },
                success:function(data){
                    var html = '';
                    html += '<option value="">Select Product</option>';
                    for(i=0; i< data.length; i++){
                        html += '<option value='+data[i].id+'>'+data[i].title+'</option>';
                    }
                    $('#product').html(html);
                }
            })
        })
    </script>
@endsection