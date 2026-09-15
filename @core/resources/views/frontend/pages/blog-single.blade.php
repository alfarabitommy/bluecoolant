@extends('frontend.frontend-page-master')
@section('og-meta')
    <meta property="og:url"  content="{{route('frontend.blog.single',['id' => $blog_post->id,'any' => Str::slug($blog_post->title)])}}" />
    <meta property="og:type"  content="article" />
    <meta property="og:title"  content="{{$blog_post->title}}" />
    <meta property="og:image" content="{{$blog_post->image}}" />
      {!! render_og_meta_image_by_attachment_id($blog_post->image) !!}
@endsection
@section('site-title')
    {{$blog_post->title}}
@endsection
@section('page-title')
    {{$blog_post->title}}
@endsection

@section('meta-name')
<?php
if(get_user_lang()=='en'){
?>
<meta name="title" content="{{$blog_post->title}} | Blue Coolant Indonesia - Best Radiator Coolant Solution">
<meta name="description" content="PT. Blue Coolant Indonesia provides solutions to your needs with several product variants including Radiator coolant, Degreaser and other complementary products.">
<?php
} else {
?>
<meta name="title" content="{{$blog_post->title}} | Blue Coolant Indonesia - Solusi Radiator Coolant Terbaik">
<meta name="description" content="PT. Blue Coolant Indonesia memberikan solusi kebutuhan Anda dengan beberapa varian produk di antaranya Radiator coolant, Degreaser dan produk pelengkap lainnya.">
<?php
}
?>
@endsection

@section('schema')

<?php
$timeschema = date("c", strtotime($blog_post->created_at));
?>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Article",
  "mainEntityOfPage": {
    "@type": "WebPage",
    "@id": "{{$blog_post->id}}"
  },
  "headline": "{{$blog_post->title}}",
  "image": "{!! render_image_src_by_attachment_id($blog_post->image,'','large') !!}",  
  "author": {
    "@type": "",
    "name": ""
  },  
  "publisher": {
    "@type": "Organization",
    "name": "",
    "logo": {
      "@type": "ImageObject",
      "url": "https://bluecoolant.com/assets/uploads/media-uploader/blue-coolant-logo-blue1694673523.png"
    }
  },
  "datePublished": "{{$timeschema}}"
}
</script>

@endsection

@section('content')
    <div class="divservices"> 
        <section class="blog-breadcrumb-area ">
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

        <div class="container">

            <div class="row">
                
                <div class="col-12 mb-5">
                    <h3>{{$blog_post->title}}</h3>
                    <div class="row mb-4">

                        <div class="col-auto">
                        <i class="fa fa-user-circle" aria-hidden="true"></i> <b> {{ $blog_post->user->name ?? __('Anonymous')}} </b>
                        </div>
                        <div class="col-auto">
                        {{ $blog_post->created_at->diffForHumans()}}
                        </div>
                    </div>
                    <div class="thumb">
                        <img src="{!! render_image_src_by_attachment_id($blog_post->image,'','large') !!}" alt="{!! render_image_alt_by_attachment_id($blog_post->image) !!}" class="img-responsive w-100">
                    </div>
                </div>

                <div class="col-12 col-sm-8">
                    <div class="content-area">
                        {!! $blog_post->content !!}
                    </div>

                    <div class="content-area-tag mb-5">
                        <h5><b>{{__('Tags:')}}</b></h5>
                                    @php
                                        $all_tags = explode(',',$blog_post->tags);
                                    @endphp
                                    @foreach($all_tags as $tag)
                                        <span class="divtagblog">{{$tag}}</span>
                                    @endforeach
                    </div>

                    
                    <div class="disqus-comment-area">
                        <div id="disqus_thread"></div>
                    </div>

                </div>
                
                <div class="col-12 col-sm-4 divblogsidebar">
                
                    @include('frontend.partials.sidebar')

                </div>

            </div>



        </div>
    </div>

    <section class="blog-details-content-area padding-100 d-none">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="single-post-details-item">
                        <div class="thumb">

                            {!! render_image_markup_by_attachment_id($blog_post->image,'','large') !!}
                        </div>
                        <div class="entry-content">
                            <ul class="post-meta">
                                <li><i class="fa fa-calendar"></i> {{ $blog_post->created_at->diffForHumans()}}</li>
                                <li><i class="fa fa-user"></i> {{ $blog_post->user->name ?? __('Anonymous')}}</li>
                                <li>
                                    <div class="cats">
                                        <i class="fa fa-calendar"></i>
                                        <a href="{{route('frontend.blog.category',['id' => optional($blog_post->category)->id,'any'=> Str::slug(optional($blog_post->category)->name,'-')])}}"> {{$blog_post->category->name}}</a>
                                    </div>
                                </li>
                            </ul>
                           <div class="content-area">
                               {!! $blog_post->content !!}

                           </div>
                        </div>
                        <div class="entry-footer"><!-- entry footer -->
                            <div class="left">
                                <ul class="tags">
                                    <li class="title">{{__('Tags:')}}</li>
                                    @php
                                        $all_tags = explode(',',$blog_post->tags);
                                    @endphp
                                    @foreach($all_tags as $tag)
                                        <li>{{$tag}}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="right">
                                <ul class="social-share">
                                    <li class="title">{{__('Share:')}}</li>
                                    {!! single_post_share(route('frontend.blog.single',['id' => $blog_post->id, 'any' => Str::slug($blog_post->title,'-')]),$blog_post->title,$blog_post->image) !!}
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="disqus-comment-area">
                        <div id="disqus_thread"></div>
                    </div>
                </div>
                <div class="col-lg-4">
                   @include('frontend.partials.sidebar')
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        var disqus_config = function () {
        this.page.url = "{{route('frontend.blog.single',['id' => $blog_post->id, 'any' => Str::slug($blog_post->title,'-')])}}";
        this.page.identifier = "{{$blog_post->id}}";
        };

        (function() { // DON'T EDIT BELOW THIS LINE
            var d = document, s = d.createElement('script');
            s.src = "https://{{get_static_option('site_disqus_key')}}.disqus.com/embed.js";
            s.setAttribute('data-timestamp', +new Date());
            (d.head || d.body).appendChild(s);
        })();
    </script>
    <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
@endsection
