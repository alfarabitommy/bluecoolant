<nav class="navbar-wrapper">

    <div class="navbar-custom navbar-area navbar-expand-md">

        {{-- Navbar Mobile Collapsed --}}
        <div class="d-md-none d-flex align-items-center" style="height: 50px;">
            <div class="navbar-logo">
                <div class="logo-wrapper" style="max-width:90%">
                    <a href="{{url('/')}}" class="logo">
                        {!! render_image_markup_by_attachment_id(get_static_option('site_logo')) !!}
                    </a>
                </div>
            </div>
            <!-- Burger Button -->
            <button class="navbar-toggler" type="button" style="margin-left: auto;">
                <span class="material-symbols color-gray-900" style="font-size: 16px;">menu</span>
            </button>
        </div>

        <!-- Collapsible Menu -->
        <div class="collapse navbar-collapse d-md-none d-lg-block" style="margin: 0 !important;">

            <div class="navbar-logo">
                <div class="logo-wrapper" style="max-width:135px">
                    <a href="{{url('/')}}" class="logo">
                        {!! render_image_markup_by_attachment_id(get_static_option('site_logo')) !!}
                    </a>
                </div>
            </div>

            <div class="navbar-center">
                <?php
                    $url_array =  explode('/', $_SERVER['REQUEST_URI']) ;
                    $url = end($url_array);  
                ?>
                <ul class="navbar-nav text-center">
                        <li class="<?php echo ($url=='')?'active':'' ?>">
                            <a href="<?php echo env('APP_URL'); ?>"> <?php echo get_user_lang()=='en'?'Home':'Beranda';?></a>
                        </li>
                        <li class="<?php echo ($url=='about')?'active':'' ?>">
                            <a href="<?php echo env('APP_URL'); ?>/about"> <?php echo get_user_lang()=='en'?'About Us':'Tentang Kami';?></a>
                        </li>
                        <li class="<?php echo ($url=='service')?'active':'' ?>">
                            <a href="<?php echo env('APP_URL'); ?>/service"> <?php echo get_user_lang()=='en'?'Services':'Layanan';?></a>
                        </li>
                        <li class="<?php echo (request()->segment(1) == 'product')?'active':'' ?>">
                            <a href="<?php echo env('APP_URL'); ?>/product"> <?php echo get_user_lang()=='en'?'Products':'Produk';?></a>
                        </li>
                        <li class="<?php echo ($url=='blog')?'active':'' ?>">
                            <a href="<?php echo env('APP_URL'); ?>/blog"> <?php echo get_user_lang()=='en'?'News':'Berita';?></a>
                        </li>
                        <li class="<?php echo ($url=='contact')?'active':'' ?>">
                            <a href="<?php echo env('APP_URL'); ?>/contact"> <?php echo get_user_lang()=='en'?'Contact us':'Hubungi Kami';?></a>
                        </li>
                </ul>
            </div>

            <div class="navbar-right">
                <?php
                    $lang = get_user_lang();
                ?>
                <ul>
                    <li class="d-flex align-items-center">
                        <a class="<?php echo ($lang == 'en') ? 'active' : '' ?>" href="{{ route('set.lang', ['en']) }}" >EN</a>
                        <span class="vr-line"></span>
                        <a class="<?php echo ($lang == 'id_ID') ? 'active' : '' ?>" href="{{ route('set.lang', ['id_ID']) }}">ID</a>
                    </li>
                </ul>
            </div>

        </div>

        <!-- Collapsible Menu -->
        <div id="navbar-mobile" class="d-none d-md-none d-lg-none">
            <a class="navbar-item {{ ($url=='') ? 'active' : '' }}" href="{{ env('APP_URL') }}">{{ ($lang == 'en') ? 'Home' : 'Beranda'}}</a>
            <a class="navbar-item {{ ($url=='about') ? 'active' : '' }}" href="{{ env('APP_URL').'/about' }}">{{ ($lang == 'en') ? 'About us' : 'Tentang kami'}}</a>
            <a class="navbar-item {{ ($url=='service') ? 'active' : '' }}" href="{{ env('APP_URL').'/service' }}">{{ ($lang == 'en') ? 'Services' : 'Layanan'}}</a>
            <a class="navbar-item {{ (request()->segment(1)=='product') ? 'active' : '' }}" href="{{ env('APP_URL').'/product' }}">{{ ($lang == 'en') ? 'Products' : 'Produk'}}</a>
            <a class="navbar-item {{ ($url=='blog') ? 'active' : '' }}" href="{{ env('APP_URL').'/blog' }}">{{ ($lang == 'en') ? 'News' : 'Berita'}}</a>
            <a class="navbar-item {{ ($url=='contact') ? 'active' : '' }}" href="{{ env('APP_URL').'/contact' }}">{{ ($lang == 'en') ? 'Contact us' : 'Hubungi kami'}}</a>
            <span class="hr-line"></span>
            <div class="navbar-item">
                <a class="<?php echo ($lang == 'en') ? 'active' : '' ?>" href="{{ route('set.lang', ['en']) }}" >EN</a>
                <span class="vr-line"></span>
                <a class="<?php echo ($lang == 'id_ID') ? 'active' : '' ?>" href="{{ route('set.lang', ['id_ID']) }}">ID</a>
            </div>
        </div>
    </div>

</nav>