<nav class="navbar d-none d-lg-flex" id="top-nav">
  <div class="container-fluid mx-3 d-flex justify-content-between">
    <div class="col-6">
      <div class="d-flex gap-1 nav-text">
        @if($web->phone_number)
        <i class="bi bi-telephone-fill me-2"></i>
        <span class="top-nav-text">{{ $web->phone_number }}</span>
        @endif
        <span class="mx-1">{{ $web->phone_number && $web->email ? '|' : '' }}</span>
        @if($web->email)
        <i class="bi bi-envelope-fill me-2"></i>
        <a href="mailto:fkip@ulm.ac.id" class="top-nav-text text-decoration-none">{{ $web->email }}</a>
        @endif
      </div>
    </div>
    <div class="col-6">
      <ul class="d-flex align-items-center m-0 list-unstyled gap-3 justify-content-end">
        {!! $top_menu_html !!}
      </ul>
    </div>
  </div>
</nav>