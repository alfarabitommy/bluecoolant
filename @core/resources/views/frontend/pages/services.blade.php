@extends('frontend.frontend-page-master')
@section('page-title')
    {{__('Service Category: ').$category_name}}
@endsection
@section('content')
    <section class="blog-content-area padding-100">
        <div class="container">
            <div class="row">
                @if(empty($service_items))
                    <div class="col-lg-12">
                        <div class="alert alert-danger">{{__('No Post Available In This Category')}}</div>
                    </div>
                @endif
                @foreach($service_items as $data)
                    <div class="col-lg-4 col-md-6">
                        <div class="single-service-item-three">
                            <div class="thumb">
                                {!! render_image_markup_by_attachment_id($data->image) !!}
                                <div class="icon">
                                    <i class="{{$data->icon}}"></i>
                                </div>
                            </div>
                            <div class="content">
                                <h4 class="title"><a href="{{route('frontend.services.single',['id' => $data->id,'any' => Str::slug($data->title)])}}">{{$data->title}}</a></h4>
                                <div class="description">
                                    {!! Str::words($data->description,15) !!}
                                </div>
                                <a href="{{route('frontend.services.single',['id' => $data->id,'any' => Str::slug($data->title)])}}" class="readmore">{{__('Read More')}}</a>
                            </div>
                        </div>
                    </div>
                @endforeach
                <nav class="pagination-wrapper" aria-label="Page navigation">
                    {{$service_items->links()}}
                </nav>
            </div>
        </div>
    </section>
@endsection
