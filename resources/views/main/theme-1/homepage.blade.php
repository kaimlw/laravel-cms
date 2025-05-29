@extends('main.theme-1.layout.template')

@section('title', 'Home')

@section('meta-add')
  <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
  <meta property="og:locale" content="id_ID">
  <meta property="og:type" content="website">
  <meta property="og:title" content="Home | {{ $web->name }}">
  <meta property="og:description" name="og:description" content="Welcome to {{ $web->name }} We are committed to building an Integrity Zone towards a Corruption-Free Area and a Clean and Serving Bureaucratic Area.">
  <meta property="og:image" name="og:image" content="{{ asset('assets/img/ULM.png') }}">
  <meta property="twitter:card" name="twitter:card" content="summary_large_image">
  <meta property="og:site_name" name="og:site_name" content="{{ $web->name }}">
  <meta property="article:modified_time" content="{{ date('Y-m-d', strtotime($web->updated_at)) }}T{{ date('h:m:s', strtotime($web->updated_at)) }}">
@endsection

@section('css-addon')
<link rel="stylesheet" href="{{ asset('assets/main/theme-1/css/homepage.css') }}?timestamp={{ now() }}">
@endsection

@section('content')
<section id="banner" class="bg-purple">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 banner-description order-last order-md-first">
        <h5 class="text-white">WELCOME TO</h5>
        <h1 class="text-white display-5 fw-bold">{{ $web->name }}</h1>
        <p class="text-white">{{ $web->description }}</p>
        <a href="{{ route('main.page', ['slug' => 'profil']) }}" class="btn btn-round-yellow">Selengkapnya <i class="bi bi-chevron-right ms-2"></i></a>
        <div class="splide__container mt-4">
          <div class="fade-left"></div>
          <div class="splide" id="partner_slide" role="group" aria-label="FKIP Partners Slide">
            <div class="splide__track">
              <ul class="splide__list">
                @foreach ($partnership_slide as $slide)
                <li class="splide__slide">
                  <div class="splide__slide__container">
                    <img src="{{ asset($slide->meta_value) }}" alt="">
                  </div>
                </li>
                @endforeach
              </ul>
            </div>
          </div>
          <div class="fade-right"></div>
        </div>
      </div>
      <div class="col-lg-6 banner-slide py-5 order-first order-md-last">
        <div class="splide__container">
          <div class="splide" id="main_slide" role="group" aria-label="FKIP main slide">
            <div class="splide__track">
              <ul class="splide__list">
                @foreach ($main_slide as $slide)
                <li class="splide__slide">
                  <div class="splide__slide__container">
                    <img src="{{ asset($slide->meta_value) }}" alt="">
                  </div>
                </li>
                @endforeach
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section id="goto" class="p-0">
  <div class="container">
    <div class="row row-gap-3">
      <div class="col-lg-4">
        <div class="card border-0 shadow rounded-4">
          <div class="card-body py-4 px-3">
            <div class="goto-card-header mb-3">
              <div class="goto-card-header-icon"><i class="bi bi-pc-display-horizontal"></i></div>
              <h5 class="goto-card-header-title">Various Scholarship Programs at FKIP ULM</h5>
            </div>
            <p class="goto-card-description mb-2">
              Many scholarship options up to 100% free tuition
            </p>
            <a href="" class="goto-card-link">Scholarship Info <i class="bi bi-chevron-right ms-1"></i></a>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card border-0 shadow rounded-4">
          <div class="card-body py-4 px-3">
            <div class="goto-card-header mb-3">
              <div class="goto-card-header-icon"><i class="bi bi-trophy-fill"></i></div>
              <h5 class="goto-card-header-title">90.9% Program Study are Excellent Accreditated</h5>
            </div>
            <p class="goto-card-description mb-2">
              20 of 21 study programs at FKIP ULM are accreditated as excellent
            </p>
            <a href="" class="goto-card-link">Study Program Accreditation Info <i class="bi bi-chevron-right ms-1"></i></a>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card border-0 shadow rounded-4 h-100 space-between">
          <div class="card-body py-4 px-3">
            <div class="goto-card-header mb-3">
              <div class="goto-card-header-icon"><i class="bi bi-file-earmark-fill"></i></div>
              <h5 class="goto-card-header-title">Ready to Enroll at FKIP ULM</h5>
            </div>
            <p class="goto-card-description mb-2">
              Click the button below to register online
            </p>
            <a href="" class="goto-card-link">Enrollment Info <i class="bi bi-chevron-right ms-1"></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section id="welcome">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h1 class="text-center">
          Welcome to {{ $web->name }}
        </h1>
        <p class="text-center text-secondary">We are committed to building an Integrity Zone towards a Corruption-Free Area and a Clean and Serving Bureaucratic Area.</p>
      </div>
    </div>
    <div class="row">
      @if($kaprodi['kaprodi_name'] != '' && $kaprodi['kaprodi_photo'] != '')
      <div class="col-md-4">
        <div class="kaprodi-photo-wrapper mb-2">
          <img src="{{ asset($kaprodi['kaprodi_photo']) }}" alt="" class="img-fluid">
        </div>
        <h5 class="fw-bold text-center m-0">{{ $kaprodi['kaprodi_name'] }}</h5>
        <p class="text-secondary text-center">
          Coordinator of <br>
          {{ $web->name }}
        </p>
      </div>
      @endif
      @if($kaprodi['kaprodi_speech'] != '')
      <div class="col-md-8 pt-md-3">
        <h3>Welcome Speech</h3>
        <p class="text-secondary">
          {{ $kaprodi['kaprodi_speech'] }}
        </p>
      </div>
      @endif
    </div>
  </div>
