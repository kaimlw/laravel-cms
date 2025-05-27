@extends('admin.template.template')

@section('title', 'Tema')

@section('css-addOn')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-5.3.3/css/bootstrap.min.css') }}">
<style>
    a{
        text-decoration: none;
    }

    .slide-preview-wrapper{
        display: flex;
        gap: 1.5rem;
        list-style: none;
        counter-reset: list-counter;
        padding: 0; 
        width: max-content;
        padding-bottom: 2rem;
        margin-bottom: 0;
    }
    
    .slide-item{
        flex: 1;
        position: relative;
        display: flex;
        overflow: hidden;
        justify-content: center;
        background-image: url({{ asset('assets/img/png_bg.jpg') }});
        border-radius: 0.5rem;
    }

    .slide-item.main-slide{
        width: 200px;
        height: 150px;
    }

    .slide-item.agenda-slide{
        width: 200px;
        height: 300px;
    }

    .slide-item.gallery-slide{
        width: 200px;
        height: 150px;
    }

    .slide-item.partnership-slide{
        width: 200px;
        height: 150px;
    }
    
    .slide-item::before{
        content: counter(list-counter);
        counter-increment: list-counter;
        position: absolute;
        bottom: -1.5rem;
    }

    .slide-item img{
        width: 100%;
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
    }
    .slide-item .btn-hapus{
        z-index: 3;
        width: 100%;
        position: absolute;
        background-color: rgba(255, 50, 50, 0.6);
        color: white;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        opacity: 0;
    }
    
    .slide-item .btn-hapus:hover{
        opacity: 1;
    }

    #mediaBrowserModal .media-wrapper{
        list-style: none;
        display: flex;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 0.5em;
        overflow: scroll;
    }

    #mediaBrowserModal .media-wrapper .media-item{
        position: relative;
        width: 125px;
        height: 125px;
        cursor: pointer;
        padding: 0.15em
    }
    
    #mediaBrowserModal .media-wrapper .media-item.selected{
        border: 3px solid blue;
    }
    
    #mediaBrowserModal .media-wrapper .media-item .thumbnail{
        border: 1px solid gray;
        position: absolute;
        right: 0.15em;
        left: 0.15em;
        top: 0.15em;
        bottom: 0.15em;
        background: url("{{ asset('assets/img/png_bg.jpg') }}");
        background-size: cover;
    }
</style>
@endsection

@section('content')

