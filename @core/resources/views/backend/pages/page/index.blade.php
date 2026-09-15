@extends('backend.admin-master')
@section('site-title')
    {{__('All Pages')}}
@endsection

@section('style')
    @include('backend.partials.datatable.style')
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
                        <h4 class="header-title">{{__('All Pages')}}
                          <a href="{{route('admin.page.new')}}" class="btn btn-primary btn-sm pull-right"><i class="fa fa-plus-circle"></i> {{__('Add New')}}</a>
                        </h4>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            @php $a=0; @endphp
                            @foreach($all_page as $key => $page)
                                <li class="nav-item">
                                    <a class="nav-link @if($a == 0) active @endif"  data-toggle="tab" href="#slider_tab_{{$key}}" role="tab" aria-controls="home" aria-selected="true">{{get_language_by_slug($key)}}</a>
                                </li>
                                @php $a++; @endphp
                            @endforeach
                        </ul>
                        <div class="tab-content margin-top-40" id="myTabContent">
                            @php $b=0; @endphp
                            @foreach($all_page as $key => $pages)
                                <div class="tab-pane fade @if($b == 0) show active @endif" id="slider_tab_{{$key}}" role="tabpanel" >
                                  <div class="table-wrap table-responsive">
                                    <table class="table table-default">
                                        <thead>
                                        <th>{{__('ID')}}</th>
                                        <th>{{__('Title')}}</th>
                                        <th>{{__('Date')}}</th>
                                        <th>{{__('Status')}}</th>
                                        <th>{{__('Action')}}</th>
                                        </thead>
                                        <tbody>
                                        @foreach($pages as $data)
                                            <tr>
                                                <td>{{$data->id}}</td>
                                                <td>{{$data->title}}</td>
                                                <td>{{$data->created_at->diffForHumans()}}</td>
                                                <td>
                                                    @if($data->status == 'publish')
                                                        <span class="alert alert-success">{{__('Publish')}}</span>
                                                    @else
                                                        <span class="alert alert-warning">{{__('Draft')}}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                  <x-delete-alert :route="route('admin.page.delete',$data->id)"/>

                                                    <a class="btn btn-lg btn-primary btn-sm mb-3 mr-1" href="{{route('admin.page.edit',$data->id)}}">
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
@endsection

@section('script')
    @include('backend.partials.datatable.script')
@endsection
