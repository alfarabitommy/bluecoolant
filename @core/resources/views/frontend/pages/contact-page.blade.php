@extends('frontend.frontend-page-master')
@section('site-title')
    {{get_static_option('contact_page_'.$user_select_lang_slug.'_name')}}
@endsection
@section('page-title')
    {{get_static_option('contact_page_'.$user_select_lang_slug.'_name')}}
@endsection

@section('meta-name')
<?php
if(get_user_lang()=='en'){
?>
<meta name="title" content="Contact | Blue Coolant Indonesia - Best Radiator Coolant Solution">
<meta name="description" content="PT. Blue Coolant Indonesia provides solutions to your needs with several product variants including Radiator coolant, Degreaser and other complementary products.">
<?php
} else {
?>
<meta name="title" content="Hubungi Kami | Blue Coolant Indonesia - Solusi Radiator Coolant Terbaik">
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

@section('page-meta-data')
<meta name="description" content="{{get_static_option('contact_page_'.$user_select_lang_slug.'_meta_description')}}">
<meta name="tags" content="{{get_static_option('contact_page_'.$user_select_lang_slug.'_meta_tags')}}">
@endsection
@section('og-meta')
<meta name="og:url" content="{{route('frontend.about')}}"/>
<meta name="og:description" content="{{get_static_option('contact_page_'.$user_select_lang_slug.'_meta_description')}}">
<meta name="og:tags" content="{{get_static_option('contact_page_'.$user_select_lang_slug.'_meta_tags')}}">
@endsection
@section('content')



    <div class="section-contact">

        <section class="contact-breadcrumb-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="breadcrumb-inner">
                            <!-- <h1 class="title">{{get_static_option('contact_page_'.$user_select_lang_slug.'_name')}}</h1> -->
                            <h1 class="title">{{ get_user_lang()=='en'?'Contact.':'Kontak.' }}</h1>
                            <!-- <div class="page-list">
                                <a href="{{url('/')}}"><span>Home</span></a>
                                -
                                <span class="current-item">page-title</span>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </section>

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

        <div class="contact-area pb-5 container">
            <div class="row justify-content-center">
                <div class="col-12 text-center mb-4">
                    <h3>{{ get_user_lang()=='en'?'HEAD OFFICE':'KANTOR PUSAT' }}</h3>
                </div>
                <div class="col-12 col-lg-9 mb-4">
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-4 mb-4">
                            <div class="box-contact p-4">
                                <div class="text-center">
                                    <div class="bc-contact-bg-circle">
                                        <div class="bc-contact-bg-icon-address"></div>                                     
                                    </div>
                                    <h4>{{ get_user_lang()=='en'?'Address':'Alamat' }}</h4>
                                    <p><?php echo $address; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 mb-4">
                            <div class="box-contact p-4">
                                <div class="text-center">
                                    <div class="bc-contact-bg-circle">
                                        <div class="bc-contact-bg-icon-phone"></div>                                     
                                    </div>
                                    <h4>{{ get_user_lang()=='en'?'Phone':'Telepon' }}</h4>
                                    <p><?php echo $phone; ?> <br>&nbsp;</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 mb-4">
                            <div class="box-contact p-4">
                                <div class="text-center">
                                    <div class="bc-contact-bg-circle">
                                        <div class="bc-contact-bg-icon-email"></div>                                     
                                    </div>
                                    <h4>{{ get_user_lang()=='en'?'Email':'Email' }}</h4>
                                    <p><?php echo $email; ?> <br>&nbsp;</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 text-center mb-4 mt-4">
                    <h3>{{ get_user_lang()=='en'?'LOCATION':'LOKASI' }}</h3>
                </div>
                <div class="col-12 mb-4">

                	<!-- map container -->
		            <div id="map_canvas"><noscript><p>JavaScript is required to render the Google Map.</p></noscript></div>

                </div>

                <div class="col-12 text-center mb-2  mt-4">
                    <div class="badge-contact mb-3">Leave a message</div>
                    <!-- <h3>Tell us about yourself</h3> -->
                    <h3>{{ get_user_lang()=='en'?'Contact Us':'Hubungi Kami' }}</h3>
                    
                </div>
                <div class="col-12 col-md-6 text-center mb-4">
                    <!-- <div class="subtitle">Fusce placerat pretium mauris, vel sollicitudin elit lacinia vitae. Quisque sit amet nisi erat.</div> -->
                    <div class="subtitle">{{ get_user_lang()=='en'?'Let’s Start a Conversation':'Mari Memulai Percakapan' }}</div>

                    
                </div>
                <div class="col-12 col-md-8 mb-4">
                    <form class="form-contact d-none">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">Email address</label>
                                    <input type="text" class="form-control" id="name"  placeholder="Enter Name">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">Email address</label>
                                    <input type="text" class="form-control" id="name"  placeholder="Enter Name">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">Email address</label>
                                    <input type="text" class="form-control" id="name"  placeholder="Enter Name">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">Email address</label>
                                    <input type="text" class="form-control" id="name"  placeholder="Enter Name">
                                </div>
                            </div>
                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="name">Email address</label>
                                    <input type="text" class="form-control" id="name"  placeholder="Enter Name">
                                </div>
                            </div>
                            <div class="col-12 text-center mt-4">
                                <button type="submit" class="btn submitbtn pl-4 pr-4 pt-2 pb-2 bg1">Submit</button>
                            </div>
                        </div>
                    </form>


                    <form action="{{route('frontend.contact.message')}}" method="post" enctype="multipart/form-data" id="contact_form_submit" class="contact-form form-contact">
                        @csrf


                        
                        <input type="hidden" name="captcha_token" id="gcaptcha_token">
                        <div class="row">
                            
                            <div class="col-12">
                                @if(session()->has('msg'))
                                    <div class="alert alert-{{session('type')}}" role="alert">
                                    {!! session('msg') !!}
                                    </div>

                                @endif

                                @if($errors->any())
                                    <div class="alert alert-danger" role="alert">
                                        <ul>
                                            @foreach($errors->all() as $message)
                                                <li>{{$message}}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>


                                {!! render_form_contact_us_field_for_frontend(get_static_option('contact_page_form_fields')) !!}

                            <div class="col-12 text-center mt-4">
                                <button class="btn submitbtn pl-4 pr-4 pt-2 pb-2 bg1" type="submit">{{__('Send Message')}}</button>
                            </div>




                        </div>
                    </form>

                </div>
            </div>
        </div>


    </div>


    <div class="contact-page-conent-aera d-none">
        <div class="container">
            <div class="row reorder-xs">
                <div class="col-lg-6">
                    <div class="contact-form-inner">
                        <h2 class="title">{{get_static_option('contact_page_'.get_user_lang().'_form_section_title')}}</h2>
                        @include('backend.partials.message')
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $message)
                                        <li>{{$message}}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{route('frontend.contact.message')}}" method="post" enctype="multipart/form-data" id="contact_form_submit" class="contact-form">
                             @csrf
                             <input type="hidden" name="captcha_token" id="gcaptcha_token">
                             <div class="row">
                                 <div class="col-lg-12">
                                     {!! render_form_field_for_frontend(get_static_option('contact_page_form_fields')) !!}
                                 </div>
                                 <div class="col-lg-12">
                                     <button class="submit-btn" type="submit">{{__('Send Message')}}</button>
                                 </div>
                             </div>

                         </form>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="contac-info-wrapper">
                        <h2 class="title">{{get_static_option('contact_page_'.get_user_lang().'_contact_info_title')}}</h2>
                        <ul class="contact-info-list">
                            @foreach($all_contact_info as $data)
                            <li>
                                <div class="single-contact-info">
                                    <div class="icon">
                                        <i class="{{$data->icon}}"></i>
                                    </div>
                                    <div class="content">
                                        <h4 class="title">{{$data->title}}</h4>
                                        @php $desc = explode(';',$data->description) @endphp
                                        @foreach($desc as $item)
                                        <span class="details">{{$item}}</span>
                                        @endforeach
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>

                      <div id="map" class="contact_page_map -top-40">
                        {!! render_embed_google_map(get_static_option('contact_page_map_section_address'),20) !!}
                      </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('scripts')
  <!-- @ if(!empty(get_static_option('site_google_captcha_v3_site_key'))) -->
 <!-- <script src="https://www.google.com/recaptcha/api.js?render={{get_static_option('site_google_captcha_v3_site_key')}}"></script>
