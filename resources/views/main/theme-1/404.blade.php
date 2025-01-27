@extends('main.theme-1.layout.template')

@section('title', "Halaman tidak ditemukan!")

@section('css-addon')
<link rel="stylesheet" href="{{ asset('assets/main/theme-1/css/page.css') }}">
@endsection

@section('content')
<section id="banner" class="bg-purple">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h1 class="text-center text-white fw-normal">Hmmm...</h1>
        <h1 class="text-white text-center display-1">Halaman yang anda tuju tidak ditemukan.</h1>
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
            <img src="{{ asset('assets/img/404.png') }}" class="img-fluid" alt="" width="50%">
            <h4>Halaman tidak ditemukan...</h4>
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
              <a href="{{ route('main.category', ['slug' => $category->slug ]) }}">{{ $category->name }}</a>
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