@if (session('showAlert'))
<div class="alert alert-{{ session('showAlert')['type'] }} alert-dismissible show fade">
    {{ session('showAlert')['msg'] }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>
@endif

<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Tema Website</h3>
            <p class="text-subtitle text-muted">Konfigurasi tema website</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class='breadcrumb-header'>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Theme</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

{{-- Main Slide Section --}}
<section class="section">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5>Slider Utama</h5>
                        <input type="file" id="main_slide_upload_input" style="display: none">
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-plus-lg"></i> Tambah Slider
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><button class="dropdown-item" id="main_slide_upload_btn"><i class="bi bi-upload"></i> Upload (Max: 5Mb)</button></li>
                                <li><button class="dropdown-item" id="main_slide_media_btn"><i class="bi bi-images"></i> Buka Media Browser</button></li>
                            </ul>
                        </div>
                    </div>
                    <div class="w-100 mb-3" id="main_slide_upload_progress_wrapper" style="display: none">
                        <h6>Upload Progress</h6>
                        <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="height: 10px">
                            <div class="progress-bar" style="width: 25%"></div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="overflow-x-scroll">
                                <ol class="slide-preview-wrapper" id="main-slide">
                                    @foreach ($main_slide as $slide)
                                    <li class="slide-item main-slide" data-id="{{ $slide->id }}">
                                        <button class="btn btn-hapus" data-id="{{ $slide->id }}" data-section="main-slide"><i class="bi bi-trash-fill"></i></button>
                                        <img class="img-fluid rounded-2" src="{{ asset($slide->meta_value) }}">
                                    </li>
                                    @endforeach
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Ucapan Section --}}
<section class="section">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5>Ucapan Kepala Prodi</h5>
                    </div>
                    <div class="w-100 mb-3" id="kaprodi_photo_upload_progress_wrapper" style="display: none">
                        <h6>Upload Progress</h6>
                        <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="height: 10px">
                            <div class="progress-bar" style="width: 25%"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="card h-100 m-0">
                        <div class="card-body h-100">
                            <h6>Foto Kepala Prodi</h6>
                            <div class="border border-dashed mb-3 position-relative" id="kaprodi_photo_preview" style="min-height: 200px">
                                @if ($kaprodi['kaprodi_photo'])
                                    <img src="{{ $web->site_url }}/{{ $kaprodi['kaprodi_photo'] }}" alt="" class="img-fluid" >
                                @else
                                    <small class="position-absolute top-50 w-100 text-center">Tidak ada photo</small>
                                @endif
                            </div>
                            <input type="file" id="kaprodi_photo_upload_input" style="display: none">
                            <div class="d-flex flex-column" id="kaprodi_photo_buttons">
                                @if ($kaprodi['kaprodi_photo'])
                                <button class="btn btn-danger btn-sm mb-1" id="kaprodi_photo_remove_btn"><i class="bi bi-trash"></i> Hapus Foto</button>
                                @endif
                                <div class="dropdown w-100">
                                    <button class="btn btn-primary dropdown-toggle btn-sm w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-pencil"></i> Ubah Foto
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><button class="dropdown-item" id="kaprodi_photo_upload_btn"><i class="bi bi-upload"></i> Upload (Max: 5Mb)</button></li>
                                        <li><button class="dropdown-item" id="kaprodi_photo_media_btn"><i class="bi bi-images"></i> Buka Media Browser</button></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card m-0">
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.theme.store_kaprodi_name_speech') }}">
                                @csrf
                                <div class="mb-3">
                                    <div class="form-group">
                                        <label for="kaprodiNameInput">Nama Kepala Prodi</label>
                                        <input type="text" id="kaprodiNameInput" class="form-control @error('kaprodi_name') is-invalid @enderror" name="kaprodi_name" placeholder="Masukkan nama kepala prodi" value="{{ $kaprodi['kaprodi_name'] }}">
                                        @error('kaprodi_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-group">
                                        <label for="kaprodiSpeechInput" class="form-label">Ucapan Selamat Datang</label>
                                        <textarea placeholder="Masukkan ucapan" class="form-control @error('kaprodi_speech') is-invalid @enderror" id="kaprodiSpeechInput" name="kaprodi_speech" rows="3">{{ $kaprodi['kaprodi_speech'] }}</textarea>
                                        @error('kaprodi_speech')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-1">
                                    <button class="btn btn-primary" type="submit"><i class="bi bi-floppy-fill"></i> Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Agenda Section --}}
