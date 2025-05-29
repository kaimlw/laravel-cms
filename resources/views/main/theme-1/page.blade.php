@extends('main.theme-1.layout.template')

@section('title', $page->title)

@section('meta-add')
  <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
  <meta property="og:locale" content="id_ID">
  <meta property="og:type" content="article">
  <meta property="og:title" content="{{ $page->title }} | {{ $web->name }}">
  <meta property="og:description" name="og:description" content="{{ $page->excerpt }}">
  <meta property="og:image" name="og:image" content="{{ asset($page->banner_post_path != '' ? $page->banner_post_path : ($web->default_post_banner_path != '' ? $web->default_post_banner_path : "assets/img/ULM.png")) }}">
  <meta property="twitter:card" name="twitter:card" content="summary_large_image">
  <meta property="og:site_name" name="og:site_name" content="{{ $web->name }}">
  <meta property="article:modified_time" content="{{ date('Y-m-d', strtotime($page->updated_at)) }}T{{ date('h:m:s', strtotime($page->updated_at)) }}">
@endsection

@section('css-addon')
<link rel="stylesheet" href="{{ asset('assets/main/theme-1/css/page.css') }}">
@endsection

@section('content')
<section id="banner" class="bg-purple">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h1 class="text-white text-center display-1">{{ $page->title }}</h1>
      </div>
    </div>
  </div>
</section>
<section id="content">
  <div class="container">
    <div class="row">
      <div class="col-12">
        {!! $page->content !!}
      </div>
    </div>
  </div>
</section>

@endsection

@section('js-addon')
  
@endsection

