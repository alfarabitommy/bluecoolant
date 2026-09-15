@extends('backend.admin-master')
@section('style')
    <link rel="stylesheet" href="{{asset('assets/backend/css/summernote-bs4.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/dropzone.css')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/css/media-uploader.css')}}">
      @include('backend.partials.datatable.style')
      <style media="screen">
      .select-box-wrap select {
          height: 38px;
          border: none;
          position: relative;
          top: 2px;
          width: 150px;
          border: 1px solid #e2e2e2;
        }

        input[type="checkbox"] {
          width: 15px; /*Desired width*/
          height: 15px; /*Desired height*/
      }

      </style>

@endsection
@section('site-title')
    {{__('Services')}}
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
                        <h4 class="header-title">{{__('Service Items')}}
                              <a class="pull-right btn btn-info btn-sm" href="{{ route('admin.services.new') }}">{{ __('Add New Service') }}</a>
                        </h4>
                        <x-bulk-action/>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            @php $a=0; @endphp
                            @foreach($all_services as $key => $service)
                                <li class="nav-item">
                                    <a class="nav-link @if($a == 0) active @endif"  data-toggle="tab" href="#slider_tab_{{$key}}" role="tab"
                                       aria-controls="home" aria-selected="true">{{get_language_by_slug($key)}}</a>
                                </li>
                                @php $a++; @endphp
                            @endforeach
                        </ul>
                        <div class="tab-content margin-top-40" id="myTabContent">
                            @php $b=0; @endphp
                            @foreach($all_services as $key => $service)
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
                                        <th>{{__('Title')}}</th>
                                        <th>{{__('Image')}}</th>
                                        <th>{{__('Icon')}}</th>
                                        <th>{{__('Category')}}</th>
                                        <th>{{__('Status')}}</th>
                                        <th>{{__('Date')}}</th>
                                        <th>{{__('Action')}}</th>
                                        </thead>
                                        <tbody>
                                        @foreach($service as $data)
                                            <tr>
                                              <td>
                                                  <x-bulk-checkbox :id="$data->id"/>
                                                </td>
                                                <td>{{$data->id}}</td>
                                                <td>{{$data->title}}</td>
                                                <td>
                                                    @php $img_url = '';@endphp
                                                    @php
                                                        $service_section_img = get_attachment_image_by_id($data->image,null,true);
                                                        $img_url = '';
                                                    @endphp
                                                    @if (!empty($service_section_img))
                                                        <div class="attachment-preview">
                                                            <div class="thumbnail">
                                                                <div class="centered">
                                                                    <img class="avatar user-thumb" src="{{$service_section_img['img_url']}}" alt="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @php  $img_url = $service_section_img['img_url']; @endphp
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($data->icon_type == 'icon' || $data->icon_type == '')
                                                        <i style="font-size: 40px;" class="{{$data->icon}}"></i>
                                                    @else
                                                        {!!  render_image_markup_by_attachment_id($data->img_icon) !!}
                                                    @endif
                                                </td>
                                                <td>{{get_service_category($data->categories_id)}}</td>
                                                <td>{{date_format($data->created_at,'d/M/Y')}}</td>
                                                <td>
                                                    @if($data->status == 'draft')
                                                        <span class="alert alert-warning" style="margin-top: 20px;display: inline-block;">{{__('Draft')}}</span>
                                                    @else
                                                        <span class="alert alert-success" style="margin-top: 20px;display: inline-block;">{{__('Publish')}}</span>
                                                    @endif
                                                </td>

                                                <td>
                                                    <x-delete-alert :route="route('admin.services.delete',$data->id)"/>

                                                      <a href="{{ route('admin.services.edit',$data->id) }}"
                                                         class="btn btn-lg btn-primary btn-sm mb-3 mr-1 service_edit_btn"  >
                                                          <i class="ti-pencil"></i>
                                                      </a>

                                                    <a href="{{route('frontend.services.single',['id' => $data->id,'any' => Str::slug($data->title)])}}" target="_blank" class="btn btn-sm btn-light mb-3 mr-1 ">
                                                       <i class="ti-eye"></i>
                                                   </a>
                                                   <form action="{{route('admin.services.clone')}}" method="post" style="display: inline-block">
                                                       @csrf
                                                       <input type="hidden" name="item_id" value="{{$data->id}}">
                                                       <button type="submit" title="clone this to new draft" class="btn btn-sm btn-secondary mb-3 mr-1"><i class="far fa-copy"></i></button>
                                                   </form>
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

        </div>
    </div>

