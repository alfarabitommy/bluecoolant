{{-- <footer class="footer-area footer-bg footer-bl"> --}}
<footer class="footer">

<?php
    $wa_no = '';
    $about = '';
    $phone = '';
    $email = '';
    $address = '';
    foreach($all_support_item as $data){
        //echo  $data->icon.' - '.$data->details.'<br>';
        if($data->icon == 'fab fa-whatsapp'){
            $wa_no = $data->details;
        }
        if($data->icon == 'fas fa-envelope'){
            $email = $data->details;
        }
        if($data->icon == 'fas fa-phone'){
            $phone = $data->details;
        }
        if($data->icon == 'fas fa-map-marker-alt'){
            $address = $data->details;
        }
        if($data->icon == 'fas fa-info'){
            $about = $data->details;
        }
    }
?>

<div class="footer-content">
    <div class="footer-logo">
        <div style="max-width:300px">
        <a href="{{url('/')}}" class="logo">
            {!! render_image_markup_by_attachment_id(get_static_option('site_logo')) !!}
        </a>
        </div>
        <div class="footer-logo-caption">
            @if (get_user_lang() == 'en')
                <p>
                    PT. Blue Coolant Indonesia provides solutions for your needs through a range of products including radiator coolants, degreasers, and other complementary items.
                </p>
            @else
                <p>
                    PT. Blue Coolant Indonesia memberikan solusi kebutuhan Anda dengan beberapa varian produk di antaranya Radiator coolant, Degreaser dan produk pelengkap lainnya.
                </p>
            @endif
        </div>
    </div>

    <div class="footer-link">
        <div class="footer-list">
            <h3>{{ (get_user_lang() == 'en') ? 'Quick Links' : 'Tautan Langsung' }}</h3>
            <ol>
                <li><a href="<?php echo env('APP_URL'); ?>">{{ (get_user_lang() == 'en') ? 'Home' : 'Beranda' }}</a></li>
                <li><a href="<?php echo env('APP_URL'); ?>/about">{{ (get_user_lang() == 'en') ? 'About Us' : 'Tentang Kami' }}</a></li>
                <li><a href="<?php echo env('APP_URL'); ?>/service">{{ (get_user_lang() == 'en') ? 'Services' : 'Layanan' }}</a></li>
                <li><a href="<?php echo env('APP_URL'); ?>/blog">{{ (get_user_lang() == 'en') ? 'News' : 'Berita' }}</a></li>
                <li><a href="<?php echo env('APP_URL'); ?>/contact">{{ (get_user_lang() == 'en') ? 'Contact' : 'Kontak' }}</a></li>
            </ol>
        </div>

        <div class="footer-list">
            <h3>{{ (get_user_lang() == 'en') ? 'Products' : 'Produk' }}</h3>
            <ol>
                <li><a href="{{ env('APP_URL').'/product#category-'.((get_user_lang() == 'en') ? '1' : '4') }}">Coolant</a></li>
                <li><a href="{{ env('APP_URL').'/product#category-'.((get_user_lang() == 'en') ? '2' : '5') }}">Degreaser</a></li>
                <li><a href="{{ env('APP_URL').'/product#category-'.((get_user_lang() == 'en') ? '7' : '8') }}" class="" id="">Diesel Exhaust Fluid</a></li>
                <li><a href="{{ env('APP_URL').'/product#category-'.((get_user_lang() == 'en') ? '3' : '6') }}">{{ (get_user_lang() == 'en') ? 'Others' : 'Lainnya' }}</a></li>
            </ol>
        </div>
        
        <div class="footer-list">
            <h3>{{ (get_user_lang() == 'en') ? 'Get in Touch' : 'Hubungi Kami' }}</h3>
            <ol>
                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="17" viewBox="0 0 16 17" fill="none">
                        <path d="M13.3333 10.8333C12.5333 10.8333 11.6667 10.7 10.9333 10.4333H10.7333C10.5333 10.4333 10.4 10.5 10.2667 10.6333L8.8 12.1C6.93333 11.1 5.33333 9.56667 4.4 7.7L5.86667 6.23333C6.06667 6.03333 6.13333 5.76667 6 5.56667C5.8 4.83333 5.66667 3.96667 5.66667 3.16667C5.66667 2.83333 5.33333 2.5 5 2.5H2.66667C2.33333 2.5 2 2.83333 2 3.16667C2 9.43333 7.06667 14.5 13.3333 14.5C13.6667 14.5 14 14.1667 14 13.8333V11.5C14 11.1667 13.6667 10.8333 13.3333 10.8333ZM3.33333 3.83333H4.33333C4.4 4.43333 4.53333 5.03333 4.66667 5.56667L3.86667 6.36667C3.6 5.56667 3.4 4.7 3.33333 3.83333ZM12.6667 13.1667C11.8 13.1 10.9333 12.9 10.1333 12.6333L10.9333 11.8333C11.4667 11.9667 12.0667 12.1 12.6667 12.1V13.1667Z" fill="#1156EB"/>
                    </svg>
                    <span>+62 21-3866065</span>
                </li>
                <li> 
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="17" viewBox="0 0 16 17" fill="none">
                        <path d="M14.6668 4.50002C14.6668 3.76669 14.0668 3.16669 13.3335 3.16669H2.66683C1.9335 3.16669 1.3335 3.76669 1.3335 4.50002V12.5C1.3335 13.2334 1.9335 13.8334 2.66683 13.8334H13.3335C14.0668 13.8334 14.6668 13.2334 14.6668 12.5V4.50002ZM13.3335 4.50002L8.00016 7.83335L2.66683 4.50002H13.3335ZM13.3335 12.5H2.66683V5.83335L8.00016 9.16669L13.3335 5.83335V12.5Z" fill="#1156EB"/>
                    </svg>
                    <a href="mailto:info@bluecoolant.com" target="_blank">
                        info@bluecoolant.com
                    </a>
                </li>
                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="17" viewBox="0 0 16 17" fill="none">
                        <path d="M8.00016 4.83331C8.44219 4.83331 8.86611 5.00891 9.17867 5.32147C9.49123 5.63403 9.66683 6.05795 9.66683 6.49998C9.66683 6.71885 9.62372 6.93558 9.53996 7.13779C9.4562 7.33999 9.33344 7.52373 9.17867 7.67849C9.02391 7.83325 8.84018 7.95602 8.63797 8.03978C8.43576 8.12354 8.21903 8.16665 8.00016 8.16665C7.55814 8.16665 7.13421 7.99105 6.82165 7.67849C6.50909 7.36593 6.3335 6.94201 6.3335 6.49998C6.3335 6.05795 6.50909 5.63403 6.82165 5.32147C7.13421 5.00891 7.55814 4.83331 8.00016 4.83331ZM8.00016 1.83331C9.23784 1.83331 10.4248 2.32498 11.3 3.20015C12.1752 4.07532 12.6668 5.2623 12.6668 6.49998C12.6668 9.99998 8.00016 15.1666 8.00016 15.1666C8.00016 15.1666 3.3335 9.99998 3.3335 6.49998C3.3335 5.2623 3.82516 4.07532 4.70033 3.20015C5.5755 2.32498 6.76249 1.83331 8.00016 1.83331ZM8.00016 3.16665C7.11611 3.16665 6.26826 3.51784 5.64314 4.14296C5.01802 4.76808 4.66683 5.61592 4.66683 6.49998C4.66683 7.16665 4.66683 8.49998 8.00016 12.9733C11.3335 8.49998 11.3335 7.16665 11.3335 6.49998C11.3335 5.61592 10.9823 4.76808 10.3572 4.14296C9.73206 3.51784 8.88422 3.16665 8.00016 3.16665Z" fill="#1156EB"/>
                    </svg>
                    <span>
                        Jl. Cideng Barat No. 87, Jakarta Pusat 10150
                    </span>
                </li>
            </ol>

            
            <h3>{{ (get_user_lang() == 'en') ? 'Social Media' : 'Media Sosial' }}</h3>
            <ol>
                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M12.6667 2C13.0203 2 13.3594 2.14048 13.6095 2.39052C13.8595 2.64057 14 2.97971 14 3.33333V12.6667C14 13.0203 13.8595 13.3594 13.6095 13.6095C13.3594 13.8595 13.0203 14 12.6667 14H3.33333C2.97971 14 2.64057 13.8595 2.39052 13.6095C2.14048 13.3594 2 13.0203 2 12.6667V3.33333C2 2.97971 2.14048 2.64057 2.39052 2.39052C2.64057 2.14048 2.97971 2 3.33333 2H12.6667ZM12.3333 12.3333V8.8C12.3333 8.2236 12.1044 7.6708 11.6968 7.26322C11.2892 6.85564 10.7364 6.62667 10.16 6.62667C9.59333 6.62667 8.93333 6.97333 8.61333 7.49333V6.75333H6.75333V12.3333H8.61333V9.04667C8.61333 8.53333 9.02667 8.11333 9.54 8.11333C9.78754 8.11333 10.0249 8.21167 10.2 8.3867C10.375 8.56173 10.4733 8.79913 10.4733 9.04667V12.3333H12.3333ZM4.58667 5.70667C4.88371 5.70667 5.16859 5.58867 5.37863 5.37863C5.58867 5.16859 5.70667 4.88371 5.70667 4.58667C5.70667 3.96667 5.20667 3.46 4.58667 3.46C4.28786 3.46 4.00128 3.5787 3.78999 3.78999C3.5787 4.00128 3.46 4.28786 3.46 4.58667C3.46 5.20667 3.96667 5.70667 4.58667 5.70667ZM5.51333 12.3333V6.75333H3.66667V12.3333H5.51333Z" fill="#1156EB"/>
                    </svg>
                    <a href="https://www.linkedin.com/company/bluecoolant/?originalSubdomain=id" target="_blank">
                        Blue Coolant Indonesia
                    </a>
                </li>
                <li> 
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M5.20016 1.33334H10.8002C12.9335 1.33334 14.6668 3.06668 14.6668 5.20001V10.8C14.6668 11.8255 14.2594 12.809 13.5343 13.5342C12.8092 14.2593 11.8257 14.6667 10.8002 14.6667H5.20016C3.06683 14.6667 1.3335 12.9333 1.3335 10.8V5.20001C1.3335 4.17451 1.74088 3.191 2.46602 2.46586C3.19116 1.74072 4.17466 1.33334 5.20016 1.33334ZM5.06683 2.66668C4.43031 2.66668 3.81986 2.91953 3.36977 3.36962C2.91969 3.81971 2.66683 4.43016 2.66683 5.06668V10.9333C2.66683 12.26 3.74016 13.3333 5.06683 13.3333H10.9335C11.57 13.3333 12.1805 13.0805 12.6306 12.6304C13.0806 12.1803 13.3335 11.5699 13.3335 10.9333V5.06668C13.3335 3.74001 12.2602 2.66668 10.9335 2.66668H5.06683ZM11.5002 3.66668C11.7212 3.66668 11.9331 3.75447 12.0894 3.91075C12.2457 4.06703 12.3335 4.279 12.3335 4.50001C12.3335 4.72102 12.2457 4.93299 12.0894 5.08927C11.9331 5.24555 11.7212 5.33334 11.5002 5.33334C11.2791 5.33334 11.0672 5.24555 10.9109 5.08927C10.7546 4.93299 10.6668 4.72102 10.6668 4.50001C10.6668 4.279 10.7546 4.06703 10.9109 3.91075C11.0672 3.75447 11.2791 3.66668 11.5002 3.66668ZM8.00016 4.66668C8.88422 4.66668 9.73206 5.01787 10.3572 5.64299C10.9823 6.26811 11.3335 7.11595 11.3335 8.00001C11.3335 8.88406 10.9823 9.73191 10.3572 10.357C9.73206 10.9822 8.88422 11.3333 8.00016 11.3333C7.11611 11.3333 6.26826 10.9822 5.64314 10.357C5.01802 9.73191 4.66683 8.88406 4.66683 8.00001C4.66683 7.11595 5.01802 6.26811 5.64314 5.64299C6.26826 5.01787 7.11611 4.66668 8.00016 4.66668ZM8.00016 6.00001C7.46973 6.00001 6.96102 6.21072 6.58595 6.5858C6.21088 6.96087 6.00016 7.46958 6.00016 8.00001C6.00016 8.53044 6.21088 9.03915 6.58595 9.41422C6.96102 9.7893 7.46973 10 8.00016 10C8.5306 10 9.0393 9.7893 9.41438 9.41422C9.78945 9.03915 10.0002 8.53044 10.0002 8.00001C10.0002 7.46958 9.78945 6.96087 9.41438 6.5858C9.0393 6.21072 8.5306 6.00001 8.00016 6.00001Z" fill="#1156EB"/>
                    </svg>
                    <a href="https://www.instagram.com/bluecoolantid/" target="_blank">
                        bluecoolantid
                    </a>
                </li>
            </ol>
        </div>

    </div>
