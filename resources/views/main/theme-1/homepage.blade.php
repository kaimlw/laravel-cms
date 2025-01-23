@extends('main.theme-1.layout.template')

@section('title', 'Home')

@section('css-addon')
  
@endsection

@section('content')
<section id="banner" class="bg-purple">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 banner-description order-last order-md-first">
        <h5 class="text-white">WELCOME TO</h5>
        <h1 class="text-white display-5 fw-bold">Faculty of <br>Teacher Training and Education</h1>
        <p class="text-white">We are commited to building an Integrity Zone towards a Corruption-Free Area and a Clean and Serving Bureaucratic Area</p>
        <a href="#" class="btn btn-round-yellow">Selengkapnya <i class="bi bi-chevron-right ms-2"></i></a>
        <div class="splide__container mt-4">
          <div class="fade-left"></div>
          <div class="splide" id="partner_slide" role="group" aria-label="FKIP Partners Slide">
            <div class="splide__track">
              <ul class="splide__list">
                <li class="splide__slide">
                  <div class="splide__slide__container">
                    <img src="{{ asset('assets/main/theme-1/img/UTM.png') }}" alt="">
                  </div>
                </li>
                <li class="splide__slide">
                  <div class="splide__slide__container">
                    <img src="{{ asset('assets/main/theme-1/img/nihon.png') }}" alt="">
                  </div>
                </li>
                <li class="splide__slide">
                  <div class="splide__slide__container">
                    <img src="{{ asset('assets/main/theme-1/img/sea.png') }}" alt="">
                  </div>
                </li>
                <li class="splide__slide">
                  <div class="splide__slide__container">
                    <img src="{{ asset('assets/main/theme-1/img/gibs.png') }}" alt="">
                  </div>
                </li>
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
        <h1 class="text-center">Welcome to Faculty of Teacher Training and Education Lambung Mangkurat University</h1>
        <p class="text-center text-secondary">We are committed to building an Integrity Zone towards a Corruption-Free Area and a Clean and Serving Bureaucratic Area.</p>
        <div class="welcome-dean-container flex-column flex-lg-row mt-5">
          <div class="welcome-dean-container-item">
            <div class="welcome-dean-container-item-img mb-3">
              <img src="{{ asset('assets/main/theme-1/img/dean.png') }}" class="img-fluid" alt="">
            </div>
            <h5 class=" fw-bold text-center">Prof. Dr. Sunarno Basuki, Drs.,M.Kes., AIFO</h5>
            <p class="text-secondary text-center">DEAN</p>
          </div>
          <div class="welcome-dean-container-item">
            <div class="welcome-dean-container-item-img mb-3">
              <img src="{{ asset('assets/main/theme-1/img/vice-dean1.png') }}" class="img-fluid" alt="" style="transform: scale(1.15) translateY(30px);">
            </div>
            <h5 class=" fw-bold text-center">Prof. Dr. Deasy Arisanty, S.Si.,M.Sc.</h5>
            <p class="text-secondary text-center">VICE DEAN FOR ACADEMIC AFFAIRS</p>
          </div>
          <div class="welcome-dean-container-item">
            <div class="welcome-dean-container-item-img mb-3">
              <img src="{{ asset('assets/main/theme-1/img/vice-dean2.png') }}" class="img-fluid" alt="">
            </div>
            <h5 class=" fw-bold text-center">Dr. Dharmono, M.Si.</h5>
            <p class="text-secondary text-center">VICE DEAN FOR GENERAL, FINANCE, AND PERSONNEL AFFAIRS</p>
          </div>
          <div class="welcome-dean-container-item">
            <div class="welcome-dean-container-item-img mb-3">
              <img src="{{ asset('assets/main/theme-1/img/vice-dean3.png') }}" class="img-fluid" alt="">
            </div>
            <h5 class=" fw-bold text-center">Dr. Ali Rachman S.Pd., M.Pd.</h5>
            <p class="text-secondary text-center">VICE DEAN FOR STUDENT AFFAIRS</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section id="reasons">
  <div class="container">
    <div class="row mb-4">
      <div class="col-12">
        <h5 class="display-6 fw-semibold">10 Reasons to Choose FKIP ULM?</h5>
        <p class="text-secondary">Here are 10 reasons why you choose to study at FKIP ULM</p>
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
            <h5 class="reasons-card-title">Academic Reputation</h5>
            <p class="reasons-card-content">
              FKIP ULM provides comprehensive and modern facilities to support the learning process, such as a rich library with learning resources, laboratories equipped with advanced equipment, and comfortable classrooms.
            </p>
          </div>
        </div>
      </div>
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
            <span class="fw-bold reasons-card-number">01</span>
            <h5 class="reasons-card-title">Academic Reputation</h5>
            <p class="reasons-card-content">
              FKIP ULM has a good reputation in education and research, providing a supportive academic environment for students.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section id="video-profile" class="video-fkip">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="video-wrapper" data-url="https://www.youtube.com/embed/ifoXe1zGk64" data-img="assets/main/theme-1/img/profil-overlay.png" data-icon="bi bi-play-circle-fill">
          <div class="video-player">
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
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
<section id="video-facilities" class="video-fkip">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="video-wrapper" data-url="https://www.youtube.com/embed/As9yJdRPkfE" data-img="assets/main/theme-1/img/fasilitas-overlay.png" data-icon="bi bi-play-circle-fill">
          <div class="video-player">
          </div>
        </div>
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
                <li class="splide__slide">
                  <div class="splide__slide__container">
                    <img src="{{ asset('assets/main/theme-1/img/brosur-1.png') }}" alt="">
                  </div>
                </li>
                <li class="splide__slide">
                  <div class="splide__slide__container">
                    <img src="{{ asset('assets/main/theme-1/img/brosur-2.png') }}" alt="">
                  </div>
                </li>
                <li class="splide__slide">
                  <div class="splide__slide__container">
                    <img src="{{ asset('assets/main/theme-1/img/brosur-3.png') }}" alt="">
                  </div>
                </li>
                <li class="splide__slide">
                  <div class="splide__slide__container">
                    <img src="{{ asset('assets/main/theme-1/img/brosur-4.png') }}" alt="">
                  </div>
                </li>
                <li class="splide__slide">
                  <div class="splide__slide__container">
                    <img src="{{ asset('assets/main/theme-1/img/brosur-5.png') }}" alt="">
                  </div>
                </li>
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
      @if(isset($latest_news->post))
      @foreach ($latest_news->post as $post)
      <div class="col-lg-4">
        <div class="card border-0 h-100">
          <a href="">
            <img src="{{ asset('assets/main/theme-1/img/headings-1.png') }}" class="card-img-top rounded-2">
          </a>
          <div class="card-body p-0 mt-3">
            <div class="text-secondary mb-2" style="font-size: 14px;"><i class="bi bi-calendar me-2"></i> {{ $post->updated_at }}</div>
            <a class="h5 text-decoration-none fw-semibold" href="">{{ $post->title }}</a>
            <div class="text-secondary mt-2">
              {!! $post->excerpt !!}
            </div>
            
          </div>
        </div>
      </div>
      @endforeach
      @endif
    </div>
    <div class="row mt-3">
      <div class="col-12 text-center">
        <a href="" class="btn btn-round-purple">More Article <i class="bi bi-chevron-right"></i></a>
      </div>
    </div>
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
          @foreach ($category->post as $post)
              <div class="col-lg-6">
                <div class="card card-info">
                  <div class="card-body">
                    <div class="text-secondary mb-2" style="font-size: 14px;"><i class="bi bi-calendar me-2"></i> {{ $post->updated_at }}</div>
                    <a class="h5 text-decoration-none fw-semibold" href="">{{ $post->title }}</a>
                  </div>
                </div>
              </div>
          @endforeach
          </div>
          <div class="row mt-3">
            <div class="col-12 text-center">
              <a href="" class="btn text-white">See More <i class="bi bi-chevron-right"></i></a>
            </div>
          </div>

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
    <div class="row gallery-img-container">
      <div class="col-3">
        <div data-bs-toggle="modal" data-bs-target="#gallery-lightbox-modal" class="gallery-img-wrapper img-outer rounded-3">
          <img src="{{ asset('assets/main/theme-1/img/gallery-1.png') }}" >
        </div>
      </div>
      <div class="col-6">
        <div class="row mb-3">
          <div class="col-7">
            <div data-bs-toggle="modal" data-bs-target="#gallery-lightbox-modal" class="gallery-img-wrapper img-inner rounded-3">
              <img src="{{ asset('assets/main/theme-1/img/gallery-2.png') }}" >
            </div>
          </div>
          <div class="col-5">
            <div data-bs-toggle="modal" data-bs-target="#gallery-lightbox-modal" class="gallery-img-wrapper img-inner rounded-3">
              <img src="{{ asset('assets/main/theme-1/img/gallery-2.png') }}" >
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-5">
            <div data-bs-toggle="modal" data-bs-target="#gallery-lightbox-modal" class="gallery-img-wrapper img-inner rounded-3">
              <img src="{{ asset('assets/main/theme-1/img/gallery-3.png') }}" >
            </div>
          </div>
          <div class="col-7">
            <div data-bs-toggle="modal" data-bs-target="#gallery-lightbox-modal" class="gallery-img-wrapper img-inner rounded-3">
              <img src="{{ asset('assets/main/theme-1/img/gallery-3.png') }}" >
            </div>
          </div>
        </div>
      </div>
      <div class="col-3">
        <div data-bs-toggle="modal" data-bs-target="#gallery-lightbox-modal" class="gallery-img-wrapper img-outer rounded-3">
          <img src="{{ asset('assets/main/theme-1/img/gallery-1.png') }}" >
        </div>
      </div>
    </div>
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
        <a href="" class="btn btn-round-purple">See More <i class="bi bi-chevron-right"></i></a>
      </div>
    </div>
    <div class="row gap-0 column-gap-0 justify-content-center">
      <div class="col-lg-3 p-0">
        <div class="card partner-card">
          <div class="card-body">
            <img src="{{ asset('assets/main/theme-1/img/utm-partner.png') }}" class="partner-card-img">
          </div>
        </div>
      </div>
      <div class="col-lg-3 p-0">
        <div class="card partner-card">
          <div class="card-body">
            <img src="{{ asset('assets/main/theme-1/img/nihon-color.png') }}" class="partner-card-img">
          </div>
        </div>
      </div>
      <div class="col-lg-3 p-0">
        <div class="card partner-card">
          <div class="card-body">
            <img src="{{ asset('assets/main/theme-1/img/sea.png') }}" class="partner-card-img">
          </div>
        </div>
      </div>
      <div class="col-lg-3 p-0">
        <div class="card partner-card">
          <div class="card-body">
            <img src="{{ asset('assets/main/theme-1/img/gibs.png') }}" class="partner-card-img">
          </div>
        </div>
      </div>
      <div class="col-lg-3 p-0">
        <div class="card partner-card">
          <div class="card-body">
            <img src="{{ asset('assets/main/theme-1/img/gibs.png') }}" class="partner-card-img">
          </div>
        </div>
      </div>
      <div class="col-lg-3 p-0">
        <div class="card partner-card">
          <div class="card-body">
            <img src="{{ asset('assets/main/theme-1/img/gibs.png') }}" class="partner-card-img">
          </div>
        </div>
      </div>
      <div class="col-lg-3 p-0">
        <div class="card partner-card">
          <div class="card-body">
            <img src="{{ asset('assets/main/theme-1/img/gibs.png') }}" class="partner-card-img">
          </div>
        </div>
      </div>
      <div class="col-lg-3 p-0">
        <div class="card partner-card">
          <div class="card-body">
            <img src="{{ asset('assets/main/theme-1/img/gibs.png') }}" class="partner-card-img">
          </div>
        </div>
      </div>
      <div class="col-lg-3 p-0">
        <div class="card partner-card">
          <div class="card-body">
            <img src="{{ asset('assets/main/theme-1/img/gibs.png') }}" class="partner-card-img">
          </div>
        </div>
      </div>
      <div class="col-lg-3 p-0">
        <div class="card partner-card">
          <div class="card-body">
            <img src="{{ asset('assets/main/theme-1/img/gibs.png') }}" class="partner-card-img">
          </div>
        </div>
      </div>
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
  
@endsection