</section>
<section id="reasons">
  <div class="container">
    <div class="row mb-4">
      <div class="col-12">
        <h5 class="display-6 fw-semibold">9 Reasons to Choose {{ $web->name }}?</h5>
        <p class="text-secondary">Here are 9 reasons why you choose to study at FKIP ULM</p>
      </div>
    </div>
    <div class="row row-gap-3 justify-content-center">
      <div class="col-lg-3">
        <div class="card shadow border-0">
          <div class="card-body px-3">
            <span class="fw-bold reasons-card-number">01</span>
            <h5 class="reasons-card-title">Academic Reputation</h5>
            <p class="reasons-card-content">
              FKIP ULM has a good reputation in education and research, providing a supportive academic environment for students.
            </p>
          </div>
        </div>
      </div>
      <div class="col-lg-3">
        <div class="card shadow border-0">
          <div class="card-body px-3">
            <span class="fw-bold reasons-card-number">02</span>
            <h5 class="reasons-card-title">Excellent Facilities</h5>
            <p class="reasons-card-content">
              FKIP ULM provides comprehensive and modern facilities to support the learning process, such as a rich library with learning resources, laboratories equipped with advanced equipment, and comfortable classrooms.
            </p>
          </div>
        </div>
      </div>
      <div class="col-lg-3">
        <div class="card shadow border-0">
          <div class="card-body px-3">
            <span class="fw-bold reasons-card-number">03</span>
            <h5 class="reasons-card-title">Top Quality Lecturer</h5>
            <p class="reasons-card-content">
              FKIP ULM has qualified and experienced lecturers in their fields, ready to guide and inspire students in achieving their maximum potential.
            </p>
          </div>
        </div>
      </div>
      <div class="col-lg-3">
        <div class="card shadow border-0">
          <div class="card-body px-3">
            <span class="fw-bold reasons-card-number">04</span>
            <h5 class="reasons-card-title">Partnerships with Schools</h5>
            <p class="reasons-card-content">
              FKIP ULM has close partnerships with various schools in the area, both elementary and secondary levels. Through this collaboration, students have the opportunity to engage in community service activities, teaching internships, and other collaborative projects that enrich their educational experience and provide positive contributions to the local community.
            </p>
          </div>
        </div>
      </div>
      <div class="col-lg-3">
        <div class="card shadow border-0">
          <div class="card-body px-3">
            <span class="fw-bold reasons-card-number">05</span>
            <h5 class="reasons-card-title">Career Development</h5>
            <p class="reasons-card-content">
              FKIP ULM pays serious attention to student career development, by organizing various career development activities, seminars, and workshops that can improve skills and prepare students to enter the world of work.
            </p>
          </div>
        </div>
      </div>
      <div class="col-lg-3">
        <div class="card shadow border-0">
          <div class="card-body px-3">
            <span class="fw-bold reasons-card-number">06</span>
            <h5 class="reasons-card-title">Supportive Campus Environment</h5>
            <p class="reasons-card-content">
              The Lambung Mangkurat University campus is located in a comfortable and safe environment, with supporting facilities such as dormitories, student activity centers, and sports facilities.
            </p>
          </div>
        </div>
      </div>
      <div class="col-lg-3">
        <div class="card shadow border-0">
          <div class="card-body px-3">
            <span class="fw-bold reasons-card-number">07</span>
            <h5 class="reasons-card-title">Research and Publication Possibilities</h5>
            <p class="reasons-card-content">
              For those interested in research, FKIP provides opportunities to engage in diverse research projects, with support from lecturers who are experts in their fields. This also opens up opportunities to publish scientific publications.
            </p>
          </div>
        </div>
      </div>
      <div class="col-lg-3">
        <div class="card shadow border-0">
          <div class="card-body px-3">
            <span class="fw-bold reasons-card-number">08</span>
            <h5 class="reasons-card-title">Extensive Alumni Network</h5>
            <p class="reasons-card-content">
              FKIP Universitas Lambung Mangkurat alumni are spread across various fields and industries, providing opportunities for new students to build extensive networks and gain inspiration and mentorship from successful alumni.
            </p>
          </div>
        </div>
      </div>
      <div class="col-lg-3">
        <div class="card shadow border-0">
          <div class="card-body px-3">
            <span class="fw-bold reasons-card-number">09</span>
            <h5 class="reasons-card-title">Commitment to Educational Innovation</h5>
            <p class="reasons-card-content">
              FKIP Universitas Lambung Mangkurat continues to be committed to developing innovative learning methods that are in accordance with current developments, so that students can gain valuable learning experiences that are relevant to the demands of the ever-changing job market.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@if($video_profil_embed != '')
