@extends('frontend.frontend-page-master')
<!-- Sweet Alert -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
@section('og-meta')
    <meta property="og:url"  content="{{route('frontend.work.single',['id' => $work_item->id,'any' => Str::slug($work_item->title)])}}" />
    <meta property="og:type"  content="article" />
    <meta property="og:title"  content="{{$work_item->title}}" />
@endsection
@section('site-title')
    {{$work_item->title}}
@endsection
@section('page-title')
    {{__('Work Single')}}
@endsection
<title>Product Details - BLUE COOLANT INDONESIA</title>
@section('content')
<section class="detail-wrapper" style="max-width: 1435px; margin: 0 auto;">
    <section class="detail-body" style="padding-bottom: 0;">
        <div class="detail-image">
            <div class="image-display">
                    <div class="box-product">
                        <div class="main-preview-images" id="main-preview-image">
                            @if (count($work_image) > 0)
                                {!! render_image_markup_by_attachment_id($work_image[0]->image) !!}
                            @else
                                <img src="{{ env('ASSET_URL').'/assets/frontend/img/bc/blank-image.jpg' }}" alt="blank-image">
                            @endif
                        </div>

                        @if (count($work_image) > 1)
                        <div class="row d-flex align-items-center justify-content-between" style="margin:0 !important">

                            <div class="col-1 d-flex align-items-center justify-content-center">
                                <a href="#carouselExampleIndicators" role="button" data-slide="prev">
                                    <div class="carousel-nav-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 129 129" xmlns:xlink="http://www.w3.org/1999/xlink">
                                        <path d="m88.6,121.3c0.8,0.8 1.8,1.2 2.9,1.2s2.1-0.4 2.9-1.2c1.6-1.6 1.6-4.2 0-5.8l-51-51 51-51c1.6-1.6 1.6-4.2 0-5.8s-4.2-1.6-5.8,0l-54,53.9c-1.6,1.6-1.6,4.2 0,5.8l54,53.9z"/>
                                    </svg>
                                    </div>
                                </a>
                            </div>

                            <div class="image-slider">
                                <!--Start carousel-->
                                <div id="carouselExampleIndicators" class="carousel slide" data-interval="false">
                                    <div class="carousel-inner">
                                        @foreach ($work_image->chunk(3) as $chunkIndex => $chunk)
                                            <div class="carousel-item {{ $chunkIndex == 0 ? 'active' : '' }}">
                                                <div class="row">
                                                    
                                                    @php
                                                        $totalImages = count($chunk);
                                                        if($totalImages === 3){
                                                            $colClass = 'col-4';
                                                        }else if($totalImages === 2){
                                                            $colClass = 'col-6';
                                                        }else if($totalImages === 1){
                                                            $colClass = 'col-12';
                                                        }
                                                    @endphp

                                                    @foreach ($chunk as $image)
                                                    <div class="{{ $colClass }} col col-sm col-md col-xl d-flex align-items-center justify-content-center" style="margin: 0px !important;">
                                                        <div class="carousel-thumb {{ $loop->first && $chunkIndex == 0 ? 'active' : '' }}" data-image-id="{{ $image->image }}" style="cursor: pointer;">
                                                            {!! render_image_markup_by_attachment_id($image->image) !!}
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <!--End carousel-->
                            </div>

                            <div class="col-1 d-flex align-items-center justify-content-center">
                                <a  href="#carouselExampleIndicators" data-slide="next">
                                    <div class="carousel-nav-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 129 129" xmlns:xlink="http://www.w3.org/1999/xlink">
                                        <path d="m40.4,121.3c-0.8,0.8-1.8,1.2-2.9,1.2s-2.1-0.4-2.9-1.2c-1.6-1.6-1.6-4.2 0-5.8l51-51-51-51c-1.6-1.6-1.6-4.2 0-5.8 1.6-1.6 4.2-1.6 5.8,0l53.9,53.9c1.6,1.6 1.6,4.2 0,5.8l-53.9,53.9z"/>
                                    </svg>
                                    </div>
                                </a>
                            </div>
                            
                        </div>
                        @endif
                    </div>
            </div>
        </div>
        <div class="detail-item">
            <ol class="detail-breadcrumb">
                <li><a href="<?php echo env('APP_URL'); ?>/product">{{ (get_user_lang() == 'en') ? 'Products' : 'Produk' }}</a></li>
                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M8.58984 16.58L13.1698 12L8.58984 7.41L9.99984 6L15.9998 12L9.99984 18L8.58984 16.58Z" fill="#404040"/>
                    </svg>
                </li>
                <li><a href="<?php echo env('APP_URL'); ?>/product#category-<?php echo $work_item->category_id?>">{{ $work_item->name}}</a></li>
                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M8.58984 16.58L13.1698 12L8.58984 7.41L9.99984 6L15.9998 12L9.99984 18L8.58984 16.58Z" fill="#404040"/>
                    </svg>
                </li>
                <li><a href="<?php echo env('APP_URL'); ?>/product/detail/<?php echo rawurlencode($work_item->title) ?>/<?php echo $work_item->lang?>">{{ $work_item->title}}</a></li>
            </ol>
            <h1 class="detail-header">
                {{ $work_item->title }}
            </h1>
            <div class="detail-description">
                {!! $work_item->description !!}
            </div>
            <div class="detail-cta">
                <i>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M12 3C6.5 3 2 6.6 2 11C2 13.2 3.1 15.2 4.8 16.5C4.8 17.1 4.4 18.7 2 21C4.4 20.9 6.6 20 8.5 18.5C9.6 18.8 10.8 19 12 19C17.5 19 22 15.4 22 11C22 6.6 17.5 3 12 3ZM12 17C7.6 17 4 14.3 4 11C4 7.7 7.6 5 12 5C16.4 5 20 7.7 20 11C20 14.3 16.4 17 12 17ZM12.2 6.5C11.3 6.5 10.6 6.7 10.1 7C9.5 7.4 9.2 8 9.3 8.7H11.3C11.3 8.4 11.4 8.2 11.6 8.1C11.8 8 12 7.9 12.3 7.9C12.6 7.9 12.9 8 13.1 8.2C13.3 8.4 13.4 8.6 13.4 8.9C13.4 9.2 13.3 9.4 13.2 9.6C13 9.8 12.8 10 12.6 10.1C12.1 10.4 11.7 10.7 11.5 10.9C11.1 11.2 11 11.5 11 12H13C13 11.7 13.1 11.5 13.1 11.3C13.2 11.1 13.4 11 13.6 10.8C14.1 10.6 14.4 10.3 14.7 9.9C15 9.5 15.1 9.1 15.1 8.7C15.1 8 14.8 7.4 14.3 7C13.9 6.7 13.1 6.5 12.2 6.5ZM11 13V15H13V13H11Z" fill="#262626"/>
                    </svg>
                </i>
                <p>
                    {{ (get_user_lang() == 'en') ? 'Interested in product pricing? Please don’t hesitate to ' : 'Tertarik dengan harga produk? Jangan ragu untuk ' }}<a href="<?php echo env('APP_URL'); ?>/contact">{{ (get_user_lang() == 'en') ? 'contact us' : 'hubungi kami' }}</a>
                </p>
            </div>
            <div class="detail-catalog">
                <a href="<?= env('ASSET_URL') ?>/assets/uploads/catalog/products_catalog.pdf" class="btn-catalog" download="BCI - Product Catalog" target="_blank">
                    {{ (get_user_lang() == 'en') ? 'Download Catalog' : 'Unduh Katalog' }}
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M12 16L7 11L8.4 9.55L11 12.15V4H13V12.15L15.6 9.55L17 11L12 16ZM6 20C5.45 20 4.97917 19.8042 4.5875 19.4125C4.19583 19.0208 4 18.55 4 18V15H6V18H18V15H20V18C20 18.55 19.8042 19.0208 19.4125 19.4125C19.0208 19.8042 18.55 20 18 20H6Z" fill="#FDFDFD"/>
                    </svg>
                </a>
                @if ($work_item->tds != '')
                    <a href="" class="btn-tds" data-toggle="modal" data-target="#modal-tds">
                        Request TDS
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M5 21C4.45 21 3.97917 20.8042 3.5875 20.4125C3.19583 20.0208 3 19.55 3 19V15H5V19H19V5H5V9H3V5C3 4.45 3.19583 3.97917 3.5875 3.5875C3.97917 3.19583 4.45 3 5 3H19C19.55 3 20.0208 3.19583 20.4125 3.5875C20.8042 3.97917 21 4.45 21 5V19C21 19.55 20.8042 20.0208 20.4125 20.4125C20.0208 20.8042 19.55 21 19 21H5ZM10.5 17L9.1 15.55L11.65 13H3V11H11.65L9.1 8.45L10.5 7L15.5 12L10.5 17Z" fill="#1156EB"/>
                        </svg>
                    </a>

                    <div class="modal fade" id="modal-tds" tabindex="-1" role="dialog" aria-labelledby="modal-tds" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-h5">Request TDS</h5>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('frontend.request.tds') }}" id="request_tds" method="POST">
                                        @csrf
                                        <input type="hidden" name="works_id" value="{{ $work_item->work_id }}">
                                        <div class="form-group">
                                            <label>Name <span class="star">*</span></label>
                                            <input type="text" name="name" class="form-control" placeholder="Your name" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Email <span class="star">*</span></label>
                                            <input type="email" name="email" class="form-control" placeholder="Your email" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Company <span class="star">*</span></label>
                                            <input type="text" name="company" class="form-control" placeholder="Your company" required>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="float-right d-flex">
                                                    <button type="button" class="btn-cancel" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn-submit" style="margin-left: 16px">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        // DOWNLOAD FILE SETELAH SUBMIT
                        $('#request_tds').on('submit', function(e) {
                            e.preventDefault();

                            $('.btn-submit').attr('disabled', true);
                            $('.btn-submit').text('Loading...');

                            let form = $(this);
                            let formData = new FormData(this);

                            $.ajax({
                                url: form.attr('action'),
                                type: 'POST',
                                data: formData,
                                processData: false,
                                contentType: false,
                                success: function(response) {
                                    // Close modal
                                    $('#modal-tds').modal('hide');
                                    window.location.reload();
                                },
                                error: function(xhr) {
                                    alert("Gagal request TDS");
                                }
                            });
                        });
                    </script>

                @endif
            </div>
            <hr class="divider">
            
            @if (count($sector) > 0)
            <div class="detail-sub">
                <h3 class="detail-sub-header">{{ (get_user_lang() == 'en') ? 'Sector' : 'Sektor' }}</h3>
                <div class="detail-sub-btn">
                    @foreach($sector as $datas)
                    <span class="btn-detail">{{ $datas->name }}</span>
                    @endforeach
                </div>
            </div>
            @endif
            
            @if (count($packagings) > 0)
            <div class="detail-sub">
                <h3 class="detail-sub-header">{{ (get_user_lang() == 'en') ? 'Packaging' : 'Kemasan' }}</h3>
                <div class="detail-sub-btn">
                    @foreach ($packagings as $packaging)
                        <span class="btn-detail">{{ $packaging->name }}</span>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="detail-sub">
                <h3 class="detail-sub-header">{{ (get_user_lang() == 'en') ? 'Benefits' : 'Keunggulan' }}</h3>
                <div class="detail-sub-list">
                    {!! $work_item->benefit !!}
                </div>
            </div>
        </div>
    </section>
    @if ($oems->count() > 0 || $industries->count() > 0)
    <section class="detail-spec">
        <div class="detail-spec-header">
            <h3>Specification & Approvals</h3>
        </div>
        <div class="detail-spec-table">

            <div class="detail-spec-app">
                <h3>OEM</h3>
                <table class="detail-table">
                    <thead>
                        <tr>
                            <th>Specification</th>
                            <th>Approval</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($oems->count() > 0)
                            @foreach ($oems as $oem)
                            <tr>
                                <td>{{$oem->spec}}</td>
                                <td>{{$oem->approval}}</td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td class="text-center" colspan="2">-</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            
            <div class="detail-spec-app">
                <h3>INDUSTRY</h3>
                <table class="detail-table">
                    <thead>
                        <tr>
                            <th>Specification</th>
                            <th>Approval</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($industries->count() > 0)
                            @foreach ($industries as $industry)
                                <tr>
                                    <td>{{$industry->spec}}</td>
                                    <td>{{$industry->approval}}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td class="text-center" colspan="2">-</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    @endif
    <section class="detail-similar">
    <h3>{{ (get_user_lang() == 'en') ? 'Similar Product' : 'Produk Serupa' }}</h3>
    <div class="card-body">
        @foreach($similar_products as $data)
        <div class="col-3 col-md-2 col-lg-3">
            <div class="box-product">
                <a href="<?php echo env('APP_URL'); ?>/product/detail/<?php echo rawurlencode($data->title)?>/<?php echo $data->lang?>">
                    @if ($data->image)
                        {!! render_image_markup_by_attachment_id($data->image, 'img-product') !!}
                    @else
                        <img src="{{ env('ASSET_URL').'/assets/frontend/img/bc/blank-image.jpg' }}" class="img-product" alt="blank-image">
                    @endif
                </a>
                <h5 class="bc-product-title">{!! $data->title !!}</h5>
                {{-- <div class="bc-product-desc">{!! mb_strimwidth(strip_tags($data->description), 0, 130, '...')  !!}</div> --}}
            </div>
        </div>
        @endforeach
    </div>
    </section>