<section class="section">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5>Agenda</h5>
                        <input type="file" id="agenda_upload_input" style="display: none">
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-plus-lg"></i> Tambah Poster Agenda
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><button class="dropdown-item" id="agenda_upload_btn"><i class="bi bi-upload"></i> Upload (Max: 5Mb)</button></li>
                                <li><button class="dropdown-item" id="agenda_media_btn"><i class="bi bi-images"></i> Buka Media Browser</button></li>
                            </ul>
                        </div>
                    </div>
                    <div class="w-100 mb-3" id="agenda_upload_progress_wrapper" style="display: none">
                        <h6>Upload Progress</h6>
                        <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="height: 10px">
                            <div class="progress-bar" style="width: 25%"></div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="overflow-x-scroll">
                                <ol class="slide-preview-wrapper" id="agenda-slide">
                                    @foreach ($agenda_slide as $slide)
                                    <li class="slide-item agenda-slide" data-id="{{ $slide->id }}">
                                        <button class="btn btn-hapus" data-id="{{ $slide->id }}" data-section="agenda-slide"><i class="bi bi-trash-fill"></i></button>
                                        <img class="img-fluid rounded-2" src="{{ asset($slide->meta_value) }}">
                                    </li>
                                    @endforeach
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
{{-- Gallery Section --}}
<section class="section">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5>Gallery</h5>
                        <input type="file" id="gallery_upload_input" style="display: none">
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-plus-lg"></i> Tambah Gambar
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><button class="dropdown-item" id="gallery_upload_btn"><i class="bi bi-upload"></i> Upload (Max: 5Mb)</button></li>
                                <li><button class="dropdown-item" id="gallery_media_btn"><i class="bi bi-images"></i> Buka Media Browser</button></li>
                            </ul>
                        </div>
                    </div>
                    <div class="w-100 mb-3" id="gallery_upload_progress_wrapper" style="display: none">
                        <h6>Upload Progress</h6>
                        <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="height: 10px">
                            <div class="progress-bar" style="width: 25%"></div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="overflow-x-scroll">
                                <ol class="slide-preview-wrapper" id="gallery-slide">
                                    @foreach ($gallery_slide as $slide)
                                    <li class="slide-item gallery-slide" data-id="{{ $slide->id }}">
                                        <button class="btn btn-hapus" data-id="{{ $slide->id }}" data-section="gallery-slide"><i class="bi bi-trash-fill"></i></button>
                                        <img class="img-fluid rounded-2" src="{{ asset($slide->meta_value) }}">
                                    </li>
                                    @endforeach
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Partnership Section --}}
<section class="section">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5>Partnership</h5>
                        <input type="file" id="partnership_upload_input" style="display: none">
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-plus-lg"></i> Tambah Gambar
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><button class="dropdown-item" id="partnership_upload_btn"><i class="bi bi-upload"></i> Upload (Max: 5Mb)</button></li>
                                <li><button class="dropdown-item" id="partnership_media_btn"><i class="bi bi-images"></i> Buka Media Browser</button></li>
                            </ul>
                        </div>
                    </div>
                    <div class="w-100 mb-3" id="partnership_upload_progress_wrapper" style="display: none">
                        <h6>Upload Progress</h6>
                        <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="height: 10px">
                            <div class="progress-bar" style="width: 25%"></div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="overflow-x-scroll">
                                <ol class="slide-preview-wrapper" id="partnership-slide">
                                    @foreach ($partnership_slide as $slide)
                                    <li class="slide-item partnership-slide" data-id="{{ $slide->id }}">
                                        <button class="btn btn-hapus" data-id="{{ $slide->id }}" data-section="partnership-slide"><i class="bi bi-trash-fill"></i></button>
                                        <img class="img-fluid rounded-2" src="{{ asset($slide->meta_value) }}">
                                    </li>
                                    @endforeach
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Media Browser Modal --}}
<div class="modal fade" id="mediaBrowserModal" tabindex="-1" aria-labelledby="mediaBrowserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="mediaBrowserModalLabel">Pilih Media</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="media-wrapper" id="media-wrapper">
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" disabled id="btnMediaPilih">Pilih</button>
            </div>
        </div>
    </div>
</div>

{{-- Hapus Modal --}}
<div class="modal fade" id="hapusModal" tabindex="-1" aria-labelledby="hapusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <form id="formHapus" method="POST">
            @method('DELETE')
            @csrf
            <div class="modal-body">
                <div class="text-center">
                    <i class="bi bi-exclamation-circle-fill fs-1 text-danger display-4"></i>
                    <h3>
                        Apakah anda yakin ingin menghapus?
                    </h3>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="submit" class="btn btn-danger">Hapus</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        </form>
      </div>
    </div>
</div>
@endsection

@section('js-addOn')
<script>
const site_url = "{{ $web->site_url ?? route('main') }}"
</script>
<script src="{{ asset('assets/vendor/bootstrap-5.3.3/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/admin/assets/js/pages/theme.js') }}"></script>
@endsection