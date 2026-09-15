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
    Products
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
                        <!-- <h4 class="header-title">{{__('Works Items')}}
                          <a class="btn btn-info btn-sm pull-right" href="{{ route('admin.work.add') }}">Add New Work</a>
                        </h4> -->
                        <h4 class="header-title">Products
                          <a class="btn btn-info btn-sm pull-right" href="{{ route('admin.work.add') }}">Add New Product</a>
                        </h4>
                        <x-bulk-action/>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            @php $a=0; @endphp
                            @foreach($all_works as $key => $work)
                                <li class="nav-item">
                                    <a class="nav-link @if($a == 0) active @endif"  data-toggle="tab" href="#slider_tab_{{$key}}" role="tab" aria-controls="home" aria-selected="true">{{get_language_by_slug($key)}}</a>
                                </li>
                                @php $a++; @endphp
                            @endforeach
                        </ul>
                        <div class="tab-content margin-top-40" id="myTabContent">
                            @php $b=0; @endphp
                            @foreach($all_works as $key => $work)
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
                                         <th>{{__('Category')}}</th>
                                         <th>{{__('Status')}}</th>
                                         <th>{{__('Action')}}</th>
                                         </thead>
                                         <tbody>
                                         @foreach($work as $idx => $data)
                                             <tr>
                                                 <td>
                                                     <div class="bulk-checkbox-wrapper">
                                                         <input type="checkbox" class="bulk-checkbox" name="bulk_delete[]" value="{{$data->id}}">
                                                     </div>
                                                 </td>
                                                 <td>{{$data->id}}</td>
                                                 <td>{{$data->title}}</td>
                                                 <td>
                                                     {!! render_attachment_preview($data->image, '', true) !!}
                                                 </td>
                                                 <td>
                                                     <!-- get_work_category_by_id($data->id,'string') -->
                                                     {{-- {!! get_one_work_category_by_id($data->categories_id) !!} --}}
                                                 </td>
                                                 <td>
                                                     @if($data->status == 'draft' || empty($data->status))
                                                         <div class="alert alert-warning" style="display: inline-block;">{{__('Draft')}}</div>
                                                     @elseif($data->status == 'publish')
                                                         <div class="alert alert-success" style="display: inline-block;">{{ucwords($data->status)}}</div>
                                                     @endif
                                                 </td>
                                                 <td>
                                                     <a tabindex="0" class="btn btn-danger btn-xs mb-3 mr-1"
                                                        role="button"
                                                        data-toggle="popover"
                                                        data-trigger="focus"
                                                        data-html="true"
                                                        title=""
                                                        data-content="
                                                        <h6>{{__('Are you sure to delete this work item ?')}}</h6>
                                                        <form method='post' action='{{route('admin.work.delete',$data->id)}}'>
                                                        <input type='hidden' name='_token' value='{{csrf_token()}}'>
                                                        <br>
                                                         <input type='submit' class='btn btn-danger btn-sm' value='Yes,Please'>
                                                         </form>
                                                         ">
                                                         <i class="ti-trash"></i>
                                                     </a>
                                                     <a href="{{route('admin.work.edit',$data->id)}}" class="btn btn-lg btn-light btn-xs mb-3 mr-1">
                                                         <i class="ti-pencil"></i>
                                                     </a>
                                                     <!-- <a class="btn btn-lg btn-primary btn-xs mb-3 mr-1" target="_blank"
                                                        href="{{route('frontend.work.single',['id' => $data->id,'any' => Str::slug($data->title)])}}">
                                                         <i class="ti-eye"></i>
                                                     </a> -->
                                                     <form action="{{route('admin.work.clone')}}" method="post">
                                                         @csrf
                                                         <input type="hidden" name="item_id" value="{{$data->id}}">
                                                         <button type="submit" title="{{__('clone this to new draft')}}" class="btn btn-xs btn-secondary btn-sm mb-3 mr-1">
                                                             <i class="far fa-copy"></i>
                                                         </button>
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
        @include('backend.partials.datatable.script')
    <script src="{{asset('assets/backend/js/dropzone.js')}}"></script>
    <script src="{{asset('assets/backend/js/summernote-bs4.js')}}"></script>
    <script src="{{asset('assets/backend/js/jquery.nice-select.min.js')}}"></script>
    <script>
        $(document).ready(function () {

            $(document).on('click','.work_edit_btn',function(){
                var el = $(this);
                var id = el.data('id');
                var title = el.data('title');
                var description = el.data('description');
                var form = $('#works_edit_modal_form');
                var allCat = el.data('category');
                var image = el.data('image');
                var imageid = el.data('imageid');

                form.find('#work_id').val(id);
                form.find('#edit_title').val(title);
                form.find('#edit_location').val(el.data('location'));
                form.find('#edit_clients').val(el.data('clients'));
                form.find('#edit_start_date').val(el.data('startdate'));
                form.find('#edit_end_date').val(el.data('enddate'));
                form.find('#edit_description').val(description);
                form.find('#preview_image').attr('src',el.data('imgurl'));
                form.find('.summernote').summernote('code', description);
                form.find('#edit_language option[value="'+el.data('lang')+'"]').attr('selected',true);

                $.ajax({
                    url : "{{route('admin.work.category.by.slug')}}",
                    type: "POST",
                    data: {
                        _token : "{{csrf_token()}}",
                        lang: el.data('lang')
                    },
                    success:function (data) {
                        $('#edit_category').niceSelect();
                        $('#edit_category').html('');
                        $.each(data,function (index,value) {
                            var selected = $.inArray(value.id.toString() ,allCat) != -1 ? 'selected' : '';
                            $('#edit_category').append('<option '+selected+' value="'+value.id+'">'+value.name+'</option>');
                            $('#edit_category').niceSelect('update');
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

            $(document).on('change','#edit_language',function (e) {
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
                        $('#edit_category').html('');
                        $.each(data,function (index,value) {
                            $('#edit_category').append('<option value="'+value.id+'">'+value.name+'</option>');
                            $('.nice-select').niceSelect('update');
                        })
                    }
                });
            })
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
                    'url' : "{{route('admin.work.bulk.action')}}",
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


        <script src="{{asset('assets/backend/js/dropzone.js')}}"></script>
        @include('backend.partials.media-upload.media-js')

@endsection