</div>

<div class="footer-title">
    <p>&copy; 2025 Copyright, Blue Coolant Indonesia</p>
</div>

</footer>



<div class="preloader" id="preloader">
    <div class="preloader-inner">
        <div class="lds-ripple"><div></div><div></div></div>
    </div>
</div>

<div class="back-to-top">
    <i class="fas fa-angle-up"></i>
</div>

<div class="wa-link">

<?php
    $wa_no = '';
    foreach($all_support_item as $data){
       //echo  $data->icon.' - '.$data->details.'<br>';
       if($data->icon == 'fab fa-whatsapp'){
        $wa_no = $data->details;
       }
    }
    if($wa_no!==''){
?>
    
    <a href="https://api.whatsapp.com/send?phone=<?php echo $wa_no; ?>" target="_blank">
        <img src="<?php echo env('ASSET_URL'); ?>/assets/frontend/img/bc/logos_whatsapp-icon.png">
    </a>
<?php
    }
?>
</div>

<?php
$currentlang ='';
if(session()->get('lang')){
    $currentlang=session()->get('lang');
}
?>

<!-- jquery -->
<script src="{{asset('assets/frontend/js/jquery-3.4.1.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/jquery-migrate-3.1.0.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/jquery.magnific-popup.js')}}"></script>
<script src="{{asset('assets/frontend/js/imagesloaded.pkgd.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/isotope.pkgd.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/jquery.waypoints.js')}}"></script>
<script src="{{asset('assets/frontend/js/jquery.counterup.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/owl.carousel.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/wow.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/main.js')}}"></script>
<script src="{{asset('assets/frontend/js/customize.js')}}"></script>
<script>
    (function($){
        "use strict";
        $(window).on("load", function() {
            
            console.log('<?php echo $currentlang; ?>')
            var currentlang ='<?php echo $currentlang; ?>'
            if(currentlang=='id_ID'){
                //$('#switchLang').addClass('active')

                var element = document.getElementById("switchLang");
                element.classList.add("active");

                console.log('addclasee active')
                
            } else {
                //$('#switchLang').removeClass('active')

                var element = document.getElementById("switchLang");
                // element.classList.remove("active");
                console.log('removeclass active')
            }
        });

        $(document).ready(function(){

            
            $(document).on('click','#switchLang',function(e){
                $(this).prop('disabled', true);
                $(this).prop( "style", "opacity:0.3 !important;" );
                console.log('click swicth');
                var getlang = 'en'
                if($(this).hasClass('active')){
                    getlang ='id_ID'
                } 

                console.log('getlang',getlang)
                $.ajax({
                    url : "{{route('frontend.langchange')}}",
                    type: "GET",
                    data:{
                        'lang' : getlang
                    },
                    success:function (data) {
                        location.reload();
                    }
                })
            });
        });
        

        $(document).ready(function(){
            $(document).on('change','#langchange',function(e){
                $.ajax({
                    url : "{{route('frontend.langchange')}}",
                    type: "GET",
                    data:{
                        'lang' : $(this).val()
                    },
                    success:function (data) {
                        location.reload();
                    }
                })
            });
        });

    $(document).on('click', '.newsletter-form-wrap .submit-btn', function (e) {
       e.preventDefault();
       var email = $('.newsletter-form-wrap input[type="email"]').val();
       var errrContaner = $(this).parent().parent().parent().find('.form-message-show');
       errrContaner.html('');

       $.ajax({
           url: "{{route('frontend.subscribe.newsletter')}}",
           type: "POST",
           data: {
               _token: "{{csrf_token()}}",
               email: email
           },
           success: function (data) {
               errrContaner.html('<div class="alert alert-'+data.type+'">' + data.msg + '</div>');
           },
           error: function (data) {
               var errors = data.responseJSON.errors;
               errrContaner.html('<div class="alert alert-danger">' + errors.email[0] + '</div>');
           }
       });
   });
}(jQuery));
</script>
@yield('scripts')

<!--Start of Tawk.to Script-->
{{-- <script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src="https://embed.tawk.to/{{get_static_option('tawk_api_key')}}/default";
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
    })();
</script> --}}
<!--End of Tawk.to Script-->

</body>

</html>
