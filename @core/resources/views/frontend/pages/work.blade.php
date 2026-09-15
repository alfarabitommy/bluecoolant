@extends('frontend.frontend-page-master')
@section('site-title')
    {{get_static_option('work_page_'.$user_select_lang_slug.'_name')}}
@endsection
@section('page-title')
    {{get_static_option('work_page_'.$user_select_lang_slug.'_name')}}
@endsection

@section('meta-name')
<?php
if(get_user_lang()=='en'){
?>
<meta name="title" content="Products | Blue Coolant Indonesia - Best Radiator Coolant Solution">
<meta name="description" content="PT. Blue Coolant Indonesia provides solutions to your needs with several product variants including Radiator coolant, Degreaser and other complementary products.">
<?php
} else {
?>
<meta name="title" content="Produk Kami | Blue Coolant Indonesia - Solusi Radiator Coolant Terbaik">
<meta name="description" content="PT. Blue Coolant Indonesia memberikan solusi kebutuhan Anda dengan beberapa varian produk di antaranya Radiator coolant, Degreaser dan produk pelengkap lainnya.">
<?php
}
?>
@endsection

@section('schema')
<script type="application/ld+json">
{
 "@context": "http://schema.org",
 "@type": "Organization",
 "name": "Bluecoolant Indonesia",
 "logo": "https://bluecoolant.com/assets/uploads/media-uploader/blue-coolant-logo-blue1694673523.png",
 "url": "https://bluecoolant.com/"
}
</script>
@endsection
<title>Products - BLUE COOLANT INDONESIA</title>
@section('content')

