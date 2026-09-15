<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

  @foreach ($all_page as $data)
    <url>
      <loc>{{ url('' . $data . '') }}</loc>
    </url>
  @endforeach

  @foreach ($all_blog as $data)
    <url>
      <loc>{{ url('/blog/' . $data->id . '/' . $data->slug) }}</loc>
      <lastmod>{{ $data->created_at->toAtomString() }}</lastmod>
      <link rel="alternate" hreflang="{{$data->lang}}" href="{{ url('/blog/' . $data->id . '/' . $data->slug) }}" ></link>
    </url>
  @endforeach

  @foreach ($all_category as $data)
    <url>
      <loc>{{ url('/blog/category/' . $data->id . '/' . $data->name) }}</loc>
      <lastmod>{{ $data->created_at->toAtomString() }}</lastmod>
      <link rel="alternate" hreflang="{{$data->lang}}" href="{{ url('/blog/category/' . $data->id . '/' . $data->name) }}" ></link>
    </url>
  @endforeach
</urlset>

