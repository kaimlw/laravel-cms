@extends('admin.template.template')

@section('title', 'Media')

@section('css-addOn')
<link rel="stylesheet" href="{{ asset('vendor/simple-datatables/style.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/bootstrap-5.3.3/css/bootstrap.min.css') }}">
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
{{-- @dd($errors->edit) --}}
<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Media</h3>
            <p class="text-subtitle text-muted">Halaman kumpulan media yang telah diunggah ke website.</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class='breadcrumb-header'>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.main') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Media</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<section class="section mb-3">
    <div class="text-right">
        <button class="btn btn-primary" data-toggle="modal" data-target="#uploadMediaModal">Tambah File Media Baru</button>
    </div>
</section>
<section class="section">
    <div class="card">
        {{-- <div class="card-header text-right">
        </div> --}}
        <div class="card-body">
            <div class="row">
                <div class="col-md-8 col-sm-12 d-flex gap-3">
                    <div class="view-type-container">
                        <input type="radio" class="btn-check" name="viewType" id="viewTypeList" autocomplete="off">
                        <label class="btn btn-outline-primary" for="viewTypeList"><i class="bi bi-list-task"></i></label>
            
                        <input type="radio" class="btn-check" name="viewType" id="viewTypeGrid" autocomplete="off" checked>
                        <label class="btn btn-outline-primary" for="viewTypeGrid"><i class="bi bi-grid-3x3-gap-fill"></i></label>
                    </div>
                    <div class="file-filter-container d-flex gap-2">
                        <fieldset class="form-group m-0">
                            <select class="form-select" id="fileTypeSelect">
                                <option value="all">All media items</option>
                                <option value="image">Images</option>
                                <option value="audio">Audio</option>
                                <option value="video">Video</option>
                                <option value="application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-word.document.macroEnabled.12,application/vnd.ms-word.template.macroEnabled.12,application/vnd.oasis.opendocument.text,application/vnd.apple.pages,application/pdf,application/vnd.ms-xpsdocument,application/oxps,application/rtf,application/wordperfect,application/octet-stream">Documents</option>
                                <option value="application/vnd.apple.numbers,application/vnd.oasis.opendocument.spreadsheet,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel.sheet.macroEnabled.12,application/vnd.ms-excel.sheet.binary.macroEnabled.12">Spreadsheets</option>
                                <option value="application/x-gzip,application/rar,application/x-tar,application/zip,application/x-7z-compressed">Archives</option>
                                <option value="unattached">Unattached</option>
                                <option value="mine">Mine</option>
                            </select>
                        </fieldset>
                        <fieldset class="form-group m-0">
                            <select class="form-select" id="fileDateSelect">
                                <option value="all">All dates</option>
                                <option value="0">Januari 2024</option>
                            </select>
                        </fieldset>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="input-group">
                        <span class="input-group-text" id="media-search"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" placeholder="Cari media..." aria-label="Media Search" aria-describedby="media-search">
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</section>
<section class="section">
    <div class="card">
        <div class="card-body">
            <div class="no-content">
                <h5>Tidak ada media ditemukan</h5>
                {{-- @foreach ($media as $item)
                    <img src="{{ $item->getUrl() }}" alt="">
                @endforeach --}}
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="uploadMediaModal" tabindex="-1" aria-labelledby="uploadMediaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadMediaModalLabel">Upload Media Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form form-vertical" method="POST" action="{{ route('dashboard.user.store') }}">
                    @csrf
                    <div class="form-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-file">
                                    <input type="file" class="form-file-input" id="customFile">
                                    <label class="form-file-label" for="customFile">
                                        <span class="form-file-text">Pilih File...</span>
                                        <span class="form-file-button">Cari</span>
                                    </label>
                                    <div class="upload-info mt-3 text-center">
                                        <p class="m-0">Ukuran File Maksimal: 1 GB</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
                <button type="reset" class="btn btn-light-secondary mr-1 mb-1">Reset</button>
            </div>
        </form>
        </div>
    </div>
</div>
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit Pengguna</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form form-vertical" id="formEdit" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="form-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="usernameInput">Username</label>
                                    <input type="text" id="usernameInput" class="form-control @error('usernameEdit','edit') is-invalid @enderror" name="usernameEdit" placeholder="Masukkan nama pengguna" value="{{ old('usernameEdit') }}">
                                    @error('usernameEdit','edit')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="displayNameInput">Display Name</label>
                                    <input type="text" id="displayNameInput" class="form-control @error('displayNameEdit','edit') is-invalid @enderror" name="displayNameEdit" placeholder="Masukkan nama yang akan ditampilkan" value="{{ old('displayNameEdit') }}">
                                    @error('displayNameEdit','edit')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <fieldset class="form-group">
                                    <label for="roleSelect">Role Pengguna</label>
                                    <select class="form-select @error('roleEdit','edit') is-invalid @enderror" id="roleSelect" name="roleEdit">
                                        <option value="author" {{ old('roleEdit') == 'author' ? 'selected' : '' }}>Author</option>
                                        <option value="admin" {{ old('roleEdit') == 'admin' ? 'selected' : '' }}>Admin</option>
                                    </select>
                                    @error('roleEdit','edit')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </fieldset>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="emailInput">Email</label>
                                    <input type="email" id="emailInput" class="form-control @error('emailEdit','edit') is-invalid @enderror" name="emailEdit" placeholder="Masukkan email" value="{{ old('emailEdit') }}">
                                    @error('emailEdit','edit')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="passwordInput">Password</label>
                                    <input type="password" id="passwordInput" class="form-control @error('passwordEdit','edit') is-invalid @enderror" name="passwordEdit" placeholder="Masukkan password">
                                    @error('passwordEdit','edit')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="passwordInputConfirmation">Konfirmasi Password</label>
                                    <input type="password" id="passwordInputConfirmation" class="form-control" name="password_confirmation" placeholder="Masukkan ulang password">
                                </div>
                            </div>
                        </div>
                    </div>
                
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
                <button type="reset" class="btn btn-light-secondary mr-1 mb-1">Reset</button>
            </div>
        </form>
        </div>
    </div>
</div>
<div class="modal fade" id="hapusUserModal" tabindex="-1" aria-labelledby="hapusUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form id="formHapus" method="POST">
            @method('DELETE')
            @csrf
            <div class="modal-body">
                <div class="text-center">
                    <i class="bi bi-exclamation-circle-fill fs-1 text-danger display-4"></i>
                    <h3>
                        Apakah anda yakin ingin menghapus user berikut?
                    </h3>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="submit" class="btn btn-danger">Hapus</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div>
        </form>
      </div>
    </div>
</div>
  
  
@endsection

@section('js-addOn')
{{-- <script src="{{ asset('vendor/simple-datatables/simple-datatables.js') }}"></script> --}}
<script src="{{ asset('admin/assets/js/pages/media.js') }}"></script>
<script src="{{ asset('vendor/bootstrap-5.3.3/js/bootstrap.min.js') }}"></script>

<script>
    @if ($errors->edit->any())
    $('#editUserModal').modal('show')
    @endif

    @if ($errors->tambah->any())
    $('#tambahUserModal').modal('show')
    @endif
</script>
@endsection