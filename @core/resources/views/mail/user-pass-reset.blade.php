<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{__('User Password Reset')}}</title>
    <style>
        .mail-container {
            max-width: 650px;
            margin: 0 auto;
            text-align: center;
        }

        .mail-container .logo-wrapper {
            background-color: #111d5c;
            padding: 20px 0 20px;
        }


        footer {
            margin: 20px 0;
            font-size: 10px;
        }
        .mail-container .message-box{
            text-align: left;
            margin: 40px 0;
        }
        .btn{
            background-color:#444;
            color:#fff;
            text-decoration:none;
            padding: 10px 15px;
            border-radius: 3px;
            display: block;
            width: 130px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="mail-container">
    <div class="logo-wrapper">
        <a href="{{url('/')}}">
            @php
                $site_logo = get_attachment_image_by_id(get_static_option('site_logo'),"full",false);
            @endphp
            @if (!empty($site_logo))
                <img src="{{$site_logo['img_url']}}" alt="{{get_static_option('site_'.get_user_lang().'_title')}}">
            @endif
        </a>
    </div>
    <div class="message-box">
        @php
            $message = get_static_option('site_global_email_template_'.get_user_lang());
            $message = str_replace(['@username','@message','@company'],[$data['username'],$data['message'],get_static_option('site_'.get_default_language().'_title')],$message);
        @endphp
        {!! $message !!}
    </div>
    <footer>
        {!! render_footer_copyright_text() !!}
    </footer>
</div>
</body>
</html>