<section id="video-profile" class="video-fkip">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="video-wrapper">
          <div class="video-player">
            <iframe style="width: 100%" height="480" src="{{ $video_profil_embed }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endif
<section id="services">
  <div class="container">
    <div class="row">
      <div class="col-12 text-center">
        <h5 class="display-6 fw-semibold">Services</h5>
        <p class="text-secondary"><b>Lambung Mangkurat University</b> and <b>Faculty of Teacher Training and Education</b> provide various services to facilitate the entire academic community of FKIP ULM.</p>
      </div>
    </div>
    <div class="row row-gap-3 justify-content-center mt-3">
      <div class="col-lg-3 service-col">
        <div class="card">
          <div class="card-body p-0">
            <a href="https://simari.ulm.ac.id/site/home" class="btn-service">
              <i class="bi bi-house-door-fill display-4 d-block mb-1"></i>
              <h5>SIMARI</h5>
            </a>
          </div>
        </div>
      </div>
      <div class="col-lg-3 service-col">
        <div class="card">
          <div class="card-body p-0">
            <a href="https://silapu.ulm.ac.id/" class="btn-service">
              <i class="bi bi-info-circle-fill display-4 d-block mb-1"></i>
              <h5>SILAPU</h5>
            </a>
          </div>
        </div>
      </div>
      <div class="col-lg-3 service-col">
        <div class="card">
          <div class="card-body p-0">
            <a href="http://sik.ulm.ac.id/" class="btn-service">
              <i class="bi bi-envelope-paper-fill display-4 d-block mb-1"></i>
              <h5>SIK</h5>
            </a>
          </div>
        </div>
      </div>
      <div class="col-lg-3 service-col">
        <div class="card">
          <div class="card-body p-0">
            <a href="https://ppid.ulm.ac.id/id/" class="btn-service">
              <i class="bi bi-envelope-fill display-4 d-block mb-1"></i>
              <h5>PPID</h5>
            </a>
          </div>
        </div>
      </div>
      <div class="col-lg-3 service-col">
        <div class="card">
          <div class="card-body p-0">
            <a href="https://e-office.fkipunlam.ac.id/" class="btn-service">
              <i class="bi bi-file-earmark-fill display-4 d-block mb-1"></i>
              <h5>E-Office</h5>
            </a>
          </div>
        </div>
      </div>
      <div class="col-lg-3 service-col">
        <div class="card">
          <div class="card-body p-0">
            <a href="https://tracerstudy.ulm.ac.id/" class="btn-service">
              <i class="bi bi-bar-chart-fill display-4 d-block mb-1"></i>
              <h5>Tracer Study</h5>
            </a>
          </div>
        </div>
      </div>
      <div class="col-lg-3 service-col">
        <div class="card">
          <div class="card-body p-0">
            <a href="https://mbkm.fkip.ulm.ac.id/" class="btn-service">
              <i class="bi bi-building-fill display-4 d-block mb-1"></i>
              <h5>SIBISA</h5>
            </a>
          </div>
        </div>
      </div>
      <div class="col-lg-3 service-col">
        <div class="card">
          <div class="card-body p-0">
            <a href="https://sinde.kemdikbud.go.id/login" class="btn-service">
              <i class="bi bi-sticky-fill display-4 d-block mb-1"></i>
              <h5>SINDE</h5>
            </a>
          </div>
        </div>
      </div>
      <div class="col-lg-3 service-col">
        <div class="card">
          <div class="card-body p-0">
            <a href="https://apps.fkipunlam.ac.id/login" class="btn-service">
              <i class="bi bi-mortarboard-fill display-4 d-block mb-1"></i>
              <h5>Yudisium</h5>
            </a>
          </div>
        </div>
      </div>
      <div class="col-lg-3 service-col">
        <div class="card">
          <div class="card-body p-0">
            <a href="http://legalisir.fkipunlam.ac.id/" class="btn-service">
              <i class="bi bi-pencil-fill display-4 d-block mb-1"></i>
              <h5>Legalisir Ijazah</h5>
            </a>
          </div>
        </div>
      </div>
      <div class="col-lg-3 service-col">
        <div class="card">
          <div class="card-body p-0">
            <a href="https://simari.ulm.ac.id/site/home" class="btn-service">
              <i class="bi bi-book-fill display-4 d-block mb-1"></i>
              <h5>Publikasi</h5>
            </a>
          </div>
        </div>
      </div>
      <div class="col-lg-3 service-col">
        <div class="card">
          <div class="card-body p-0">
            <a href="https://simari.ulm.ac.id/site/home" class="btn-service">
              <i class="bi bi-house-door-fill display-4 d-block mb-1"></i>
              <h5>Magang</h5>
            </a>
          </div>
        </div>
      </div>
      <div class="col-lg-3 service-col">
        <div class="card">
          <div class="card-body p-0">
            <a href="https://simari.ulm.ac.id/site/home" class="btn-service">
              <i class="bi bi-house-door-fill display-4 d-block mb-1"></i>
              <h5>Beasiswa</h5>
            </a>
          </div>
        </div>
      </div>
      <div class="col-lg-3 service-col">
        <div class="card">
          <div class="card-body p-0">
            <a href="https://simari.ulm.ac.id/site/home" class="btn-service">
              <i class="bi bi-hand-thumbs-up-fill display-4 d-block mb-1"></i>
              <h5>Izin Penelitian</h5>
            </a>
          </div>
        </div>
      </div>
      <div class="col-lg-3 service-col">
        <div class="card">
          <div class="card-body p-0">
            <a href="https://simari.ulm.ac.id/site/home" class="btn-service">
              <i class="bi bi-person-standing display-4 d-block mb-1"></i>
              <h5>Daftar PPG Prajab</h5>
            </a>
          </div>
        </div>
      </div>
      <div class="col-lg-3 service-col">
        <div class="card">
          <div class="card-body p-0">
            <a href="https://simari.ulm.ac.id/site/home" class="btn-service">
              <i class="bi bi-person-raised-hand display-4 d-block mb-1"></i>
              <h5>Dosen</h5>
            </a>
          </div>
        </div>
      </div>
      <div class="col-lg-3 service-col">
        <div class="card">
          <div class="card-body p-0">
            <a href="https://simari.ulm.ac.id/site/home" class="btn-service">
              <i class="bi bi-universal-access display-4 d-block mb-1"></i>
              <h5>Tendik</h5>
            </a>
          </div>
        </div>
      </div>
      <div class="col-lg-3 service-col">
        <div class="card">
          <div class="card-body p-0">
            <a href="https://simari.ulm.ac.id/site/home" class="btn-service">
              <i class="bi bi-card-list display-4 d-block mb-1"></i>
              <h5>SPMI</h5>
            </a>
          </div>
        </div>
      </div>
      <div class="col-lg-3 service-col">
        <div class="card">
          <div class="card-body p-0">
            <a href="https://simari.ulm.ac.id/site/home" class="btn-service">
              <i class="bi bi-envelope-exclamation-fill display-4 d-block mb-1"></i>
              <h5>E-Complaint</h5>
            </a>
          </div>
        </div>
      </div>
      <div class="col-lg-3 service-col">
        <div class="card">
          <div class="card-body p-0">
            <a href="https://simari.ulm.ac.id/site/home" class="btn-service">
              <i class="bi bi-journal display-4 d-block mb-1"></i>
              <h5>IKU</h5>
            </a>
          </div>
        </div>
      </div>
      <div class="col-lg-3 service-col">
        <div class="card">
          <div class="card-body p-0">
            <a href="https://simari.ulm.ac.id/site/home" class="btn-service">
              <i class="bi bi-book-half display-4 d-block mb-1"></i>
              <h5>Panduan Disabilitas</h5>
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-12 text-center">
        <button class="btn btn-service-display" id="btn-service-show">Show all <i class="bi bi-chevron-down"></i></button>
        <button class="btn btn-service-display d-none" id="btn-service-hide">Hide <i class="bi bi-chevron-up"></i></button>
      </div>
    </div>
  </div>
