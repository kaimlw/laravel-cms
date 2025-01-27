@extends('main.theme-1.layout.template')

@section('title', $category->title)

@section('css-addon')
<link rel="stylesheet" href="{{ asset('assets/main/theme-1/css/page.css') }}">
@endsection

@section('content')
<section id="banner" class="bg-purple">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h1 class="text-center text-white fw-normal">Category :</h1>
        <h1 class="text-white text-center display-1">{{ $category->name }}</h1>
      </div>
    </div>
  </div>
</section>
<section id="content">
  <div class="container">
    <div class="row">
      <div class="col-lg-9">
        <div class="row mb-2">
          <div class="col-12">
            <ul class="list-unstyled">
              @if(count($posts)>0)
                @foreach ($posts as $post)
                  @if($post->status != 'publish')
                    @continue
                  @endif
                  
                  <li class="mb-3">
                    <div class="card">
                      <div class="card-body">
                        <div class="text-secondary mb-2" style="font-size: 14px;"><i class="bi bi-calendar me-2"></i> {{ date("d-m-Y", strtotime($post->updated_at)) }}</div>
                        <a class="h5 text-decoration-none fw-semibold" href="{{ route('main.post', ['slug' => $post->slug]) }}">{{ $post->title }}</a>
                        <div class="text-secondary mt-2">
                          {!! $post->excerpt !!}
                        </div>
                      </div>
                    </div>
                  </li>
                @endforeach
              @else
                <li>Tidak ada postingan dengan kategori berikut.</li>
              @endif
            </ul>
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

