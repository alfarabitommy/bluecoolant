@extends('backend.admin-master')
@section('style')
    <link rel="stylesheet" href="{{asset('assets/backend/css/bootstrap-tagsinput.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/summernote-bs4.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/nice-select.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/dropzone.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/media-uploader.css')}}">
    <link rel="stylesheet" href="{{asset('//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css')}}">
    <style>
        .nice-select {
            z-index: 510;
        }
    </style>
@endsection
@section('site-title')
    <!-- {{__('Edit Works')}} -->
    Edit Product
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
                        <div class="header-wrap">
                        <!-- <h4 class="header-title">{{__('Edit work')}}
                          <a class="btn btn-info btn-sm pull-right" href="{{ route('admin.work') }}">{{__('All Works')}}</a>
                        </h4> -->
                        <h4 class="header-title">Edit Product
                          <a class="btn btn-info btn-sm pull-right" href="{{ route('admin.work') }}">All Products</a>
                        </h4>
                        </div>
                        <form action="{{route('admin.work.update')}}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="{{$work_item->id}}">
                            @csrf
                            <div class="form-group">
                                <label for="language">{{__('Language')}}</label>
                                <select name="lang" id="language" class="form-control"style="height:42px;">

                                    @foreach($all_languages as $lang)
                                        <option @if($lang->slug == $work_item->lang) selected @endif value="{{$lang->slug}}">{{$lang->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="title">{{__('Title')}}</label>
                                <input type="text" class="form-control"  id="title"  name="title" value="{{$work_item->title}}">
                            </div>
                            <div class="form-group">
                                <label for="slug">{{__('Slug')}}</label>
                                <input type="text" class="form-control"  name="slug" value="{{$work_item->slug}}">
                            </div>
                            <div class="form-group">
                                <label for="description">{{__('Description')}}</label>
                                <input type="hidden" name="description" id="description" value="{{$work_item->description}}">
                                <div class="summernote">{!! $work_item->description !!}</div>
                            </div>
                            <div class="form-group d-none">
                                <label for="clients">{{__('Clients')}}</label>
                                <input type="text" class="form-control"  id="clients"  name="clients" value="{{$work_item->clients}}">
                            </div>
                            <div class="form-group d-none">
                                <label for="start_date">{{__('Start Date')}}</label>
                                <input type="date" class="form-control"  id="start_date"  name="start_date" value="{{$work_item->start_date}}">
                            </div>
                            <div class="form-group d-none">
                                <label for="end_date">{{__('End Date')}}</label>
                                <input type="date" class="form-control"  id="end_date"  name="end_date" value="{{$work_item->end_date}}">
                            </div>
                            <div class="form-group pb-3 mb-5">
                                <label for="categories_id">{{__('Category')}}</label>
                                <select name="categories_id"  id="category" class="form-control nice-select wide">
                                    <option value="">{{__('Select Category')}}</option>
                                    @foreach($all_category as $data)
                                        <option @if($work_item->category_id==$data->id) selected @endif value="{{$data->id}}">{{$data->name}}</option>                                        
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group pb-3 mb-5">
                                <label for="subcategories_id">{{__('Subcategory')}}</label>
                                <select name="subcategories_id"  id="subcategory" class="form-control nice-select wide">
                                    <option value="">{{__('Select Subcategory')}}</option>
                                    @foreach($all_subcategory as $data)
                                        <option @if($work_item->subcategory_id==$data->id) selected @endif value="{{$data->id}}">{{$data->name}}</option>                                        
                                    @endforeach
                                </select>
                            </div>

                            <?php
                                $arrSectors = [];
                                $sectorslist = $work_item->sectors_id;
                                if($sectorslist !== null){
                                    if(trim($sectorslist) !== ''){
                                        $arrSectors = explode (",", $sectorslist); 
                                    }
                                }
                            ?>
                            <div class="form-group pb-3 mb-5">
                                <label for="sectors_id">Sectors</label>
                                <select name="sectors_id[]" multiple id="sectors" class="form-control nice-select wide">
                                    <!-- <option value="">Select Sectors</option> -->
                                    @foreach($all_sectors as $data)
                                        <option @if(in_array($data->id, $arrSectors)) selected @endif value="{{$data->id}}">{{$data->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="meta_title">{{__('Meta Title')}}</label>
                                <input type="text" name="meta_title"  class="form-control" value="{{$work_item->meta_title}}">
                            </div>
                            <div class="form-group">
                                <label for="meta_tags">{{__('Meta Tags')}}</label>
                                <input type="text" name="meta_tags"  class="form-control" data-role="tagsinput" value="{{$work_item->meta_tags}}">
                            </div>
                            <div class="form-group">
                                <label for="meta_description">{{__('Meta Description')}}</label>
                                <textarea name="meta_description"  class="form-control" rows="5" id="meta_description">{{$work_item->meta_description}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="status">{{__('Status')}}</label>
                                <select name="status" id="status" class="form-control"style="height:42px;">
                                    <option @if($work_item->status == 'publish') selected @endif value="publish">{{__('Publish')}}</option>
                                    <option @if($work_item->status == 'draft') selected @endif value="draft">{{__('Draft')}}</option>
                                </select>
                            </div>


                            <div class="form-group">
                                <label for="status">Upload PDF Catalog</label>
                                <input type="file" class="form-control-file" id="file" name="file">
                                <small>File .pdf max size 10 Mb</small>
                            </div>
                            <div class="mb-4">
                                <a href="<?= env('ASSET_URL') ?>/assets/uploads/catalog/{{ $work_item->file }}" target="_blank">{{$work_item->file}}</a>
                            </div>

                            <div class="form-group">
                                <label for="status">Upload TDS</label>
                                <input type="file" class="form-control-file" id="file-tds" name="file_tds">
                                <small>File .pdf max size 10 Mb</small>
                            </div>
                            <div class="mb-4">
                                <a href="<?= env('ASSET_URL') ?>/assets/uploads/tds/{{ $work_item->tds }}" target="_blank">{{$work_item->tds}}</a>
                            </div>

                            <?php
                                $arr_packaging = [];
                                $packaging_list = $work_item->packaging_id;
                                if($packaging_list !== null){
                                    if(trim($packaging_list) !== ''){
                                        $arr_packaging = explode (",", $packaging_list); 
                                    }
                                }
                            ?>
                            <div class="form-group pb-3 mb-5">
                                <label for="packaging_id">Packagings</label>
                                <select name="packaging_id[]" multiple id="packagings" class="form-control nice-select wide">
                                    <!-- <option value="">Select Sectors</option> -->
                                    @foreach($all_packaging as $data)
                                        <option @if(in_array($data->id, $arr_packaging)) selected @endif value="{{$data->id}}">{{$data->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="benefit">{{__('Benefits')}}</label>
                                <input type="hidden" name="benefit" id="benefit" value="{{$work_item->benefit}}">
                                <div class="summernote">{!! $work_item->benefit !!}</div>
                            </div>

                            <?php
                                $arr_oem = [];
                                $oem_list = $work_item->oem_id;
                                if($oem_list !== null){
                                    if(trim($oem_list) !== ''){
                                        $arr_oem = explode (",", $oem_list); 
                                    }
                                }
                            ?>
                            <div class="form-group pb-3 mb-5">
                                <label for="oem_id">OEMs</label>
                                <select name="oem_id[]" multiple id="oems" class="form-control nice-select wide">
                                    <!-- <option value="">Select Sectors</option> -->
                                    @foreach($all_oem as $data)
                                        <option @if(in_array($data->id, $arr_oem)) selected @endif value="{{$data->id}}">{{$data->spec.' - '.$data->approval}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <?php
                                $arr_industry = [];
                                $industry_list = $work_item->industry_id;
                                if($industry_list !== null){
                                    if(trim($industry_list) !== ''){
                                        $arr_industry = explode (",", $industry_list); 
                                    }
                                }
                            ?>
                            <div class="form-group pb-3 mb-5">
                                <label for="industry_id">Industries</label>
                                <select name="industry_id[]" multiple id="industries" class="form-control nice-select wide">
                                    <!-- <option value="">Select Sectors</option> -->
                                    @foreach($all_industry as $data)
                                        <option @if(in_array($data->id, $arr_industry)) selected @endif value="{{$data->id}}">{{$data->spec.' - '.$data->approval}}</option>
                                    @endforeach
                                </select>
                            </div>

                        
                            <!-- <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update work')}}</button> -->
                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Update Product</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('backend.partials.media-upload.media-upload-markup')
@endsection
@section('script')
    <script src="{{asset('assets/backend/js/summernote-bs4.js')}}"></script>
    <script src="{{asset('assets/backend/js/jquery.nice-select.min.js')}}"></script>
    <script src="{{asset('assets/backend/js/bootstrap-tagsinput.js')}}"></script>
    <script src="{{asset('//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js')}}"></script>
    <script>
        $(document).ready(function () {

            $('.summernote').summernote({
                height: 250,   //set editable area's height
                codemirror: { // codemirror options
                    theme: 'monokai'
                },
                callbacks: {
                    onChange: function(contents, $editable) {
                        $(this).prev('input').val(contents);
                    }
                }
            });

            if($('.nice-select').length > 0){
                $('.nice-select').niceSelect();
            }


            $(document).on('change','#language',function (e) {
                e.preventDefault();
                var selectedLang = $(this).val();
                $.ajax({
                    url : "{{route('admin.work.category.by.slug')}}",
                    type: "POST",
                    data: {
                        _token : "{{csrf_token()}}",
                        lang: selectedLang
                    },
                    success:function (data) {
                        $('#category').html('');
                        $.each(data,function (index,value) {
                            $('#category').append('<option value="'+value.id+'">'+value.name+'</option>');
                            $('.nice-select').niceSelect('update');
                        });
                    }
                });
            });

        });
    </script>

    <script src="{{asset('assets/backend/js/dropzone.js')}}"></script>
    @include('backend.partials.media-upload.media-js')
@endsection
