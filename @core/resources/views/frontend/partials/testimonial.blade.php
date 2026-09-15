<div class="testimonial-area padding-120">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="section-title margin-bottom-60">
                    <h2 class="title">{{__('What People Say\'s')}}</h2>
                    <span class="separator"></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="testimonial-carousel owl-carousel">
                    @foreach($all_testimonial as $data)
                    <div class="single-testimonial-item">
                        <div class="thumb">
                            @if(file_exists('assets/uploads/testimonial/testimonial-pic-'.$data->id.'.'.$data->image))
                                <img style="max-width: 200px" src="{{asset('assets/uploads/testimonial/testimonial-pic-'.$data->id.'.'.$data->image)}}" alt="{{__($data->name)}}">

                            @else
                                <img style="max-width: 200px" src="{{asset('assets/uploads/no-image.png')}}" alt="no image available">
                            @endif
                        </div>
                        <div class="content">
                            <p>{{$data->description}}</p>
                            <div class="author-meta">
                                <div class="ratings">
                                    @for($i = 0; $i < $data->rating;$i++)
                                        <i class="fas fa-star"></i>
                                    @endfor
                                </div>
                                <h4 class="title">{{$data->name}}</h4>
                                <span class="designation">{{$data->designation}}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
