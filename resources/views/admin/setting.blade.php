@extends('admin.template.template')

@section('title', 'Setting')

@section('css-addOn')
<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-5.3.3/css/bootstrap.min.css') }}">
<style>
    a{
        text-decoration: none;
    }

    #mediaBrowserModal .media-wrapper{
        list-style: none;
        display: flex;
        align-items: flex-start;
        height: 60vh;
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
            <h3>Pengaturan Website</h3>
            <p class="text-subtitle text-muted">Konfigurasi dasar website</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class='breadcrumb-header'>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Setting</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<section class="section">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <form class="form form-vertical" action="{{ route('admin.setting.update', ['id' => base64_encode(encrypt($web->id))]) }}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <input type="hidden" id="web" value="{{ base64_encode(encrypt($web->id)) }}">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="namaWeb">Nama Web</label>
                                        <input type="text" id="namaWeb" class="form-control @error('nama_web') is-invalid @enderror" name="nama_web" placeholder="Masukkan nama Web" value="{{ $web->name }}">
                                        @error('nama_web')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="teleponWeb">No. Telepon</label>
                                        <input type="text" id="teleponWeb" class="form-control @error('telepon_web') is-invalid @enderror" name="telepon_web" placeholder="Masukkan nomor telepon" value="{{ $web->phone_number }}">
                                        @error('telepon_web')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="emailWeb">Email</label>
                                        <input type="email" id="emailWeb" class="form-control @error('email_web') is-invalid @enderror" name="email_web" placeholder="Masukkan email Web" value="{{ $web->email }}">
                                        @error('email_web')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="">Banner Default Page dan Post</label>
                                        <div class="input-group mb-3">
                                            <button class="btn btn-outline-primary" type="button" id="banner_default_btn">Buka Media Browser</button>
                                            <input type="file" class="form-control" id="upload" name="banner_post_web" aria-describedby="banner_default_post_btn" aria-label="Upload">
                                            @error('banner_post_web')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <input type="hidden" name="banner_post_web_media" id="input_default_banner_post">
                                        <h6>Preview Banner Post dan Page:</h6>
                                        <img src="{{ $web->default_post_banner_path ? asset($web->default_post_banner_path) : "" }}" style="height:100px" loading="lazy" id="img_preview_banner_post">
                                        @if ($web->default_post_banner_path)
                                            <button class="btn btn-danger btn-sm" type="button" id="btn_hapus_banner_post"><i class="bi bi-trash-fill"></i> Hapus Banner</button>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-end mt-3">
                                    <button type="submit" class="btn btn-primary mr-1 mb-1">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </form>
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
@endsection

@section('js-addOn')
<script src="{{ asset('assets/vendor/bootstrap-5.3.3/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/admin/assets/js/pages/setting.js') }}"></script>
@endsection