</section>
<section id="agenda">
  <div class="container">
    <div class="row mb-3">
      <div class="col-6">
        <h5 class="display-6 fw-semibold">Agenda</h5>
      </div>
      <div class="col-6">
        <div class="d-flex justify-content-end align-items-center h-100 gap-2">
          <button class="btn-arrow-splide" id="btn-splide-prev">
            <i class="bi bi-chevron-left"></i>
          </button>
          <button class="btn-arrow-splide" id="btn-splide-next">
            <i class="bi bi-chevron-right"></i>
          </button>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="splide__container">
          <div class="splide" id="agenda_slide" role="group" aria-label="FKIP agenda slide">
            <div class="splide__track">
              <ul class="splide__list">
                @if (count($agenda_slide) == 0)
                  <li class="splide__slide p-3 text-secondary">
                    Tidak ada agenda.
                  </li>
                @else
                  @foreach ($agenda_slide as $slide)
                  <li class="splide__slide">
                    <div class="splide__slide__container">
                      <img src="{{ asset($slide->meta_value) }}" alt="">
                    </div>
                  </li>
                  @endforeach
                @endif
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section id="headline">
  <div class="container">
    <div class="row mb-5">
      <div class="col-12">
        <h5 class="display-6 fw-semibold text-center">
          Headlines
        </h5>
      </div>
    </div>
    <div class="row row-gap-3">
      @if(isset($latest_news->post) && count($latest_news->post)>0 )
        @foreach ($latest_news->post as $post)
          @if($post->status == "draft")
            @continue
          @endif
          <div class="col-lg-4">
            <div class="card border-0 h-100">
              @if ($post->banner_post_path != '' || $web->default_post_banner_path != '')
                <a href="{{ route('main.post', ['slug' => $post->slug]) }}">
                  <img src="{{ $post->banner_post_path ? asset($post->banner_post_path) : ($web->default_post_banner_path ? asset($web->default_post_banner_path) : "") }}" class="card-img-top rounded-2" height="230">
                </a>
              @endif
              <div class="card-body p-0 mt-3">
                <div class="text-secondary mb-2" style="font-size: 14px;"><i class="bi bi-calendar me-2"></i> {{ date("d-m-Y", strtotime($post->updated_at)) }}</div>
                <a class="h5 text-decoration-none fw-semibold" href="{{ route('main.post', ['slug' => $post->slug]) }}">{{ $post->title }}</a>
                <div class="text-secondary mt-2">
                  {!! $post->excerpt !!}
                </div>
              </div>
            </div>
          </div>
        @endforeach
      @else
        <div class="card">
          <div class="card-body">
            <p class="m-0 text-secondary">Tidak ada berita terbaru.</p>
          </div>
        </div>
      @endif
    </div>
    @if(isset($latest_news->post))
      @if(count($latest_news->post) > 3)
      <div class="row mt-3">
        <div class="col-12 text-center">
          <a href="" class="btn btn-round-purple">More Article <i class="bi bi-chevron-right"></i></a>
        </div>
      </div>
      @endif
    @endif
  </div>