<script>
    grecaptcha.ready(function() {
        grecaptcha.execute("{{get_static_option('site_google_captcha_v3_site_key')}}", {action: 'homepage'}).then(function(token) {
            document.getElementById('gcaptcha_token').value = token;
        });
    });
</script> -->




        <style type="text/css">
		#map_canvas{ height:500px; width:100%; }

        #map_canvas .boxmaps p{color:#7d7d7d;}

/* .gm-style .gm-style-iw{font-weight:300;font-size:13px;overflow:hidden}.gm-style .gm-style-iw-a{position:absolute;width:9999px;height:0}.gm-style .gm-style-iw-t{position:absolute;width:100%}.gm-style .gm-style-iw-tc{-webkit-filter:drop-shadow(0 4px 2px rgba(178,178,178,.4));filter:drop-shadow(0 4px 2px rgba(178,178,178,.4));height:12px;left:0;position:absolute;top:0;-webkit-transform:translateX(-50%);-ms-transform:translateX(-50%);-o-transform:translateX(-50%);transform:translateX(-50%);width:25px}.gm-style .gm-style-iw-tc::after{background:#fff;-webkit-clip-path:polygon(0 0,50% 100%,100% 0);clip-path:polygon(0 0,50% 100%,100% 0);content:"";height:12px;left:0;position:absolute;top:-1px;width:25px}.gm-style .gm-style-iw-c{position:absolute;-webkit-box-sizing:border-box;box-sizing:border-box;overflow:hidden;top:0;left:0;-webkit-transform:translate3d(-50%,-100%,0);transform:translate3d(-50%,-100%,0);background-color:white;border-radius:8px;padding:12px;-webkit-box-shadow:0 2px 7px 1px rgba(0,0,0,.3);box-shadow:0 2px 7px 1px rgba(0,0,0,.3)}.gm-style .gm-style-iw-d{-webkit-box-sizing:border-box;box-sizing:border-box;overflow:auto}.gm-style .gm-style-iw-d::-webkit-scrollbar{width:18px;height:12px;-webkit-appearance:none}.gm-style .gm-style-iw-d::-webkit-scrollbar-track,.gm-style .gm-style-iw-d::-webkit-scrollbar-track-piece{background:#FFFFFF}.gm-style .gm-style-iw-c .gm-style-iw-d::-webkit-scrollbar-thumb{background-color:rgba(0,0,0,.12);border:6px solid transparent;border-radius:9px;background-clip:content-box}.gm-style .gm-style-iw-c .gm-style-iw-d::-webkit-scrollbar-thumb:horizontal{border:3px solid transparent}.gm-style .gm-style-iw-c .gm-style-iw-d::-webkit-scrollbar-thumb:hover{background-color:rgba(0,0,0,.3)}.gm-style .gm-style-iw-c .gm-style-iw-d::-webkit-scrollbar-corner{background:transparent}.gm-style .gm-iw{color:#2C2C2C}.gm-style .gm-iw b{font-weight:400}.gm-style .gm-iw a:link,.gm-style .gm-iw a:visited{color:#4272DB;text-decoration:none}.gm-style .gm-iw a:hover{color:#4272DB;text-decoration:underline}.gm-style .gm-iw .gm-title{font-weight:400;margin-bottom:1px}.gm-style .gm-iw .gm-basicinfo{line-height:18px;padding-bottom:12px}.gm-style .gm-iw .gm-website{padding-top:6px}.gm-style .gm-iw .gm-photos{padding-bottom:8px;-ms-user-select:none;-moz-user-select:none;-webkit-user-select:none}.gm-style .gm-iw .gm-sv,.gm-style .gm-iw .gm-ph{cursor:pointer;height:50px;width:100px;position:relative;overflow:hidden}.gm-style .gm-iw .gm-sv{padding-right:4px}.gm-style .gm-iw .gm-wsv{cursor:pointer;position:relative;overflow:hidden}.gm-style .gm-iw .gm-sv-label,.gm-style .gm-iw .gm-ph-label{cursor:pointer;position:absolute;bottom:6px;color:#ffffff;font-weight:400;text-shadow:rgba(0,0,0,.7) 0 1px 4px;font-size:12px}.gm-style .gm-iw .gm-stars-b,.gm-style .gm-iw .gm-stars-f{height:13px;font-size:0}.gm-style .gm-iw .gm-stars-b{position:relative;background-position:0 0;width:65px;top:3px;margin:0 5px}.gm-style .gm-iw .gm-rev{line-height:20px;-ms-user-select:none;-moz-user-select:none;-webkit-user-select:none}.gm-style .gm-iw .gm-numeric-rev{font-size:16px;color:#dd4b39;font-weight:400}.gm-style .gm-iw.gm-transit{margin-left:15px}.gm-style .gm-iw.gm-transit td{vertical-align:top}.gm-style .gm-iw.gm-transit .gm-time{white-space:nowrap;color:#676767;font-weight:bold}.gm-style .gm-iw.gm-transit img{width:15px;height:15px;margin:1px 5px 0 -20px;float:left}sentinel{} */


		</style>
		
		<script type="text/javascript">


		// load map after page has finished loading
		function loadScript() {
			var script = document.createElement( "script" );
			script.type = "text/javascript";
			script.src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyDciCtm-R-ds0kggd35u7BSB7VJKNiqYCg&callback=initialise"; // initialize method called using callback parameter

            //script.src = "https://www.google.com/maps/embed/v1/MAP_MODE?key=AIzaSyBzqRZW623bun9C22yYVVOMZDGmOIURJDQ&parameters&callback=initialise";

			document.body.appendChild( script );
		}
		window.onload = loadScript;		


		function initialise() {


            // set style
            var costum1 = [{"elementType":"geometry","stylers":[{"color":"#f5f5f5"}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"elementType":"labels.text.fill","stylers":[{"color":"#616161"}]},{"elementType":"labels.text.stroke","stylers":[{"color":"#f5f5f5"}]},{"featureType":"administrative","elementType":"geometry","stylers":[{"visibility":"off"}]},{"featureType":"administrative.land_parcel","stylers":[{"visibility":"off"}]},{"featureType":"administrative.land_parcel","elementType":"labels.text.fill","stylers":[{"color":"#bdbdbd"}]},{"featureType":"administrative.neighborhood","stylers":[{"visibility":"off"}]},{"featureType":"poi","stylers":[{"visibility":"off"}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#eeeeee"}]},{"featureType":"poi","elementType":"labels.text","stylers":[{"visibility":"off"}]},{"featureType":"poi","elementType":"labels.text.fill","stylers":[{"color":"#757575"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#e5e5e5"}]},{"featureType":"poi.park","elementType":"labels.text.fill","stylers":[{"color":"#9e9e9e"}]},{"featureType":"road","elementType":"geometry","stylers":[{"color":"#ffffff"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"road.arterial","elementType":"labels.text.fill","stylers":[{"color":"#757575"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#dadada"}]},{"featureType":"road.highway","elementType":"labels.text.fill","stylers":[{"color":"#616161"}]},{"featureType":"road.local","elementType":"labels.text.fill","stylers":[{"color":"#9e9e9e"}]},{"featureType":"transit","stylers":[{"visibility":"off"}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"color":"#e5e5e5"}]},{"featureType":"transit.station","elementType":"geometry","stylers":[{"color":"#eeeeee"}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#c9c9c9"}]},{"featureType":"water","elementType":"labels.text","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"color":"#9e9e9e"}]}]

            // var costum2 = [
            // {"featureType":"water","elementType":"geometry","stylers":[{"color":"#e9e9e9"},{"lightness":17}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":20}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffffff"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#ffffff"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":16}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":21}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#dedede"},{"lightness":21}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#ffffff"},{"lightness":16}]},{"elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#333333"},{"lightness":40}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#f2f2f2"},{"lightness":19}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#fefefe"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#fefefe"},{"lightness":17},{"weight":1.2}]}      
            // ];

            var costum3 = [{"elementType":"geometry","stylers":[{"color":"#c2c2c2"}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"elementType":"labels.text.fill","stylers":[{"color":"#616161"}]},{"elementType":"labels.text.stroke","stylers":[{"color":"#f5f5f5"}]},{"featureType":"administrative","elementType":"geometry","stylers":[{"visibility":"off"}]},{"featureType":"landscape.natural.landcover","elementType":"geometry.fill","stylers":[{"color":"#c2c2c2"}]},{"featureType":"poi","stylers":[{"visibility":"off"}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#eeeeee"}]},{"featureType":"poi","elementType":"labels.text.fill","stylers":[{"color":"#757575"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#e5e5e5"}]},{"featureType":"poi.park","elementType":"labels.text.fill","stylers":[{"color":"#9e9e9e"}]},{"featureType":"road","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"geometry","stylers":[{"color":"#ffffff"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"road.arterial","elementType":"labels.text.fill","stylers":[{"color":"#757575"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#dadada"}]},{"featureType":"road.highway","elementType":"labels.text.fill","stylers":[{"color":"#616161"}]},{"featureType":"road.local","elementType":"labels.text.fill","stylers":[{"color":"#9e9e9e"}]},{"featureType":"transit","stylers":[{"visibility":"off"}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"color":"#e5e5e5"}]},{"featureType":"transit.station","elementType":"geometry","stylers":[{"color":"#eeeeee"}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#c9c9c9"}]},{"featureType":"water","elementType":"geometry.fill","stylers":[{"color":"#f5f5f5"}]},{"featureType":"water","elementType":"labels.text","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"color":"#9e9e9e"}]}]

            var locMapCenter = {lat: -2.548926, lng: 118.0148634}; //indonesia
			// create object literal to store map properties
			var myOptions = {
				zoom: 5, // set zoom level
                center: locMapCenter,
                disableDefaultUI: true, // a way to quickly hide all controls
				mapTypeId: google.maps.MapTypeId.ROADMAP, // apply tile (options include ROADMAP, SATELLITE, HYBRID and TERRAIN)
                styles: costum3


                
			};
			
			// create map object and apply properties
			var map = new google.maps.Map( document.getElementById( "map_canvas" ), myOptions );
			

            map.setCenter(new google.maps.LatLng(-2.346148, 120.179364));

			// create map bounds object
			var bounds = new google.maps.LatLngBounds();



			// create array containing locations
            // var locations = [
            //     ["Jakarta", -6.1764477, 106.8103553],
            //     ["Tangerang", -6.218416, 106.568058],
            //     ["Marunda", -6.09227, 106.98282],
            //     ["Cilegon", -6.003855, 106.087585],
            //     ["Banjarmasin", -3.447334, 114.692098],
            //     ["Balikpapan", -1.247927, 116.935120],
            //     ["Samarinda", -0.483797, 117.164005],
            //     ["Berau", 2.166278, 117.460091],
            //     ["Tarakan", 3.292939, 117.594653], 
            //     ["Surabaya", -7.249875, 112.693848],
            //     ["Surabaya", -7.2441032, 112.6826427],
            //     ["Palembang", -2.372717, 104.8058126],
            //     ["Sorong", -0.887838, 131.3011134],
            //     ["Kendari",-3.96631, 122.48195],
            //     ["Medan", 3.603831, 98.715736],
            //     ["Batam", 1.107803, 104.076393],
            //     ["Bitung", 1.442248, 125.149040],
            //     ["Makassar", -5.064139, 119.507179],
            //     ["Jayapura", -2.6154134389665136, 140.68145074809925],
            //     ["Karawang", -6.3725950693277635, 107.15642929732608]
            // ];
            var locations = [
                ["Tarakan",3.2990375,117.6036604],
                ["Berau",2.1683524,117.4817851],
                ["Balikpapan",-1.2483479,116.9350546],
                ["Banjarmasin",-3.4596366,114.7084217],
                ["Surabaya",-7.2498926,112.6939138],
                ["Cikarang",-6.3531129,107.1443211],
                ["Jakarta",-6.1763963,106.8124988],
                ["Cilegon",-5.9730437,106.0970197],
                ["Tangerang",-6.2068723,106.5634987],
            ]

            // Info Window Content
            // var address = [
            //     [
            //         '<div class="office-location__map-content">' +
            //         '<h4>Jakarta</h4>' +
            //         '<hr />'+
            //         '<p>Jl. Cideng Timur No. 70 Jakarta Pusat 10150</p>' +
            //         '<p><b>Phone :</b> 021-3858756<br><b>Fax :</b> 021-3847801<br><b>Email :</b> <a href="mailto:info@sefasgroup.com">info@sefasgroup.com</a></p>'+
            //         '</div>'
            //     ],
            //     [
            //         '<div class="office-location__map-content">' +
            //         '<h4>Tangerang</h4>' +
            //         '<hr />'+
            //         '<p>Kawasan Sentral Gudang Bitung Blok B-10 Industri Kadu, Jl. Tembusan Indistri Kadu Baitussa Adah RT.03/RW.01, Kel. Kadu, Kec. Curug, Tangerang, 15010</p>' +
            //         '<p><b>Phone :</b> 021-55666277<br><b>Fax :</b> 021-55666277<br><b>Email :</b> <a href="mailto:adm.tgr@sefasgroup.com">adm.tgr@sefasgroup.com</a></p>'+
            //         '</div>'
            //     ],
            //     [
            //         '<div class="office-location__map-content">' +
            //         '<h4>Marunda</h4>' +
            //         '<hr />'+
            //         '<p>Marunda Center Blok P No. 3 dan 3A, Sagara Makmur Kec. Tarumajaya, Bekasi</p>' +
            //         '<p><b>Email :</b> <a href="mailto:sefas.warehouse@sefasgroup.com">sefas.warehouse@sefasgroup.com</a></p>'+
            //         '</div>'
            //     ],
            //     [
            //         '<div class="office-location__map-content">' +
            //         '<h4>Cilegon</h4>' +
            //         '<hr />'+
            //         '<p>Jl. Raya Bojonegara Km. 2, No. 7, RT.002/004 Kedaleman, Kec. Cibeber, Kota Cilegon, Banten 42422</p>' +
            //         '<p><b>Phone :</b> 0254-5753219<br><b>Fax :</b> 0254-5753301<br><b>Email :</b> <a href="mailto:tribinapanutan@sefasgroup.com">tribinapanutan@sefasgroup.com</a></p>'+
            //         '</div>'
            //     ],
            //     [
            //         '<div class="office-location__map-content">' +
            //         '<h4>Banjarmasin</h4>' +
            //         '<hr />'+
            //         '<p>Jl. Banjar Gawi Barat No. 3B, LIK Liang Anggang, Landasan Ulin Selatan, Kota Banjarbaru, Kalimantan Selatan, 70722</p>' +
            //         '<p><b>Phone :</b> 0511-7560305<br><b>Fax :</b> 0511-7560305<br><b>Email :</b> <a href="mailto:sefas.bjm@sefasgroup.com">sefas.bjm@sefasgroup.com</a></p>'+
            //         '</div>'
            //     ],
            //     [
            //         '<div class="office-location__map-content">' +
            //         '<h4>Balikpapan</h4>' +
            //         '<hr />'+
            //         '<p>Jl. Mulawarman No. 12 RT. 03, Batakan, Balikpapan, Kalimantan Timur 76116</p>' +
            //         '<p><b>Phone :</b> 0542-770075/6<br><b>Fax :</b> 0542-770156<br><b>Email :</b> <a href="mailto:bppn@sefasgroup.com">bppn@sefasgroup.com</a></p>'+
            //         '</div>'
            //     ],
            //     [
            //         '<div class="office-location__map-content">' +
            //         '<h4>Samarinda</h4>' +
            //         '<hr />'+
            //         '<p>Ruko Pesona Mahakam No. 7, Jl. Pelita, Samarinda Seberang, Kalimantan Timur 75131</p>' +
            //         '<p><b>Phone :</b> 0541-7268179<br><b>Fax :</b> 0541-7268039<br><b>Email :</b> <a href="mailto:smd@sefasgroup.com">smd@sefasgroup.com</a></p>'+
            //         '</div>'
            //     ],
            //     [
            //         '<div class="office-location__map-content">' +
            //         '<h4>Berau</h4>' +
            //         '<hr />'+
            //         '<p>Jl. HARM Ayoeb RT. 08 Kel. Gunung Tabur, Kec. Gunung Tabur, Kab. Berau, Kalimantan Timur</p>' +
            //         '</div>'
            //     ],
            //     [
            //         '<div class="office-location__map-content">' +
            //         '<h4>Tarakan</h4>' +
            //         '<hr />'+
            //         '<p>Jl. Kusuma Bangsa RT. 03 No. 1A, Kel. Gunung Lingkas, Kec. Tarakan Timur, Tarakan, Kalimantan Utara</p>' +
            //         '</div>'
            //     ],
            //     [
            //         '<div class="office-location__map-content">' +
            //         '<h4>Surabaya</h4>' +
            //         '<hr />'+
            //         '<p>Komplek Pergudangan Margomulyo Permai Blok P2 Surabaya 60186, Jawa Timur</p>' +
            //         '<p><b>Phone :</b> (+62 317) 494883</p>'+
            //         '</div>'
            //     ],
            //     [
            //         '<div class="office-location__map-content">' +
            //         '<h4>Surabaya</h4>' +
            //         '<hr />'+
            //         '<p>Komp. Pergudangan Margomulyo Permai, Surabaya, Jawa Timur</p>' +
            //         '</div>'
            //     ],
            //     [
            //         '<div class="office-location__map-content">' +
            //         '<h4>Palembang</h4>' +
            //         '<hr />'+
            //         '<p>Komp. Pergudangan Prima Star, Jl. tanjung siapi-api km. 8, Kec talang kelapa, Desa Gasing, Sumatera Selatan</p>' +
            //         '</div>'
            //     ],
            //     [
            //         '<div class="office-location__map-content">' +
            //         '<h4>Sorong</h4>' +
            //         '<hr />'+
            //         '<p>Jln. Basuki Rahmat KM. 8.9, Malaingkedi - Sorong Utara, Sorong, Papua Barat</p>' +
            //         '</div>'
            //     ],
            //     [
            //         '<div class="office-location__map-content">' +
            //         '<h4>Kendari</h4>' +
            //         '<hr />'+
            //         '<p>Kompleks Ruko & Pergudangan P.Bizpark Blok G-9 & G-10, Jalan Patimura RT 03/Rw 01, Kelurahan Puuwatu, Kecamatan Puuwatu, Kendari, Sulawesi Tenggara</p>' +
            //         '</div>'
            //     ],
            //         [
            //             '<div class="office-location__map-content">' +
            //             '<h4>Medan</h4>' +
            //             '<hr />'+
            //             '<p>Jl. Pulau Brayan, Kompleks Braya Center, Medan, Sumatera Utara</p>' +
            //             '</div>'
            //         ],
            //         [
            //             '<div class="office-location__map-content">' +
            //             '<h4>Batam</h4>' +
            //             '<hr />'+
            //             '<p>Jl. Laksamana Bintan, Sei Panas, Batam, Kepulauan Riau</p>' +
            //             '</div>'
            //         ],
            //         [
            //             '<div class="office-location__map-content">' +
            //             '<h4>Bitung</h4>' +
            //             '<hr />'+
            //             '<p>Jln. Wolter Monginsidi Km.4, Wangurer Timur, Bitung, Sulawesi Utara</p>' +
            //             '</div>'
            //         ],
            //         [
            //             '<div class="office-location__map-content">' +
            //             '<h4>Makassar</h4>' +
            //             '<hr />'+
            //             '<p>Jln. Daeng Matoa, Perintis Kemerdekaan Km. 16, Makassar, Sulawesi Selatan</p>' +
            //             '</div>'
            //         ],
            //         [
            //             '<div class="office-location__map-content">' +
            //             '<h4>Jayapura</h4>' +
            //             '<hr />'+
            //             '<p>Asano, Abepura, Kota Jayapura, Papua</p>' +
            //             '</div>'
            //         ],
            //         [
            //         '<div class="office-location__map-content">' +
            //         '<h4>Karawang</h4>' +
            //         '<hr />'+
            //         '<p>Kawasan Industri Delta Silicon III, Jl. Rotan II Blok F27-37EB, Lippo Cikarang</p>' +
            //         '<p><b>Phone :</b> 02139506825<br></p>'+
            //         '</div>'
            //         ],
            // ];

            var address = [
                [
                    '<div class="office-location__map-content">' +
                    '<h4>Tarakan</h4>' +
                    '<hr />'+
                    '<p>Jl. Kusuma Bangsa RT 11 No. 1A Kel. Gn. Llingkas Kec. Tarakan Timur, Tarakan - Kalimantan Utara, 77115</p>'+
                    '</div>'
                ],
                [
                    '<div class="office-location__map-content">' +
                    '<h4>Berau</h4>' +
                    '<hr />'+
                    '<p>Jl. HARM Ayoeb RT 08 Kel. Gn. Tabur, Kec. Gn. Tabur, Kabupaten Berau Kalimantan Timur, 77352</p>'+
                    '</div>'
                ],
                [
                    '<div class="office-location__map-content">' +
                    '<h4>Balikpapan</h4>' +
                    '<hr />'+
                    '<p>Jl. Mulawarman No. 12 RT 03, Batakan, Balikpapan 76116 Kalimantan Timur</p>'+
                    '</div>'
                ],
                [
                    '<div class="office-location__map-content">' +
                    '<h4>Banjarmasin</h4>' +
                    '<hr />'+
                    '<p>Jl. Banjargawi Barat No. 3B LIK Liang Anggang Landasan Ulin Selatan , Kota Banjar Baru - Kalimantan Selatan 70722</p>'+
                    '</div>'
                ],
                [
                    '<div class="office-location__map-content">' +
                    '<h4>Surabaya</h4>' +
                    '<hr />'+
                    '<p>Komplek Pergudangan Margomulyo Permai Blok P2, Surabaya - Jawa Timur</p>'+
                    '</div>'
                ],
                [
                    '<div class="office-location__map-content">' +
                    '<h4>Cikarang</h4>' +
                    '<hr />'+
                    '<p>Delta Silicon II, Jl. Gaharu Blok F2/8 Cikarang – Bekasi</p>'+
                    '</div>'
                ],
                [
                    '<div class="office-location__map-content">' +
                    '<h4>Jakarta</h4>' +
                    '<hr />'+
                    '<p>Jl. Cideng Barat No. 87, Jakarta Pusat 10150, DKI Jakarta, Indonesia</p>'+
                    '</div>'
                ],
                [
                    '<div class="office-location__map-content">' +
                    '<h4>Cilegon</h4>' +
                    '<hr />'+
                    '<p>Jl. Raya Bojonegara Km. 2 No. 7 RT. 002/004 Kelurahan Kedaleman, Kecamatan Cibeber, Kota Cilegon – Banten</p>'+
                    '</div>'
                ],
                [
                    '<div class="office-location__map-content">' +
                    '<h4>Tangerang</h4>' +
                    '<hr />'+
                    '<p>Kawasan Sentral Gudang Bitung, Blok B-10 Industri Kadu, Jl. Tembusan Industri Kadu Baitusaadah RT. 03 RW. 01 Kelurahan Kadu Kecamatan Curug - Tangerang</p>'+
                    '</div>'
                ],

            ]

			// loop through locations and add to map
			for ( var i = 0; i < locations.length; i++ )
			{
				// get current location
				var location = locations[ i ];
				
				// create map position
				var position = new google.maps.LatLng( location[ 1 ], location[ 2 ] );
				
				// add position to bounds
				bounds.extend( position );
				
                const iconMaps = {
                    url: "httpS://www.bluecoolant.com/assets/frontend/img/bc/Vector_gmaps.png", // url
                    scaledSize: new google.maps.Size(13.5, 16), // scaled size
                    // origin: new google.maps.Point(0,0), // origin
                    // anchor: new google.maps.Point(0, 0) // anchor
                };

				// create marker (https://developers.google.com/maps/documentation/javascript/reference#MarkerOptions)
				var marker = new google.maps.Marker({
					animation: google.maps.Animation.DROP
					// , icon: "http://www.google.com/intl/en_us/mapfiles/ms/micons/blue-dot.png"
                    , icon: iconMaps
					, map: map
					, position: position
					, title: location[ 0 ]
				});

                var infoWindow = new google.maps.InfoWindow(), marker, i;
				
				// create info window and add to marker (https://developers.google.com/maps/documentation/javascript/reference#InfoWindowOptions)
				google.maps.event.addListener( marker, 'click', ( 
					function( marker, i ) {
						return function() {
                            console.log('address[i][0] : ',address[i][0])
                            console.log('marker : ',marker)
							var infowindow = new google.maps.InfoWindow();
							//infowindow.setContent( locations[ i ][ 0 ] );
                            
                            //infoWindow.setContent(address[i][0]);
                            infowindow.setContent('<div class="boxmaps" style="height:auto; max-width:280px; color:black">' + address[i][0] +     '</div>');

							infowindow.open( map, marker );

						}
					}
				)( marker, i ) );


                
			};

			// fit map to bounds
			map.fitBounds( bounds );
 
            

		}


		</script>
<!-- @ endif -->
@endsection
