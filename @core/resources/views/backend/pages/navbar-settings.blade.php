@extends('backend.admin-master')

@section('site-title')
    {{__('Navbar Settings')}}
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
            <div class="col-lg-12 mt-t">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">{{__('Navbar Settings')}}</h4>
                        <form action="{{route('admin.navbar.settings')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="navbar_button">{{__('Button Show/Hide')}}</label>
                                <label class="switch">
                                    <input type="checkbox" name="navbar_button"  @if(!empty(get_static_option('navbar_button'))) checked @endif id="navbar_button">
                                    <span class="slider"></span>
                                </label>
                            </div>
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    @foreach( get_all_language() as $key => $value)
                                    <a class="nav-item nav-link @if($key == 0) active @endif"  data-toggle="tab" href="#nav_{{$key}}" role="tab" aria-selected="true">{{$value->name}}</a>
                                    @endforeach
                                </div>
                            </nav>
                            <div class="tab-content margin-top-20" id="nav-tabContent">
                                @foreach( get_all_language() as $key => $value)
                                <div class="tab-pane fade @if($key == 0) show active @endif" id="nav_{{$key}}" role="tabpanel" >
                                    <div class="form-group">
                                        <label for="navbar_{{$value->slug}}_button_text">{{__('Button Text')}}</label>
                                        <input type="text" name="navbar_{{$value->slug}}_button_text" class="form-control" value="{{get_static_option('navbar_'.$value->slug.'_button_text')}}" id="navbar_{{$value->slug}}_button_text">
                                    </div>
                                </div>
                                @endforeach
                            </div>



                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update Settings')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