</section>
<section id="info" class="bg-purple">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h5 class="display-6 fw-semibold text-center text-white">Campus Info</h5>
      </div>
    </div>
    <div class="row mt-5">
      <div class="col-lg-4">
        <div class="info-category-wrapper">
          <ul class="info-category-list">
            @foreach ($categories as $category)
              <li class="info-category-list-item {{ $loop->index == 0 ? 'active' : '' }} " data-target="{{ $category->slug }}">{{ $category->name }}</li>
            @endforeach
          </ul>
          <div class="fade-bottom"></div>
        </div>
      </div>
      <div class="col-lg-8">
        @foreach ($categories as $category)
        <div class="info-post-wrapper {{ $loop->index == 0 ? 'show' : '' }}" data-category="{{ $category->slug }}">
          
          <div class="row row-gap-3">
          @for($i = 0; $i < 6; $i++)
            {{-- Jika post index tidak ada, break loop --}}
            @if(!isset($category->post[$i]))
              @break
            @endif
            @if($category->post[$i]->status == "draft")
              @continue
            @endif
            <div class="col-lg-6">
              <div class="card card-info">
                <div class="card-body">
                  <div class="text-secondary mb-2" style="font-size: 14px;"><i class="bi bi-calendar me-2"></i> {{ date("d-m-Y", strtotime($category->post[$i]->updated_at)) }}</div>
                  <a class="h5 text-decoration-none fw-semibold" href="{{ route('main.post', ['slug' => $category->post[$i]->slug]) }}">{{ $category->post[$i]->title }}</a>
                </div>
              </div>
            </div>
          @endfor
          @if(count($category->post) == 0)
            <div class="col-12">
              <p class="m-0 text-white text-center">Tidak ada postingan.</p>
            </div>
          @endif
          </div>

          @if(count($category->post) > 6)
          <div class="row mt-3">
            <div class="col-12 text-center">
              <a href="{{ route('main.category', ['slug', $category->slug]) }}" class="btn text-white">See More <i class="bi bi-chevron-right"></i></a>
            </div>
          </div>
          @endif

        </div>
        @endforeach
      </div>
    </div>
  </div>
