@extends('frontend.frontend-page-master')
@section('site-title')
    {{get_static_option('blog_page_'.get_user_lang().'_title')}}
@endsection
@section('page-title')
    {{get_static_option('blog_page_'.get_user_lang().'_title')}}
@endsection

@section('meta-name')
<?php
if(get_user_lang()=='en'){
?>
<meta name="title" content="Blog | Blue Coolant Indonesia - Best Radiator Coolant Solution">
<meta name="description" content="PT. Blue Coolant Indonesia provides solutions to your needs with several product variants including Radiator coolant, Degreaser and other complementary products.">
<?php
} else {
?>
<meta name="title" content="Blog | Blue Coolant Indonesia - Solusi Radiator Coolant Terbaik">
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

@section('content')

        <section class="blog-breadcrumb-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="breadcrumb-inner">
                            <!-- <h1 class="title">{{get_static_option('blog_page_'.$user_select_lang_slug.'_name')}}</h1> -->
                            <h1 class="title">{{ get_user_lang()=='en'?'News.':'Berita.' }}</h1>

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

    <section class="blog-search-section mb-5">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <form name="form" action="{{ env('APP_URL') }}/blog/search" method="get">
                        <div class="searchbar">
                            <div class="row">
                                <div class="col-2">
                                    <i class="search_firsticon fas fa-search p-2 mt-1 ml-2"></i>
                                </div>
                                <div class="col-7 pl-0 pr-0">
                                    <input class="search_input" type="text" name="search" id="search" placeholder="{{ get_user_lang()=='en'?'Search news':'Cari berita' }}" value="<?php if(isset($_GET['search'])){echo $_GET['search'];} ?>" required>
                                </div>
                                <div class="col-3">
                                    <input type="submit" class="search_icon bg1" style="border:0px" value="{{ get_user_lang()=='en'?'Search':'Cari' }}" />
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-sm-12 col-md-6"></div>
                <div class="col-12">
                    <div class="mt-2 pt-4 pb-4">
                       <font class="mr-2">{{ get_user_lang()=='en'?'Categories':'Kategori' }} :</font> 

                       <?php
                            foreach ($all_categories as $res) {
                                echo '<a href="'.env('APP_URL').'/blog/category/'.$res->id.'/'.$res->name.'"><span class="badge-bc">'.$res->name.'</span></a>';
                            }
                        ?>
                       
                        <!-- <a href=""><span class="badge-bc">Coolan</span></a>
                        <a href=""><span class="badge-bc">Ducamos</span></a>
                        <a href=""><span class="badge-bc">Radiator</span></a>                   -->
                    </div>
                </div>
            </div>

            <div class="row pt-5">
                <!-- <div class="col-sm-8">
                1
                </div>
                <div class="col-sm-4">
                    <div class="row">
                        <div class="col-12">
                            <div class="divblog">
                            </div>
                        </div>
                        <div class="col-12">
                            3
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                4
                </div> -->

                <?php 

                    // function getCatName($id){
                    //     $res = '';

                    //     return $res;
                    // }
                    // echo getCatName(1);
                    // echo "<hr>";
                ?>

                @foreach($all_blogs as $data)

                    @if($loop->index ==0)         
                        <div class="col-sm-8 pb-4 effect-5">
                            <div class="divblog1 p-4">
                                <div class="divcatblog">
                                    <?php
                                        foreach ($all_categories as $res) {
                                            if($res->id == $data->blog_categories_id){
                                                echo $res->name; 
                                            }
                                        }
                                    ?>
                                </div>                                
                                <div class="effect-img mb-3 thumb">
                                    <img src="{!! render_image_src_by_attachment_id($data->image) !!}" alt="{!! render_image_alt_by_attachment_id($data->image) !!}" class="img-responsive w-100">   
                                </div>                                    
                                <a href="{{route('frontend.blog.single',['id' => $data->id,'any' => Str::slug($data->title)])}}"><h4>{{$data->title}}</h4></a>
                                <div class="post-description">
                                    <p>{{$data->excerpt}}</p>
                                </div>
                                <a href="{{route('frontend.blog.single',['id' => $data->id,'any' => Str::slug($data->title)])}}" class="readmore">{{ get_user_lang()=='en'?'Read more':'Baca selengkapnya' }} <i class="flaticon-right-arrow"></i></a>                                
                            </div>
                        </div>      
                    @elseif($loop->index ==1 || $loop->index ==2 ) 
                        <div class="col-sm-4 pb-4">
                            <div class="row">
                                @if($loop->index ==1)  
                                <div class="col-12 effect-5">
                                    <div class="divblog p-3">
                                        
                                        <div class="divcatblog">
                                            <?php
                                                foreach ($all_categories as $res) {
                                                    if($res->id == $data->blog_categories_id){
                                                        echo $res->name; 
                                                    }
                                                }
                                            ?>
                                        </div> 

                                        <div class="thumb mb-3 effect-img">
                                            {!! render_image_markup_by_attachment_id($data->image) !!}
                                        </div>  
                                  
                                        <a href="{{route('frontend.blog.single',['id' => $data->id,'any' => Str::slug($data->title)])}}"><h4>{{$data->title}}</h4></a>
                                        <div class="post-description">
                                            <p>{{$data->excerpt}}</p>
                                        </div>
                                        <a href="{{route('frontend.blog.single',['id' => $data->id,'any' => Str::slug($data->title)])}}" class="readmore">{{ get_user_lang()=='en'?'Read more':'Baca selengkapnya' }} <i class="flaticon-right-arrow"></i></a>                                
                                    </div>
                                </div>
                                @else
                                <div class="col-12 effect-5">
                                    <div class="divblog p-3">

                                        <div class="divcatblog">
                                            <?php
                                                foreach ($all_categories as $res) {
                                                    if($res->id == $data->blog_categories_id){
                                                        echo $res->name; 
                                                    }
                                                }
                                            ?>
                                        </div> 

                                        <div class="thumb mb-3 effect-img">
                                            {!! render_image_markup_by_attachment_id($data->image) !!}
                                        </div>                                    
                                        <a href="{{route('frontend.blog.single',['id' => $data->id,'any' => Str::slug($data->title)])}}"><h4>{{$data->title}}</h4></a>
                                        <div class="post-description">
                                            <p>{{$data->excerpt}}</p>
                                        </div>
                                        <a href="{{route('frontend.blog.single',['id' => $data->id,'any' => Str::slug($data->title)])}}" class="readmore">{{ get_user_lang()=='en'?'Read more':'Baca selengkapnya' }} <i class="flaticon-right-arrow"></i></a>                                
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                    @elseif($loop->index ==3)    
                        <div class="col-4 effect-5">
                            <div class="divblog p-3">

                                <div class="divcatblog">
                                    <?php
                                        foreach ($all_categories as $res) {
                                            if($res->id == $data->blog_categories_id){
                                                echo $res->name; 
                                            }
                                        }
                                    ?>
                                </div> 

                                <div class="thumb mb-3 effect-img">
                                    {!! render_image_markup_by_attachment_id($data->image) !!}
                                </div>                                    
                                <a href="{{route('frontend.blog.single',['id' => $data->id,'any' => Str::slug($data->title)])}}"><h4>{{$data->title}}</h4></a>
                                <div class="post-description">
                                    <p>{{$data->excerpt}}</p>
                                </div>
                                <a href="{{route('frontend.blog.single',['id' => $data->id,'any' => Str::slug($data->title)])}}" class="readmore">{{ get_user_lang()=='en'?'Read more':'Baca selengkapnya' }} <i class="flaticon-right-arrow"></i></a>                                
                            </div>
                        </div>
                    @else
                        <div class="col-4 effect-5">
                            <div class="divblog p-3">

                                <div class="divcatblog">
                                    <?php
                                        foreach ($all_categories as $res) {
                                            if($res->id == $data->blog_categories_id){
                                                echo $res->name; 
                                            }
                                        }
                                    ?>
                                </div> 

                                <div class="thumb mb-3 effect-img">
                                    {!! render_image_markup_by_attachment_id($data->image) !!}
                                </div>                                    
                                <a href="{{route('frontend.blog.single',['id' => $data->id,'any' => Str::slug($data->title)])}}"><h4>{{$data->title}}</h4></a>
                                <div class="post-description">
                                    <p>{{$data->excerpt}}</p>
                                </div>
                                <a href="{{route('frontend.blog.single',['id' => $data->id,'any' => Str::slug($data->title)])}}" class="readmore">{{ get_user_lang()=='en'?'Read more':'Baca selengkapnya' }} <i class="flaticon-right-arrow"></i></a>                                
                            </div>
                        </div>
                    @endif

                @endforeach

                <div class="col-12 mt-4 mb-4">
                    <nav class="pagination-wrapper" aria-label="Page navigation ">
                       {{$all_blogs->links()}}
                    </nav>
<!-- 
                    <center>
                        <a href="">
                            <div class="blogmorebtn">
                                More Article <i class="fas fa-arrow-right" aria-hidden="true"></i>
                            </div>
                        </a>
                    </center> -->

                </div>


            </div>


        </div>
    </section>


    <section class="blog-content-area padding-120 d-none">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        @foreach($all_blogs as $data)
                            <div class="col-lg-6 col-md-6">
                                <div class="single-latest-news-grid-item margin-bottom-30">
                                    <div class="thumb">
                                       {!! render_image_markup_by_attachment_id($data->image) !!}
                                    </div>
                                    <div class="content">
                                        <ul class="post-meta">
                                            <li>{{__('By')}} <a href="{{route('frontend.blog.single',['id' => $data->id,'any' => Str::slug($data->title)])}}">{{$data->user->name ?? __('Anonymous')}}</a></li>
                                            <li><a href="{{route('frontend.blog.single',['id' => $data->id,'any' => Str::slug($data->title)])}}">{{$data->created_at->diffForHumans()}}</a></li>
                                        </ul>

                                        <a href="{{route('frontend.blog.single',['id' => $data->id,'any' => Str::slug($data->title)])}}"><h4 class="title">{{$data->title}}</h4></a>
                                        <div class="post-description">
                                            <p>{{$data->excerpt}}</p>
                                        </div>
                                        <a href="{{route('frontend.blog.single',['id' => $data->id,'any' => Str::slug($data->title)])}}" class="readmore">{{__('Read more')}} <i class="flaticon-right-arrow"></i></a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="col-lg-12">
                        <nav class="pagination-wrapper" aria-label="Page navigation ">
                           {{$all_blogs->links()}}
                        </nav>
                    </div>
                </div>
                <div class="col-lg-4">
                   @include('frontend.partials.sidebar')
                </div>
            </div>
        </div>
    </section>
@endsection
