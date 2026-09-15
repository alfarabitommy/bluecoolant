@extends('frontend.frontend-page-master')
@section('page-title')
    {{__('Order For')}} {{' : '.$order_details->title}}
@endsection
@section('content')
    <section class="order-service-page-content-area padding-100">
        <div class="container">
            <div class="row  justify-content-between ">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="order-content-area">
                        <h3 class="order-title">{{__('Order Information')}}</h3>
                        @include('backend.partials.message')
                        @include('backend.partials.error')
                       <div class="order-tab-wrap">
                               @if(!auth()->check())
                                   @if(!auth()->check())
                                       <div class="login-form">
                                           <form action="{{route('user.login')}}" method="post" enctype="multipart/form-data" class="contact-page-form style-01" id="login_form_order_page">
                                               @csrf
                                               <div class="alert alert-warning alert-block">
                                                <button type="button" class="close" data-dismiss="alert">×</button>
                                                <strong>{{ __('You must login or create an account to order your package!') }}</strong>
                                                </div>
                                               <div class="error-wrap"></div>
                                               <div class="form-group">
                                                   <input type="text" name="username" class="form-control" placeholder="{{__('Username')}}">
                                               </div>
                                               <div class="form-group">
                                                   <input type="password" name="password" class="form-control" placeholder="{{__('Password')}}">
                                               </div>
                                               <div class="form-group btn-wrapper">
                                                <button class="boxed-btn btn-saas btn-block" id="login_btn" type="submit">{{__('Login')}}</button>
                                               </div>
                                               <div class="row mb-4 rmber-area">
                                                   <div class="col-6">
                                                       <div class="custom-control custom-checkbox mr-sm-2">
                                                           <input type="checkbox" name="remember" class="custom-control-input" id="remember">
                                                           <label class="custom-control-label" for="remember">{{__('Remember Me')}}</label>
                                                       </div>
                                                   </div>
                                                   <div class="col-6 text-right">
                                                       <a class="d-block" href="{{route('user.register')}}">{{__('Create new account?')}}</a>
                                                       <a href="{{route('user.forget.password')}}">{{__('Forgot Password?')}}</a>
                                                   </div>
                                               </div>
                                           </form>
                                       </div>
                                   @else
                                       <div class="alert alert-success">
                                            {{__('Your Are Logged In As ')}} {{ auth()->user()->name}}
                                       </div>
                                   @endif
                               @endif
                            @if(auth()->check())
                            <form action="{{route('frontend.order.message')}}" method="post" enctype="multipart/form-data" class="contact-page-form style-01">
                                       @csrf
                                       <input type="hidden" name="package" value="{{$order_details->id}}">
                                       <div class="row">
                                           <div class="col-lg-12">
                                            <div class="form-group"> <input type="text" id="name" name="name" value="{{ auth()->user()->name }}"  class="form-control" placeholder="Name" readonly></div>
                                            <div class="form-group"> <input type="email" id="email" name="email"  value="{{ auth()->user()->email }}" class="form-control" placeholder="Your Email" readonly></div>
                                               {!! render_form_field_for_frontend(get_static_option('order_page_form_fields')) !!}
                                                {!! render_payment_gateway_for_form() !!}
                                           </div>
                                           <div class="col-lg-12">
                                            <div class="form-group btn-wrapper">
                                                <button class="boxed-btn btn-saas btn-block" type="submit">{{__('Order Package')}}</button>
                                            </div>
                                           </div>
                                       </div>
                            </form>
                            @endif
                       </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 mt-3">
                    <div class="right-content-area">
                        <div class="single-price-plan-01">
                            <div class="right-content-area">
                                <div class="price-header">
                                    <h4 class="title">{{ $order_details->title }}</h4>
                                    <div class="img-icon">
                                        {!! render_image_markup_by_attachment_id($order_details->image) !!}
                                    </div>
                                </div>
                                <div class="price-wrap">
                                    <span class="price">{{amount_with_currency_symbol($order_details->price)}}</span><span class="month">{{ $order_details->type }}</span>
                                </div>
                                <div class="price-body">
                                    <ul>
                                        @foreach(explode(',',$order_details->features) as $item)
                                        <li><i class="fa fa-check success"></i> {{$item}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script>
        $(document).ready(function ($) {

            $(document).on('click', '#login_btn', function (e) {
                e.preventDefault();
                var formContainer = $('#login_form_order_page');
                var el = $(this);
                var username = formContainer.find('input[name="username"]').val();
                var password = formContainer.find('input[name="password"]').val();
                var remember = formContainer.find('input[name="remember"]').val();

                el.text('{{__("Please Wait")}}');

                $.ajax({
                    type: 'post',
                    url: "{{route('user.ajax.login')}}",
                    data: {
                        _token: "{{csrf_token()}}",
                        username : username,
                        password : password,
                        remember : remember,
                    },
                    success: function (data){
                        if(data.status == 'invalid'){
                            el.text('{{__("Login")}}')
                            formContainer.find('.error-wrap').html('<div class="alert alert-danger">'+data.msg+'</div>');
                        }else{
                            formContainer.find('.error-wrap').html('');
                            el.text('{{__("Login Success.. Redirecting ..")}}');
                            location.reload();
                        }
                    },
                    error: function (data){
                        var response = data.responseJSON.errors
                        formContainer.find('.error-wrap').html('<ul class="alert alert-danger"></ul>');
                        $.each(response,function (value,index){
                            formContainer.find('.error-wrap ul').append('<li>'+value+'</li>');
                        });
                        el.text('{{__("Login")}}');
                    }
                });
            });
        
            
            var defaulGateway = $('#site_global_payment_gateway').val();
            $('.payment-gateway-wrapper ul li[data-gateway="'+defaulGateway+'"]').addClass('selected');

            $(document).on('click','.payment-gateway-wrapper > ul > li',function (e) {
                e.preventDefault();
                $(this).addClass('selected').siblings().removeClass('selected');
                $('.payment-gateway-wrapper').find(('input')).val($(this).data('gateway'));
            });

            $(document).on('change','#guest_logout',function (e) {
                e.preventDefault();
                var infoTab = $('#nav-profile-tab');
                var nextBtn = $('.next-step-btn');
                if($(this).is(':checked')){
                    $('.login-form').hide();
                    infoTab.attr('disabled',false).removeClass('disabled');
                    nextBtn.show();
                }else{
                    $('.login-form').show();
                    infoTab.attr('disabled',true).addClass('disabled');
                    nextBtn.hide();
                }
            });

        });
    </script>
@endsection
