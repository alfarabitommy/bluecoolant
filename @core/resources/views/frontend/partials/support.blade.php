<div class="support-bar-area d-none">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="left-content-area"><!-- left content area -->
                    <ul>
                        @foreach($all_support_item as $data)
                            <li><i class="{{$data->icon}}"></i> {{$data->details}}</li>
                        @endforeach
                    </ul>
                </div><!-- //.left conten tarea -->
                <div class="right-content-area"><!-- left content area -->
                    <ul class="social-icons">
                        @foreach($all_social_item as $data)
                            <li><a href="{{$data->url}}"><i class="{{$data->icon}}"></i></a></li>
                        @endforeach
                    </ul>
                    <ul>
                        @if(auth()->guard('web')->check())
                        <li><a href="{{ route('user.home') }}">{{__('Dashboard')}}</a></li>
                            <li> <a href="{{route('user.logout')}}"
                                    onclick="event.preventDefault();
                                   document.getElementById('logout-menu-form').submit();">
                                {{__('Logout')}}
                                </a>
                                <form id="logout-menu-form" action="{{route('user.logout')}}" method="POST" class="d-none">
                                    @csrf
                                </form></li>
                            @else
                            <li><a href="{{ route('user.login') }}">{{__('Login')}}</a></li>
                            <li><a href="{{ route('user.register') }}">{{__('Register')}}</a></li>
                        @endif
                    </ul>
                    @if(!empty(get_static_option('hide_frontend_language_change_option')))
                    <select id="langchange">
                        @foreach($all_language as $lang)
                            <option @if(session()->get('lang') == $lang->slug) selected @endif value="{{$lang->slug}}">{{$lang->name}}</option>
                        @endforeach
                    </select>
                    @endif
                </div><!-- //.left conten tarea -->
            </div>
        </div>
    </div>
</div>
