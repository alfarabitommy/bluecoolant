<?php

namespace App\Http\Controllers;

use App\Blog;
use App\BlogCategory;

class SitemapController extends Controller
{
    public function index()
    {
      $all_page = [
        '/',
        '/about',
        '/service',
        '/product',
        '/blog',
        '/contact'
      ];



      $all_blog = Blog::orderBy('id','desc')->get();
      $all_category = BlogCategory::orderBy('id','desc')->get();
    
      return response()->view('frontend.pages.sitemap', [
        'all_page' => $all_page,
        'all_blog' => $all_blog,
        'all_category' => $all_category
      ])->header('Content-Type', 'text/xml');
    }

}