@include('backend.partials.media-upload.media-upload-markup')
@endsection
@section('script')
    <script src="{{asset('assets/backend/js/summernote-bs4.js')}}"></script>
    <script>
        $(document).ready(function () {

            $(document).on('click','.service_edit_btn',function(){
                var el = $(this);
                var id = el.data('id');
                var title = el.data('title');
                var icon = el.data('icon');
                var description = el.data('description');
                var form = $('#services_edit_modal_form');
                var image = el.data('image');
                var imageid = el.data('imageid');

                form.find('#service_id').val(id);
                form.find('#edit_title').val(title);
                form.find('#edit_icon').val(icon);
                form.find('#edit_description').val(description);
                form.find('#edit_excerpt').val(el.data('excerpt'));
                form.find('#preview_image').attr('src',el.data('imgurl'));
                form.find('.summernote').summernote('code', description);
                form.find('#edit_language option[value="'+el.data('lang')+'"]').attr('selected',true);
                form.find('.iconpicker-component i').attr('class',icon);
                form.find('.iconpicker-element').attr('data-selected',icon);


                $.ajax({
                    url : "{{route('admin.service.category.by.slug')}}",
                    type: "POST",
                    data: {
                        _token : "{{csrf_token()}}",
                        lang: el.data('lang')
                    },
                    success:function (data) {
                        $('#edit_category').html('');
                        $.each(data,function (index,value) {
                            var selected = value.id == el.data('category') ? 'selected' : '';
                            $('#edit_category').append('<option '+selected+' value="'+value.id+'">'+value.name+'</option>');
                        });
                    }
                });

                if(imageid != ''){
                    form.find('.media-upload-btn-wrapper .img-wrap').html('<div class="attachment-preview"><div class="thumbnail"><div class="centered"><img class="avatar user-thumb" src="'+image+'" > </div></div></div>');
                    form.find('.media-upload-btn-wrapper input').val(imageid);
                    form.find('.media-upload-btn-wrapper .media_upload_form_btn').text('Change Image');
                }

            });

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

            $(document).on('change','#language',function (e) {
                e.preventDefault();
                var selectedLang = $(this).val();
                $.ajax({
                   url : "{{route('admin.service.category.by.slug')}}",
                   type: "POST",
                   data: {
                       _token : "{{csrf_token()}}",
                       lang: selectedLang
                   },
                   success:function (data) {
                       $('#category').html('');
                       $.each(data,function (index,value) {
                           $('#category').append('<option value="'+value.id+'">'+value.name+'</option>');
                       })
                   }
                });
            });

            $(document).on('change','#edit_language',function (e) {
                e.preventDefault();
                var selectedLang = $(this).val();
                $.ajax({
                    url : "{{route('admin.service.category.by.slug')}}",
                    type: "POST",
                    data: {
                        _token : "{{csrf_token()}}",
                        lang: selectedLang
                    },
                    success:function (data) {
                        $('#edit_category').html('');
                        $.each(data,function (index,value) {
                            $('#edit_category').append('<option value="'+value.id+'">'+value.name+'</option>');
                        })
                    }
                });
            })

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
                      'url' : "{{route('admin.services.bulk.action')}}",
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

        $('.icp-dd').iconpicker();
        $('.icp-dd').on('iconpickerSelected', function (e) {
            var selectedIcon = e.iconpickerValue;
            $(this).parent().parent().children('input').val(selectedIcon);
        });


        });

    </script>

        <script src="{{asset('assets/backend/js/dropzone.js')}}"></script>
        @include('backend.partials.datatable.script')
        @include('backend.partials.media-upload.media-js')
@endsection
