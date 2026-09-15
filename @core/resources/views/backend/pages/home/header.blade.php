@extends('backend.admin-master')
@section('site-title')
    {{__('Header Slider')}}
@endsection
@section('style')
    <link rel="stylesheet" href="{{asset('assets/backend/css/dropzone.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/media-uploader.css')}}">
    @include('backend.partials.datatable.style')
  <style>
    .select-box-wrap select {
      height: 40px;
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
                        <h4 class="header-title">{{__('All Header Slider')}}</h4>
                              <x-bulk-action/>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            @php $a=0; @endphp
                            @foreach($all_header_slider as $key => $slider)

                            <li class="nav-item">
                                <a class="nav-link @if($a == 0) active @endif"  data-toggle="tab" href="#slider_tab_{{$key}}" role="tab" aria-controls="home" aria-selected="true">{{get_language_by_slug($key)}}</a>
                            </li>
                                @php $a++; @endphp
                            @endforeach
                        </ul>
                        <div class="tab-content margin-top-40" id="myTabContent">
                            @php $b=0; @endphp
                            @foreach($all_header_slider as $key => $slider)
                            <div class="tab-pane fade @if($b == 0) show active @endif" id="slider_tab_{{$key}}" role="tabpanel" >
                              <div class="table-wrap table-responsive">
                                <table class="table table-default">
                                    <thead>
                                      <th class="no-sort">
                                       <div class="mark-all-checkbox">
                                           <input type="checkbox" class="all-checkbox">
                                       </div>
                                    </th>
                                    <th>{{__('ID')}}</th>
                                    <th>{{__('Image')}}</th>
                                    <th>{{__('Title')}}</th>
                                    <th>{{__('Description')}}</th>
                                    <th>{{__('Language')}}</th>
                                    <th>{{__('Action')}}</th>
                                    </thead>
                                    <tbody>
                                    @foreach($slider as $data)
                                        @php $img_url =''; @endphp
                                        <tr>
                                          <td>
                                              <x-bulk-checkbox :id="$data->id"/>
                                          </td>
                                            <td>{{$data->id}}</td>
                                            <td>
                                              @php
                                                  $header_bg_img = get_attachment_image_by_id($data->image,null,true);
                                                  $img_url = '';
                                              @endphp
                                              @if (!empty($header_bg_img))
                                             <div class="attachment-preview">
                                                 <div class="thumbnail">
                                                     <div class="centered">
                                                         <img class="avatar user-thumb" src="{{$header_bg_img['img_url']}}" alt="">
                                                     </div>
                                                 </div>
                                             </div>
                                             @php  $img_url = $header_bg_img['img_url']; @endphp
                                            @endif
                                            </td>
                                            <td>{{$data->title}}</td>
                                            <td>{{$data->description}}</td>
                                            <td>{{get_language_by_slug($data->lang)}}</td>
                                            <td>

                                              <x-delete-alert :route="route('admin.header.delete',$data->id)"/>

                                                <a href="#"
                                                   data-toggle="modal"
                                                   data-target="#header_slider_item_edit_modal"
                                                   class="btn btn-lg btn-primary btn-sm mb-3 mr-1 header_slider_edit_btn"
                                                   data-id="{{$data->id}}"
                                                   data-title="{{$data->title}}"
                                                   data-image="{{$img_url}}"
                                                   data-imageid="{{$data->image}}"
                                                   data-lang="{{$data->lang}}"
                                                   data-description="{{$data->description}}"
                                                   data-btn_01_status="{{$data->btn_01_status}}"
                                                   data-btn_02_status="{{$data->btn_02_status}}"
                                                   data-btn_01_text="{{$data->btn_01_text}}"
                                                   data-btn_02_text="{{$data->btn_02_text}}"
                                                   data-btn_01_url="{{$data->btn_01_url}}"
                                                   data-btn_02_url="{{$data->btn_02_url}}"
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
                                @php $b++; @endphp
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__('New Header Slider')}}</h4>
                        <form action="{{route('admin.header')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="language"><h6><strong>{{__('Languages')}}</strong></h6></label>
                                <select name="lang" id="language" class="form-control"style="height:42px;">
                                    @foreach($all_language as $data)
                                    <option value="{{$data->slug}}">{{$data->name}}</option>
                                    @endforeach
                                </select>
                                <small>{{__("select language for make this text multilingual")}}</small>
                            </div>
                            <div class="form-group">
                                <label for="title">{{__('Title')}}</label>
                                <input type="text" class="form-control"  id="title"  name="title" placeholder="{{__('Title')}}">
                                <small>{{__("{color} color Text {/color}. user this for color text in header title")}}</small>
                            </div>
                            <div class="form-group">
                                <label for="description">{{__('Description')}}</label>
                                <textarea class="form-control max-height-150"  id="description"  name="description" placeholder="{{__('Description')}}" cols="30" rows="10"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="btn_01_status">{{__('Button One Show/Hide')}}</label>
                                <label class="switch">
                                    <input type="checkbox" name="btn_01_status" id="btn_01_status">
                                    <span class="slider"></span>
                                </label>
                            </div>
                            <div class="form-group">
                                <label for="btn_01_text">{{__('Button One Text')}}</label>
                                <input type="text" class="form-control"  id="btn_01_text"  name="btn_01_text" placeholder="{{__('Button One Text')}}">
                            </div>
                            <div class="form-group">
                                <label for="btn_01_url">{{__('Button One URL')}}</label>
                                <input type="text" class="form-control"  id="btn_01_url"  name="btn_01_url" placeholder="{{__('Button One URL')}}">
                            </div>
                            <div class="form-group">
                                <label for="btn_02_status">{{__('Button Two Show/Hide')}}</label>
                                <label class="switch">
                                    <input type="checkbox" name="btn_02_status" id="btn_02_status">
                                    <span class="slider"></span>
                                </label>
                            </div>
                            <div class="form-group">
                                <label for="btn_02_text">{{__('Button Two Text')}}</label>
                                <input type="text" class="form-control"  id="btn_02_text"  name="btn_02_text" placeholder="{{__('Button Two Text')}}">
                            </div>
                            <div class="form-group">
                                <label for="btn_02_url">{{__('Button Two URL')}}</label>
                                <input type="text" class="form-control"  id="btn_02_url"  name="btn_02_url" placeholder="{{__('Button Two URL')}}">
                            </div>
                            <div class="form-group">
                                <div class="media-upload-btn-wrapper">
                                    <div class="img-wrap"></div>
                                    <input type="hidden" name="image">
                                    <button type="button" class="btn btn-info media_upload_form_btn" data-btntitle="Select Slider Background" data-modaltitle="Upload Slider Background" data-toggle="modal" data-target="#media_upload_modal">
                                        {{__('Upload Image')}}
                                    </button>
                                </div>
                                <small>{{__('recommended image size is 1920x900 pixel')}}</small>
                            </div>
                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Add  New Slider')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="header_slider_item_edit_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Edit Header Slider Item')}}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                </div>
                <form action="{{route('admin.header.update')}}" id="header_slider_edit_modal_form"  method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id" id="header_slider_id" value="">
                        <div class="form-group">
                            <label for="edit_language"><h6><strong>{{__('Languages')}}</strong></h6></label>
                            <select name="lang" id="edit_language" class="form-control"style="height:42px;">
                                @foreach($all_language as $data)
                                    <option value="{{$data->slug}}">{{$data->name}}</option>
                                @endforeach
                            </select>
                            <small>{{__("select language for make this text multilingual")}}</small>
                        </div>
                        <div class="form-group">
                            <label for="edit_title">{{__('Title')}}</label>
                            <input type="text" class="form-control"  id="edit_title"  name="title" placeholder="{{__('Title')}}">
                            <small>{{__("{color} color Text {/color}. user this for color text in header title")}}</small>
                        </div>
                        <div class="form-group">
                            <label for="edit_description">{{__('Description')}}</label>
                            <textarea class="form-control max-height-150"  id="edit_description"  name="description" placeholder="{{__('Description')}}" cols="30" rows="10"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="edit_btn_01_status">{{__('Button One Show/Hide')}}</label>
                            <label class="switch">
                                <input type="checkbox" name="btn_01_status" id="edit_btn_01_status">
                                <span class="slider"></span>
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="edit_btn_01_text">{{__('Button One Text')}}</label>
                            <input type="text" class="form-control"  id="edit_btn_01_text"  name="btn_01_text" placeholder="{{__('Button One Text')}}">
                        </div>
                        <div class="form-group">
                            <label for="edit_btn_01_url">{{__('Button One URL')}}</label>
                            <input type="text" class="form-control"  id="edit_btn_01_url"  name="btn_01_url" placeholder="{{__('Button One URL')}}">
                        </div>
                        <div class="form-group">
                            <label for="edit_btn_02_status">{{__('Button Two Show/Hide')}}</label>
                            <label class="switch">
                                <input type="checkbox" name="btn_02_status" id="edit_btn_02_status">
                                <span class="slider"></span>
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="edit_btn_02_text">{{__('Button Two Text')}}</label>
                            <input type="text" class="form-control"  id="edit_btn_02_text"  name="btn_02_text" placeholder="{{__('Button Two Text')}}">
                        </div>
                        <div class="form-group">
                            <label for="edit_btn_02_url">{{__('Button Two URL')}}</label>
                            <input type="text" class="form-control"  id="edit_btn_02_url"  name="btn_02_url" placeholder="{{__('Button Two URL')}}">
                        </div>
                        <div class="img-wrapper">
                            <img src="" style="max-width: 100px" id="preview_image" alt="">
                        </div>
                        <div class="form-group">
                         <div class="media-upload-btn-wrapper">
                             <div class="img-wrap"></div>
                             <input type="hidden" id="edit_image" name="image" value="">
                             <button type="button" class="btn btn-info media_upload_form_btn" data-btntitle="Select Slider Background" data-modaltitle="Upload Slider Background" data-imgid="{{auth()->user()->image}}" data-toggle="modal" data-target="#media_upload_modal">
                                 {{__('Upload Image')}}
                             </button>
                         </div>
                         <small>{{__('recommended image size is 1920x900 pixel')}}</small>
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
          $(document).on('click','.header_slider_edit_btn',function(){
              var el = $(this);
              var id = el.data('id');
              var action = el.data('action');
              var image = el.data('image');
              var imageid = el.data('imageid');
              var form = $('#header_slider_edit_modal_form');

              form.attr('action',action);
              form.find('#header_slider_id').val(id);
              form.find('#edit_title').val(el.data('title'));
              form.find('#edit_description').val(el.data('description'));
              form.find('#edit_btn_01_text').val(el.data('btn_01_text'));
              form.find('#edit_btn_02_text').val(el.data('btn_02_text'));
              form.find('#edit_btn_01_url').val(el.data('btn_01_url'));
              form.find('#edit_btn_02_url').val(el.data('btn_02_url'));
              form.find('#edit_language option[value='+el.data("lang")+']').attr('selected',true);//lang

              if(imageid != ''){
                  form.find('.media-upload-btn-wrapper .img-wrap').html('<div class="attachment-preview"><div class="thumbnail"><div class="centered"><img class="avatar user-thumb" src="'+image+'" > </div></div></div>');
                  form.find('.media-upload-btn-wrapper input').val(imageid);
                  form.find('.media-upload-btn-wrapper .media_upload_form_btn').text('Change Image');
              }

              if(el.data('btn_01_status') != ''){
                  $('#edit_btn_01_status').prop('checked',true);
              }
              if(el.data('btn_02_status') != ''){
                  $('#edit_btn_02_status').prop('checked',true);
              }
          });
      });
  </script>
  <script>
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
                  'url' : "{{route('admin.header.bulk.action')}}",
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

  </script>
@include('backend.partials.datatable.script')
@endsection
