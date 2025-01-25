@extends('main.theme-1.layout.template')

@section('title', $post->title)

@section('css-addon')
<link rel="stylesheet" href="{{ asset('assets/main/theme-1/css/page.css') }}">
@endsection

@section('content')
<section id="banner" class="bg-purple">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h1 class="text-white text-center display-1">{{ $post->title }}</h1>
      </div>
    </div>
  </div>
</section>
<section id="content">
  <div class="container">
    <div class="row">
      <div class="col-lg-9">
        <div class="row mb-2">
          <div class="col-12 text-center">
            <h6>
              @foreach ($post->categories as $category)
                {{ $category->name }}
                @if(!$loop->last)
                  ,
                @endif
              @endforeach
            </h6>
            <h6 class="fw-normal">{{ date("d F Y", strtotime($post->updated_at)) }}</h6>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            {!! $post->content !!}
          </div>
        </div>
      </div>
      <div class="col-lg-3">
        <div class="border-bottom">
          <h5>Kategori</h5>
        </div>
        <ul class="category-list">
          @foreach ($categories as $category)
            <li class="category-list-item">
              <a href="{{ route('main.category', ['slug' => 'test']) }}">{{ $category->name }}</a>
            </li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
</section>

@endsection

@section('js-addon')
  
@endsection

