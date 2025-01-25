<nav class="navbar navbar-expand-lg blur" id="main-nav">
  <div class="container-fluid mx-3 position-relative">
    <a class="navbar-brand d-flex align-items-center gap-2 gap-lg-3 order-first" href="{{ route('main') }}">
      <img src="{{ asset('assets/img/ULM.png') }}" alt="Logo" width="45" height="45" class="align-text-top">
      <div class="text-white">
        <h6 class="mb-1">Fakultas Keguruan dan Ilmu Pengetahuan</h6>
        <h5 class="m-0">Universitas Lambung Mangkurat</h5>
      </div>
    </a>
    <div class="d-flex align-items-center">
      <button class="btn btn-round-white me-3 d-inline d-lg-none" id="btn-search-md"><i class="bi bi-search"></i></button>
      <button class="navbar-toggler order-3 text-white border-white" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbarNav" aria-controls="mainNavbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <i class="bi bi-list"></i>
      </button>
    </div>
    <div class="collapse navbar-collapse justify-content-lg-end order-lg-3 order-3" id="mainNavbarNav">
      <ul class="navbar-nav gap-lg-3">
        {!! $menu_html !!}
      </ul>
    </div>
    <button class="btn btn-round-white d-none d-lg-block order-last ms-3" id="btn-search-lg"><i class="bi bi-search"></i></button>
    <div class="w-100 px-3" id="searchbar">
      <form action="">
        <div class="input-group">
          <input type="text" name="search" id="search-input" class="form-control" placeholder="Search something..." aria-label="Search" aria-describedby="btn-search-submit" role="search">
          <button class="btn btn-purple" type="button" id="btn-search-submit" type="submit">Search</button>
        </div>
      </form>
    </div>
  </div>
</nav>