@extends('admin.template.template')

@section('title', 'Media')

@section('css-addOn')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/simple-datatables/style.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-5.3.3/css/bootstrap.min.css') }}">
<style>
    a{
        text-decoration: none;
    }

    .no-content{
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100px;
    }

    .media-card{
        cursor: pointer;
        height: 160px;
    }
    .media-card .card-body{
        position: relative;
    }
    .media-card .media-filename{
        position: absolute;
        bottom: 0
    }
    /* .media-card img{
        background: url({{ asset('assets/img/png_bg.jpg') }})
    } */
    .media-card .img-box{
        display: flex;
        flex-direction: column;
        justify-content: center;
        background: url({{ asset('assets/img/png_bg.jpg') }});
        height: 100%;
    }
    #detail_media img{
        background: url({{ asset('assets/img/png_bg.jpg') }})
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

{{-- Menampilkan error form upload --}}
@if ($errors->any())
<div class="alert alert-danger alert-dismissible show fade">
    @foreach ($errors->all() as $err_msg)
        <p>{{ $err_msg }}</p>
    @endforeach
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>
@endif

<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Media</h3>
            <p class="text-subtitle text-muted">Halaman kumpulan media yang telah diunggah ke website.</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class='breadcrumb-header'>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Media</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<section class="section mb-3">
    <div class="text-right">
        <button class="btn btn-primary" data-toggle="modal" data-target="#uploadMediaModal">Unggah File</button>
    </div>
</section>
<section class="section">
    <div class="card">
        <div class="card-body">
            <form method="GET">
                <div class="row">
                    <div class="col-md-10 col-sm-12 d-flex gap-3">
                        <div class="file-filter-container d-flex gap-2">
                            <fieldset class="form-group m-0">
                                <select class="form-select" id="fileTypeSelect" name="file_type">
                                    <option value="all" {{ $filter['file_type'] == 'all' ? 'selected' : '' }}>All media items</option>
                                    <option value="image" {{ $filter['file_type'] == 'image' ? 'selected' : '' }}>Images</option>
                                    <option value="documents" {{ $filter['file_type'] == 'documents' ? 'selected' : '' }}>Documents</option>
                                    <option value="spreadsheets" {{ $filter['file_type'] == 'spreadsheets' ? 'selected' : '' }}>Spreadsheets</option>
                                </select>
                            </fieldset>
                            <fieldset class="form-group m-0">
                                <select class="form-select" id="fileDateSelect" name="file_date">
                                    <option value="all">All dates</option>
                                    @foreach ($media_date_group as $item)
                                    <option value="{{ $item->month . "-" . $item->year }}" {{ $filter['file_date'] == $item->month . "-" . $item->year ? 'selected' : '' }}>{{ date("F Y", strtotime("01-" . $item->month . "-" . $item->year )) }}</option>
                                    @endforeach
                                </select>
                            </fieldset>
                            <div class="input-group" style="width: auto">
                                <span class="input-group-text" id="media-search"><i class="bi bi-search"></i></span>
                                <input type="text" class="form-control" name="file_search" placeholder="Cari media..." aria-label="Media Search" aria-describedby="media-search" value="{{ $filter['file_search'] }}">
                            </div>
                            <button class="btn btn-primary" type="submit">Terapkan</button>
                        </div>
                    </div>
                </div>
            </form>
            
        </div>
    </div>
</section>
<section class="section">
    <div class="card">
        <div class="card-body">
            @if (count($media))
            <div class="row" id="media_row">
                @foreach ($media as $item)
                    <div class="col-lg-2 col-sm-3 col-5 p-0">
                        <div class="card m-0 me-1 mb-1 media-card" data-media-id="{{ $item->id }}" data-bs-toggle="modal" data-bs-target="#mediaDetailModal">
                            <div class="card-body p-1 text-center h-100 w-100">
                                <div class="overflow-hidden h-100 w-100">
                                    @if (strpos($item->media_meta['mime_type'], 'image/') === 0)
                                        <div class="img-box">
                                            <img src="{{ asset($item->media_meta['filepath']['thumbnail']) }}" class="img-fluid">
                                        </div>
                                    @else
                                        <i class="bi bi-file-earmark-fill fs-1"></i>
                                        <div class="media-filename">
                                            {{ strlen($item->filename) > 30 ? substr($item->filename, 0, 20) . ' ... ' . substr($item->filename, strlen($item->filename)-5, strlen($item->filename)) : $item->filename }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                @if(count($media) < $media_count )
                <div class="col-12 text-center">
                    <button class="btn btn-primary btn-sm" id="btn_load">Load More</button>
                    <div class="spinner-border spinner-border-sm d-none" role="status" id="load_spinner">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                @endif
            </div>
            <div class="row mt-3">
                <div class="col-12 text-center">
                    <small>Menampilkan <span id="displayed_media">{{ count($media) }}</span> media dari {{ $media_count }}</small>
                </div>
            </div>
            @else
                <div class="no-content">
                    <h5>Tidak ada media ditemukan</h5>
                </div>
            @endif
            
        </div>
    </div>
</section>

{{-- Upload Modal --}}
<div class="modal fade" id="uploadMediaModal" tabindex="-1" aria-labelledby="uploadMediaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadMediaModalLabel">Unggah Media Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form form-vertical" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <input class="form-control" type="file" id="formFile" name="media">
                                </div>
                                <div class="upload-info mt-3 text-center">
                                    <p class="m-0">Ukuran File Maksimal: 128 MB</p>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
            </div>
        </form>
        </div>
    </div>
</div>

{{-- Preview Modal --}}
<div class="modal fade" id="mediaDetailModal" tabindex="-1" aria-labelledby="mediaDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="mediaDetailModalLabel">Media Detail</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-7">
                        <div id="detail_media" class="text-center">
                            
                        </div>
                    </div>
                    <div class="col-md-5 border-left">
                        <ul class="list-unstyled d-flex flex-column gap-1">
                            <li id="detail_tgl_upload"><b>Tanggal Unggah:</b> </li>
                            <li id="detail_user_uploader"><b>Diunggah Oleh:</b> </li>
                            <li id="detail_nama_file"><b>Nama File:</b> </li>
                            <li id="detail_tipe_file"><b>Tipe File:</b> </li>
                            <li id="detail_ukuran_file"><b>Ukuran File:</b> </li>
                            <li id="detail_dimensi_img"><b>Dimensi Gambar:</b> </li>
                        </ul>
                        <div class="d-flex gap-2">
                            <button class="btn btn-danger" id="btn_hapus_media"><i class="bi bi-trash"></i> Hapus Media</button>
                            <a class="btn btn-success" href="" id="btn_download_media"><i class="bi bi-download"></i> Download Media</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Hapus Modal --}}
<div class="modal fade" id="hapusMediaModal" tabindex="-1" aria-labelledby="hapusMediaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form id="formHapus" method="POST">
            @method('DELETE')
            @csrf
            <div class="modal-body">
                <div class="text-center">
                    <i class="bi bi-exclamation-circle-fill fs-1 text-danger display-4"></i>
                    <h3>
                        Apakah anda yakin ingin menghapus media berikut?
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
    const site_url = "{{ $web->site_url ?? route('main') }}";
    const media_count = {{ $media_count }};
    let displayed_media = {{ count($media) }};
</script>
<script src="{{ asset('assets/admin/assets/js/pages/media.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap-5.3.3/js/bootstrap.min.js') }}"></script>
@endsection