</section>
@if (session('success_tds'))
    <script>
        swal('Success!','{{ session("success_tds") }}', 'success');
    </script>
@endif
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('.carousel-thumb').on('click', function () {
            var imageId = $(this).data('image-id');
            var $container = $('#main-preview-image');
            var blankUrl = "{{ env('ASSET_URL') . '/assets/frontend/img/bc/blank-image.jpg' }}";


            // Optional: tambahkan efek loading
            $container.css('opacity', 0.5);

            $.get("{{ url('/get-product-detail-image') }}", { id: imageId }, function (response) {
                // Buat image baru dari HTML response
                var tempDiv = $('<div>').html(response.html);
                var newImg = tempDiv.find('img').get(0);

                if (newImg) {
                    // Tunggu gambar selesai dimuat
                    newImg.onload = function () {
                        // Ganti konten ketika gambar sudah ready
                        $container.html(response.html).css('opacity', 1);
                    };

                    newImg.onerror = function () {
                        // Jika gagal, tetap tampilkan HTML tapi mungkin fallback
                        $container.html('<img src="'+blankUrl+'" alt="Error loading image">').css('opacity', 1);
                    };

                    // Set src untuk mulai load
                    newImg.src = newImg.src; // re-trigger load in some cases
                } else {
                    // Jika tidak ada <img> dalam response
                    $container.html(response.html).css('opacity', 1);
                }
            });

            $('.carousel-thumb').not(this).removeClass('active');
            $(this).addClass('active');
        });
    });
</script>