<section class="work-breadcrumb-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-inner">
                    <h1 class="title">{{ get_user_lang()=='en'?'Products.':'Produk.' }}</h1>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="product-wrapper" style="background: #fff">
    <div class="section-product" style="max-width: 1435px; margin: 0 auto;">
        <div class="header-product">
            <h3>Our Products</h3>
            <div class="header-category">
                <?php
                    $actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

                    $arrParam = array();

                    $isActiveCategory = '';
                    if(isset($_GET["cat"])){
                        $isActiveCategory = (int)$_GET["cat"]; 
                        $arrParam['cat'] = $_GET["cat"];
                    }

                    $isActiveSectors = '';
                    if(isset($_GET["sector"])){
                        $isActiveSectors = (int)$_GET["sector"]; 
                        $arrParam['sector'] = $_GET["sector"];
                    }

                    $isActiveSearch = '';
                    if(isset($_GET["search"])){
                        $isActiveSearch = (int)$_GET["search"]; 
                        $arrParam['search'] = $_GET["search"];
                    }


                    $allCatParam = $arrParam;
                    unset($allCatParam['cat']);

                    $urparamAllCategory = http_build_query($allCatParam);
                    $allSectorsParam = $arrParam;
                    unset($allSectorsParam['sector']);

                    $urlAllSectors = http_build_query($allSectorsParam);

                ?> 
                @foreach($all_work_category as $data)
                <a class="category-button" id="categorybtn-{{ $data->id }}" href="">{{$data->name}}</a>
                @endforeach
            </div>
        </div>
        <div class="body-product">

            @foreach ($all_work_category as $category)
            <div class="accordion custom-accordion" id="accordion-{{ $category->id }}">
                <div class="card">
                    <div class="card-header d-flex align-items-center" id="heading-{{ $category->id }}" data-toggle="collapse" data-target="#collapse-{{ $category->id }}" aria-expanded="true" aria-controls="collapse-{{ $category->id }}">
                        <h5 class="card-titles">{{ $category->name }}</h5>
                        <span id="icon-collapse-{{ $category->id }}" class="material-symbols" style="margin-left: auto; font-size: 24px; color: var(--color-white)">{{ $loop->first ? 'remove' : 'add' }}</span>
                    </div>

                    <div id="collapse-{{ $category->id }}" class="collapse {{ $loop->first ? 'show' : '' }}" aria-labelledby="heading-{{ $category->name }}" data-parent="#accordion-{{ $category->id }}">
                    <div class="card-body">
                        @if ($products[$category->id]['sub'])
                            @foreach($products[$category->id]['data'] as $sub_name => $data)
                            <!-- CHILD -->
                            <div class="accordion custom-accordion" id="accordion-{{ Str::slug($sub_name); }}">
                                <div class="card card-child">
                                    <div class="card-header-child" id="heading-{{ Str::slug($sub_name); }}" data-toggle="collapse" data-target="#collapse-{{ Str::slug($sub_name);}}" aria-expanded="true" aria-controls="collapse-{{ Str::slug($sub_name); }}">
                                        <h5 class="card-titles">{{ $sub_name }}</h5>
                                        <span id="icon-collapse-child-{{ Str::slug($sub_name); }}" class="material-symbols" style="margin-left: auto; font-size: 24px; {{ $loop->first ? 'color: var(--color-white)' : 'color: var(--color-black)' }}">{{ $loop->first ? 'remove' : 'add' }}</span>
                                    </div>

                                    <div id="collapse-{{ Str::slug($sub_name); }}" class="collapse {{ $loop->first ? 'show' : '' }}" aria-labelledby="heading-{{ Str::slug($sub_name); }}" data-parent="#accordion-{{ Str::slug($sub_name); }}">
                                        <div class="card-body">
                                            
                                                {{-- product query result object --}}
                                                @foreach ($data as $dataa)  
                                                    <div class=" col-12 col-md-2 col-lg-3">
                                                        <div class="box-product">
                                                            @php
                                                                $image_id = get_attachment_image_by_id($dataa->image);
                                                                $image_url = isset($image_id["img_url"]) ? $image_id["img_url"] : '';
                                                            @endphp
                                                            
                                                            <a href="<?php echo env('APP_URL'); ?>/product/detail/<?php echo rawurlencode($dataa->title)?>/{{ get_user_lang() }}">
                                                                @if ($dataa->image)
                                                                    {!! render_image_markup_by_attachment_id($dataa->image, 'img-product') !!}
                                                                @else
                                                                    <img src="{{ env('ASSET_URL').'/assets/frontend/img/bc/blank-image.jpg' }}" class="img-product" alt="blank-image">
                                                                @endif
                                                                <h5 class="bc-product-title mt-2 mb-2">{!! $dataa->title !!}</h5>
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            @foreach($products[$category->id]['data'] as $data)
                                <div class="col-12 col-md-2 col-lg-3">
                                    <div class="box-product">


                                        @php
                                            $image_id = get_attachment_image_by_id($data->image);
                                            $image_url = isset($image_id["img_url"]) ? $image_id["img_url"] : '';
                                        @endphp
                                        
                                        <a href="<?php echo env('APP_URL'); ?>/product/detail/<?php echo rawurlencode($data->title)?>/{{ get_user_lang() }}">
                                            @if ($data->image)
                                                {!! render_image_markup_by_attachment_id($data->image, 'img-product') !!}
                                            @else
                                                <img src="{{ env('ASSET_URL').'/assets/frontend/img/bc/blank-image.jpg' }}" class="img-product" alt="blank-image">
                                            @endif
                                            <h5 class="bc-product-title mt-2 mb-2">{!! $data->title !!}</h5>
                                        </a>
                                        
                                        {{-- <div class="bc-product-desc">{!! mb_strimwidth(strip_tags($data->description), 0, 130, '...')  !!}</div> --}}
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    </div>
                </div>
            </div>
            @endforeach

            <div class="col-md-12 margin-top-40">
                <div class="card-product-contact">
                    <h3 class="text-h3 color-white">Let's get in touch</h3>
                    <p>We’d love to help you choose the right coolant or answer any questions you have.</p>
                    <a href="<?php echo env('APP_URL'); ?>/contact">Contact us <span class="material-symbols" style="font-size: 20px ">arrow_forward</span></a>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function changeChildColor() {
        // show
        $('.card-child .collapse.show').each(function () {
            const id = $(this).attr('id');
            const start_idx = id.indexOf('-');
            const category_id = id.substring(start_idx + 1);

            $('#heading-'+ category_id).css('background','#404040');
            $('#heading-'+ category_id + ' .card-titles').attr('style', 'color: #FDFDFD !important');
        });
        // hide
        $('.card-child .collapse').not('.show').each(function () {
            const id = $(this).attr('id');
            const start_idx = id.indexOf('-');
            const category_id = id.substring(start_idx + 1);

            $('#heading-'+ category_id).css('background','#F5F5F5');
            $('#heading-'+ category_id + ' .card-titles').attr('style', 'color: #171717 !important');
        });
    }

    function changeCollapseIcon() {
        // Untuk kategori
        $('.section-product .collapse.show').each(function () {
            const id = $(this).attr('id');
            const start_idx = id.indexOf('-');
            const category_id = id.substring(start_idx + 1);

            $('#icon-collapse-'+ category_id).text('remove');
        })

        $('.section-product .collapse').not('.show').each(function () {
            const id = $(this).attr('id');
            const start_idx = id.indexOf('-');
            const category_id = id.substring(start_idx + 1);

            $('#icon-collapse-'+ category_id).text('add');
        })
            
        // Untuk subkategori
        $('.section-product .card-child .collapse.show').each(function () {
            const id = $(this).attr('id');
            if (id.startsWith('collapse-')) {
                const sub_name = id.replace('collapse-', '');
                $('#icon-collapse-child-' + sub_name).text('remove').css('color', '#ffffff');
            }
        });

        $('.section-product .card-child .collapse').not('.show').each(function () {
            const id = $(this).attr('id');
            if (id.startsWith('collapse-')) {
                const sub_name = id.replace('collapse-', '');
                $('#icon-collapse-child-' + sub_name).text('add').css('color', '');
            }
        });

    }

    function hashScroll() {
        // from products in footer by category
        var hash = window.location.hash;
        if (hash && hash.startsWith('#category-')) {
            var category_id = hash.replace('#category-', '');

            $('#heading-'+ category_id).collapse('show');
            $('#collapse-'+ category_id).collapse('show');    

            if ($('.navbar-area').hasClass('nav-fixed')) {
                $(window).scrollTop( $('#heading-' + category_id).offset().top - $('.navbar-area.nav-fixed').outerHeight() || 0 );
            } else {
                $(window).scrollTop( $('#heading-' + category_id).offset().top - 400);
            }
        }
    }

    $(function () {
        hashScroll();
        changeChildColor();

        $('.collapse').on('shown.bs.collapse hidden.bs.collapse', function () {
            changeChildColor();
            changeCollapseIcon();
        });

        $('.category-button').on('click', function(e) {
            e.preventDefault();

            var id = $(this).attr('id');
            var start_idx = id.indexOf('-');
            var category_id = id.substring(start_idx + 1);

            $('#heading-'+ category_id).collapse('show');
            $('#collapse-'+ category_id).collapse('show');    

            if ($('.navbar-area').hasClass('nav-fixed')) {
                $(window).scrollTop( $('#heading-' + category_id).offset().top - $('.navbar-area.nav-fixed').outerHeight() || 0);
            } else {
                $(window).scrollTop( $('#heading-' + category_id).offset().top - 400);
            }
        })
    })

    $(window).on('hashchange', function() {
        hashScroll();
    })
</script>