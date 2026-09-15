@extends('backend.admin-master')
@section('site-title')
    {{__('Brand Settings')}}
@endsection
@section('style')
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

            <div class="col-lg-7 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__('All Brand Items')}}</h4>
                        <x-bulk-action/>
                        <div class="table-wrap table-responsive">
                        <table class="table table-default">
                            <thead>
                              <th class="no-sort">
                               <div class="mark-all-checkbox">
                                   <input type="checkbox" class="all-checkbox">
                               </div>
                            </th>
                            <th>{{__('ID')}}</th>
                            <th>{{__('Title')}}</th>
                            <th>{{__('Image')}}</th>
                            <th>{{__('Action')}}</th>
                            </thead>
                            <tbody>
                            @foreach($all_brand as $data)
                                <tr>
                                  <td>
                                      <x-bulk-checkbox :id="$data->id"/>
                                  </td>
                                    <td>{{$data->id}}</td>
                                    <td>{{$data->title}}</td>
                                    <td>
                                          @php
                                            $brand_img = get_attachment_image_by_id($data->image,null,true);
                                            $img_url = '';
                                        @endphp
                                        @if (!empty($brand_img))
                                            <div class="attachment-preview">
                                                <div class="thumbnail">
                                                    <div class="centered">
                                                        <img class="avatar user-thumb" src="{{$brand_img['img_url']}}" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                            @php  $img_url = $brand_img['img_url']; @endphp
                                        @endif
                                        </td>
                                        <td>

                                          <x-delete-alert :route="route('admin.brands.delete',$data->id)"/>

                                        <a href="#"
                                           data-toggle="modal"
                                           data-target="#brand_item_edit_modal"
                                           class="btn btn-lg btn-primary btn-sm mb-3 mr-1 brand_edit_btn"
                                           data-id="{{$data->id}}"
                                           data-title="{{$data->title}}"
                                           data-imageid="{{$data->image}}"
                                           data-image="{{$img_url}}"
                                        >
                                            <i class="ti-pencil"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                  </div>
                </div>
            </div>
            <div class="col-lg-5 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__('New Brand')}}</h4>
                        <form action="{{route('admin.brands')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="title">{{__('Title')}}</label>
                                <input type="text" class="form-control"  id="title"  name="title" placeholder="{{__('Title')}}">
                            </div>
                            <div class="form-group">
                              <label for="image">{{__('Image')}}</label>
                              <div class="media-upload-btn-wrapper">
                                  <div class="img-wrap"></div>
                                  <input type="hidden" name="image">
                                  <button type="button" class="btn btn-info media_upload_form_btn" data-btntitle="Select Blog Image" data-modaltitle="Upload Blog Image" data-toggle="modal" data-target="#media_upload_modal">
                                      {{__('Upload Image')}}
                                  </button>
                              </div>
                                 <small>{{__('Recommended image size 160x80')}}</small>
                          </div>
                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Add New')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="brand_item_edit_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Edit Brand Item')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                </div>
                <form action="{{route('admin.brands.update')}}" id="brand_edit_modal_form"  method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" class="form-control" name="id"  id="brand_id" >
                        <div class="form-group">
                            <label for="edit_title">{{__('Title')}}</label>
                            <input type="text" class="form-control"  id="edit_title"  name="title" placeholder="{{__('Title')}}">
                        </div>

                        <div class="form-group">
                          <label for="image">{{__('Image')}}</label>
                          <div class="media-upload-btn-wrapper">
                              <div class="img-wrap"></div>
                              <input type="hidden" name="image">
                              <button type="button" class="btn btn-info media_upload_form_btn" data-btntitle="Select Blog Image" data-modaltitle="Upload Blog Image" data-toggle="modal" data-target="#media_upload_modal">
                                  {{__('Upload Image')}}
                              </button>
                          </div>
                          <small>{{__('Recommended image size 1920x1280')}}</small>
                      </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                        <button type="submit" class="btn btn-primary">{{__('Save Changes')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
      @include('backend.partials.media-upload.media-upload-markup')
@endsection
@section('script')
    <script src="{{asset('assets/backend/js/dropzone.js')}}"></script>
        @include('backend.partials.media-upload.media-js')
    <script>
        $(document).ready(function () {
            $(document).on('click','.brand_edit_btn',function(){
                var el = $(this);
                var id = el.data('id');
                var title = el.data('title');
                var form = $('#brand_edit_modal_form');
                var image = el.data('image');
                var imageid = el.data('imageid');

                form.find('#preview_image').attr('src',el.data('image'));
                form.find('#brand_id').val(id);
                form.find('#edit_title').val(title);

                if(imageid != ''){
                    form.find('.media-upload-btn-wrapper .img-wrap').html('<div class="attachment-preview"><div class="thumbnail"><div class="centered"><img class="avatar user-thumb" src="'+image+'" > </div></div></div>');
                    form.find('.media-upload-btn-wrapper input').val(imageid);
                    form.find('.media-upload-btn-wrapper .media_upload_form_btn').text('Change Image');
                }
            });
        });
    </script>

        <script>
       $(document).ready(function() {
           $(document).on('click','#bulk_delete_btn',function (e) {
               e.preventDefault();

               var bulkOption = $('#bulk_option').val();
               var allCheckbox =  $('.bulk-checkbox:checked');
               var allIds = [];
               allCheckbox.each(function(index,value){
                   allIds.push($(this).val());
               });
               if(allIds != ''){
                   $(this).text('Please Wait...');
                   $.ajax({
                       'type' : "POST",
                       'url' : "{{route('admin.brands.bulk.action')}}",
                       'data' : {
                           _token: "{{csrf_token()}}",
                           ids: allIds,
                           type: bulkOption
                       },
                       success:function (data) {
                           location.reload();
                       }
                   });
               }

           });

           $('.all-checkbox').on('change',function (e) {
               e.preventDefault();
               var value = $('.all-checkbox').is(':checked');
               var allChek = $(this).parent().parent().parent().parent().parent().find('.bulk-checkbox');
               //have write code here fr
               if( value == true){
                   allChek.prop('checked',true);
               }else{
                   allChek.prop('checked',false);
               }
           });

       } );
   </script>
   @include('backend.partials.datatable.script')
@endsection
