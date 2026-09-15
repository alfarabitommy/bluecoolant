@extends('backend.admin-master')
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
@section('site-title')
    Product Images
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
                        <h4 class="header-title">Product Images
                          <a class="btn btn-info btn-sm pull-right" href="{{ route('admin.work.add_image') }}">Add New Product Image</a>
                        </h4>
                        <x-bulk-action/>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            @php $a=0; @endphp
                            @foreach($works_image as $key => $work)
                                <li class="nav-item">
                                    <a class="nav-link @if($a == 0) active @endif"  data-toggle="tab" href="#slider_tab_{{$key}}" role="tab" aria-controls="home" aria-selected="true">{{get_language_by_slug($key)}}</a>
                                </li>
                                @php $a++; @endphp
                            @endforeach
                        </ul>
                        <div class="tab-content margin-top-40" id="myTabContent">
                            @php $b=0; @endphp
                            @foreach($works_image as $key => $work_image)
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
                                         <th>{{__('Product')}}</th>
                                         <th>{{__('Image')}}</th>
                                         <th>{{__('Action')}}</th>
                                         </thead>
                                         <tbody>
                                         @foreach($work_image as $data)
                                             <tr>
                                                 <td>
                                                     <div class="bulk-checkbox-wrapper">
                                                         <input type="checkbox" class="bulk-checkbox" name="bulk_delete[]" value="{{$data->id}}">
                                                     </div>
                                                 </td>
                                                 <td>{{$data->id}}</td>
                                                 <td>{{$data->title}}</td>
                                                 <td>
                                                     {!! render_attachment_preview($data->image,'',true) !!}
                                                 </td>
                                                 <td>
                                                     <a tabindex="0" class="btn btn-danger btn-xs mb-3 mr-1"
                                                        role="button"
                                                        data-toggle="popover"
                                                        data-trigger="focus"
                                                        data-html="true"
                                                        title=""
                                                        data-content="
                                                        <h6>{{__('Are you sure to delete this product image ?')}}</h6>
                                                        <form method='post' action='{{route('admin.work.delete.image',$data->id)}}'>
                                                        <input type='hidden' name='_token' value='{{csrf_token()}}'>
                                                        <br>
                                                         <input type='submit' class='btn btn-danger btn-sm' value='Yes,Please'>
                                                         </form>
                                                         ">
                                                         <i class="ti-trash"></i>
                                                     </a>
                                                     <a href="{{route('admin.work.edit_image',$data->id)}}" class="btn btn-lg btn-light btn-xs mb-3 mr-1">
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
                    'url' : "{{route('admin.work.bulk.action.image')}}",
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
