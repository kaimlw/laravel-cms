@extends('admin.template.template')

@section('title', 'Media')

@section('css-addOn')
<link rel="stylesheet" href="{{ asset('vendor/simple-datatables/style.css') }}">
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
{{-- @dd($errors->edit) --}}
<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Pengaturan Website Desa</h3>
            <p class="text-subtitle text-muted">Konfigurasi dasar website desa</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class='breadcrumb-header'>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.main') }}">Dashboard</a></li>
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
                    <form class="form form-vertical" action="{{ route('dashboard.setting.update') }}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="namaDesa">Nama Desa</label>
                                        <input type="text" id="namaDesa" class="form-control @error('namaDesa') is-invalid @enderror" name="namaDesa" placeholder="Masukkan nama desa" value="{{ $desa->nama }}">
                                        @error('namaDesa')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="kodeDesa">Kode Desa</label>
                                        <input type="text" id="kodeDesa" class="form-control @error('kodeDesa') is-invalid @enderror" name="kodeDesa" placeholder="Masukkan kode desa" value="{{ $desa->kode_desa }}">
                                        @error('kodeDesa')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="alamatDesa">Alamat Desa</label>
                                        <textarea class="form-control @error('alamatDesa') is-invalid @enderror" name="alamatDesa" id="alamatDesa" cols="30" rows="3">{{ $desa->alamat }}</textarea>
                                        @error('alamatDesa')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="teleponDesa">No. Telepon Kantor</label>
                                        <input type="text" id="teleponDesa" class="form-control @error('teleponDesa') is-invalid @enderror" name="teleponDesa" placeholder="Masukkan No telepon kantor" value="{{ $desa->telepon }}">
                                        @error('teleponDesa')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="emailDesa">Email</label>
                                        <input type="email" id="emailDesa" class="form-control @error('emailDesa') is-invalid @enderror" name="emailDesa" placeholder="Masukkan email desa" value="{{ $desa->email }}">
                                        @error('emailDesa')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="">Banner Homepage</label>
                                        <div class="form-file w-75">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input @error('bannerHomeDesa') is-invalid @enderror" id="customFile" name="bannerHomeDesa">
                                                @error('bannerHomeDesa')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        @if ($desa->url_banner_home)
                                        <h6>Preview Banner Home:</h6>
                                        <img src="{{ $desa->url_banner_home }}" style="height:100px" loading="lazy">
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="">Banner Default Page dan Post</label>
                                        <div class="form-file w-75">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input @error('bannerPostDesa') is-invalid @enderror" id="customFile" name="bannerPostDesa">
                                                @error('bannerPostDesa')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        @if ($desa->url_banner_post)
                                        <h6>Preview Banner Post dan Page:</h6>
                                        <img src="{{ asset('img/ponpes-cropped.jpg') }}" style="height:100px" loading="lazy">
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

  
  
@endsection

@section('js-addOn')
{{-- <script src="{{ asset('vendor/simple-datatables/simple-datatables.js') }}"></script> --}}
{{-- <script src="{{ asset('admin/assets/js/pages/media.js') }}"></script> --}}

<script>
    @if ($errors->edit->any())
    $('#editUserModal').modal('show')
    @endif

    @if ($errors->tambah->any())
    $('#tambahUserModal').modal('show')
    @endif
</script>
@endsection