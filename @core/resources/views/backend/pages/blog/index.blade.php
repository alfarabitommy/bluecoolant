@extends('backend.admin-master')
@section('style')
      @include('backend.partials.datatable.style')
      <link rel="stylesheet" href="{{asset('assets/backend/css/dropzone.css')}}">
      <link rel="stylesheet" href="{{asset('assets/backend/css/media-uploader.css')}}">
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
@section('site-title')
    {{__('All Blog Items ')}}
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
                        <h4 class="header-title">{{__('All Blog Items')}}
                           <a href="{{route('admin.blog.new')}}" class="btn btn-info btn-xs pull-right"><i class="fa fa-plus-circle"></i> {{__('Add New')}}</a>
                        </h4>
                          <x-bulk-action/>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            @php $a=0; @endphp
                            @foreach($all_blog as $key => $blog)
                                <li class="nav-item">
                                    <a class="nav-link @if($a == 0) active @endif"  data-toggle="tab" href="#slider_tab_{{$key}}" role="tab" aria-controls="home" aria-selected="true">{{get_language_by_slug($key)}}</a>
                                </li>
                                @php $a++; @endphp
                            @endforeach
                        </ul>
                        <div class="tab-content margin-top-40" id="myTabContent">
                            @php $b=0; @endphp
                            @foreach($all_blog as $key => $blog)
                                <div class="tab-pane fade @if($b == 0) show active @endif" id="slider_tab_{{$key}}" role="tabpanel" >
                                  <div class="table-wrap table-responsive">
                                    <table class="table table-default" id="all_blog_table">
                                        <thead>
                                          <th class="no-sort">
                                           <div class="mark-all-checkbox">
                                               <input type="checkbox" class="all-checkbox">
                                           </div>
                                        </th>
                                        <th>{{__('ID')}}</th>
                                        <th>{{__('Title')}}</th>
                                        <th>{{__('Image')}}</th>
                                        <th>{{__('Posted By')}}</th>
                                        <th>{{__('Category')}}</th>
                                        <th>{{__('Status')}}</th>
                                        <th>{{__('Date')}}</th>
                                        <th>{{__('Action')}}</th>
                                        </thead>
                                        <tbody>
                                        @foreach($blog as $data)
                                            <tr>
                                              <td>
                                                  <x-bulk-checkbox :id="$data->id"/>
                                              </td>
                                                <td>{{$data->id}}</td>
                                                <td>{{$data->title}}</td>
                                                <td>
                                                  @php
                                                       $blog_img = get_attachment_image_by_id($data->image,null,true);
                                                   @endphp
                                                   @if (!empty($blog_img))
                                                       <div class="attachment-preview">
                                                           <div class="thumbnail">
                                                               <div class="centered">
                                                                   <img class="avatar user-thumb" src="{{$blog_img['img_url']}}" alt="">
                                                               </div>
                                                           </div>
                                                       </div>
                                                   @endif
                                                </td>
                                                <td>{{optional($data->user)->name}}</td>
                                                <td> {{get_blog_category_by_id($data->id)}}</td>
                                                <td>
                                                  @if($data->status == 'publish')
                                                        <span class="alert alert-success" style="margin-top: 20px;display: inline-block;">{{__('Publish')}}</span>
                                                    @else
                                                        <span class="alert alert-warning" style="margin-top: 20px;display: inline-block;">{{__('Draft')}}</span>
                                                    @endif
                                                </td>
                                                <td>{{date_format($data->created_at,'d m Y')}}</td>
                                                <td>
                                                  <x-delete-alert :route="route('admin.blog.delete',$data->id)"/>

                                                    <a class="btn btn-lg btn-primary btn-sm mb-3 mr-1" href="{{route('admin.blog.edit',$data->id)}}">
                                                        <i class="ti-pencil"></i>
                                                    </a>

                                                    <a class="btn btn-lg btn-light btn-xs mb-3 mr-1" target="_blank" href="{{route('frontend.blog.single',['id' => $data->id,'any' => Str::slug($data->title)])}}">
                                                      <i class="ti-eye"></i>
                                                    </a>

                                                    <form action="{{route('admin.blog.clone')}}" method="post" style="display: inline-block">
                                                        @csrf
                                                        <input type="hidden" name="item_id" value="{{$data->id}}">
                                                        <button type="submit" title="clone this to new draft" class="btn btn-xs btn-secondary btn-sm mb-3 mr-1"><i class="far fa-copy"></i></button>
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
                'url' : "{{route('admin.blog.bulk.action')}}",
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
  <script src="{{asset('assets/backend/js/dropzone.js')}}"></script>
  @include('backend.partials.media-upload.media-js')
@endsection
