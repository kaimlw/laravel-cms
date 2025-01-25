@extends('main.theme-1.layout.template')

@section('title', $page->title)

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

