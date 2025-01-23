<nav class="navbar d-none d-lg-flex" id="top-nav">
  <div class="container-fluid mx-3 d-flex justify-content-between">
    <div class="col-6">
      <div class="d-flex gap-1 nav-text">
        <i class="bi bi-telephone-fill me-2"></i>
        <span class="top-nav-text">{{ $web->phone_number }}</span>
        <span class="mx-1">|</span>
        <i class="bi bi-envelope-fill me-2"></i>
        <a href="mailto:fkip@ulm.ac.id" class="top-nav-text text-decoration-none">{{ $web->email }}</a>
      </div>
    </div>
    <div class="col-6">
      <ul class="d-flex align-items-center m-0 list-unstyled gap-3 justify-content-end">
        <li><a href=""><span class="fi fi-id me-1"></span>Bahasa Indonesia</a></li>
        <li><a href="">Latest News</a></li>
        <li><a href="">Campus Info</a></li>
        <li><a href="">Download</a></li>
        <li><a href="">Contact</a></li>
      </ul>
    </div>
  </div>
</nav>