</section>
<section id="gallery">
  <div class="container">
    <div class="row mb-5">
      <div class="col-12 text-center">
        <h5 class="display-6 fw-semibold">Gallery</h5>
      </div>
    </div>
    @if(count($gallery_slide) == 0)
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <p class="m-0 text-secondary">Belum ada foto untuk ditampilkan.</p>
          </div>
        </div>
      </div>
    </div>  
    @endif

    @php
      $gallery_idx = 0;
      $gallery_row = ceil(count($gallery_slide)/6);
    @endphp

    @for($i = 1; $i <= $gallery_row; $i++)
    <div class="row gallery-img-container mb-3">
      @for($j = 0; $j < 3; $j++)
        @if($j == 0 || $j == 2)
          <div class="col-3">
            @if(isset($gallery_slide[$gallery_idx]))
            <div data-bs-toggle="modal" data-bs-target="#gallery-lightbox-modal" class="gallery-img-wrapper img-outer rounded-3">
              <img src="{{ asset($gallery_slide[$gallery_idx]->meta_value) }}" >
            </div>
            @endif
          </div>
          @php
            $gallery_idx++;
          @endphp
        @else
          <div class="col-6">
            <div class="row mb-3">
              <div class="col-7">
                @if(isset($gallery_slide[$gallery_idx]))
                <div data-bs-toggle="modal" data-bs-target="#gallery-lightbox-modal" class="gallery-img-wrapper img-inner rounded-3">
                  <img src="{{ asset($gallery_slide[$gallery_idx]->meta_value) }}" >
                </div>
                @endif
              </div>
              <div class="col-5">
                @if(isset($gallery_slide[$gallery_idx+1]))
                <div data-bs-toggle="modal" data-bs-target="#gallery-lightbox-modal" class="gallery-img-wrapper img-inner rounded-3">
                  <img src="{{ asset($gallery_slide[$gallery_idx+1]->meta_value) }}" >
                </div>
                @endif
              </div>
            </div>
            <div class="row">
              <div class="col-5">
              @if(isset($gallery_slide[$gallery_idx+2]))
                <div data-bs-toggle="modal" data-bs-target="#gallery-lightbox-modal" class="gallery-img-wrapper img-inner rounded-3">
                  <img src="{{ asset($gallery_slide[$gallery_idx+2]->meta_value) }}" >
                </div>
              @endif
              </div>
              <div class="col-7">
                @if(isset($gallery_slide[$gallery_idx+3]))
                <div data-bs-toggle="modal" data-bs-target="#gallery-lightbox-modal" class="gallery-img-wrapper img-inner rounded-3">
                  <img src="{{ asset($gallery_slide[$gallery_idx+3]->meta_value) }}" >
                </div>
                @endif
              </div>
            </div>
          </div>
          @php
            $gallery_idx += 4;
          @endphp
        @endif
      @endfor
    </div>
    @endfor
  </div>
</section>
<section id="partners">
  <div class="container">
    <div class="row row-gap-3 mb-5">
      <div class="col-lg-10">
        <h5 class="display-6 fw-semibold">Collaboration Partners</h5>
        <p class="h5 fw-normal text-secondary">FKIP have collaborated with various institutions both domestically and internationally.</p>
      </div>
      <div class="col-lg-2 d-flex align-items-center justify-content-lg-end">
        {{-- <a href="" class="btn btn-round-purple">See More <i class="bi bi-chevron-right"></i></a> --}}
      </div>
    </div>
    <div class="row gap-0 column-gap-0 justify-content-center">
      @foreach ($partnership_slide as $slide)
      <div class="col-lg-3 p-0">
        <div class="card partner-card">
          <div class="card-body">
            <img src="{{ asset($slide->meta_value) }}" class="partner-card-img img-fluid">
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

{{-- GALLERY LIGHTBOX MODAL --}}
<div class="modal fade" id="gallery-lightbox-modal" tabindex="-1" aria-labelledby="gallery-lightbox-modal-Label" aria-hidden="true">
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="container-fluid p-0">
        <div class="row">
          <div class="col">
            <img src="" class="img-fluid rounded-2" id="gallery-lightbox-img">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js-addon')
<script>
  const agenda_count = {{ count($agenda_slide) }}
</script>
<script src="{{ asset('assets/main/theme-1/js/homepage.js') }}"></script>
@endsection

