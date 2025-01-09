@extends('admin.template.template')

@section('title', 'Web')

@section('css-addOn')
<link rel="stylesheet" href="{{ asset('assets/vendor/simple-datatables/style.css') }}">
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
            <h3>Web</h3>
            <p class="text-subtitle text-muted">Halaman untuk menambah, mengedit, dan menghapus Web</a>.</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class='breadcrumb-header'>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Web</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<section class="section">
    <div class="card">
        <div class="card-header text-right">
            <button class="btn btn-primary" data-toggle="modal" data-target="#tambahWebModal">Tambah Web</button>
        </div>
        <div class="card-body">
            <table class='table table-striped' id="table1">
                <thead>
                    <tr>
                        <th>Nama Web</th>
                        <th>Subdomain</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($webs as $item)
                        <tr>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->subdomain }}</td>
                            <td>
                                <button class="btn btn-sm btn-warning" onclick="openEditModal('{{ base64_encode(encrypt($item->id)) }}')">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="openHapusModal('{{ base64_encode(encrypt($item->id)) }}')">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

{{-- MODAL TAMBAH --}}
<div class="modal fade" id="tambahWebModal" tabindex="-1" aria-labelledby="tambahWebModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahWebModalLabel">Tambah Web Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form form-vertical" method="POST" action="">
                    @csrf
                    <div class="form-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="namaWebInput">Nama Web/Instansi</label>
                                    <input type="text" id="namaWebInput" class="form-control @error('nama_web','tambah') is-invalid @enderror" name="nama_web" placeholder="Masukkan nama Web" value="{{ old('nama_web') }}">
                                    @error('nama_web','tambah')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="subDomainInput">Sub Domain</label>
                                    <input type="text" id="subDomainInput" class="form-control @error('sub_domain','tambah') is-invalid @enderror" name="sub_domain" placeholder="Masukkan sub domain" value="{{ old('sub_domain') }}">
                                    @error('sub_domain','tambah')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
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

{{-- MODAL EDIT --}}
<div class="modal fade" id="editWebModal" tabindex="-1" aria-labelledby="editWebModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editWebModalLabel">Edit Pengguna</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form form-vertical" id="formEdit" method="POST" action="{{ route('admin.web.update', ['id' => old('web') ? old('web') : 0]) }}">
                    @method('PUT')
                    @csrf
                    <input type="hidden" id="webEdit" name="web" value="{{ old('web') }}">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="namaWebInput">Nama Web/Instansi</label>
                                    <input type="text" id="namaWebInput" class="form-control @error('nama_web','edit') is-invalid @enderror" name="nama_web" placeholder="Masukkan nama Web" value="{{ old('nama_web') }}">
                                    @error('nama_web','edit')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="subDomainInput">Sub Domain</label>
                                    <input type="text" id="subDomainInput" class="form-control @error('sub_domain','edit') is-invalid @enderror" name="sub_domain" placeholder="Masukkan sub domain" value="{{ old('sub_domain') }}">
                                    @error('sub_domain','edit')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
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

{{-- MODAL HAPUS --}}
<div class="modal fade" id="hapusWebModal" tabindex="-1" aria-labelledby="hapusWebModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form id="formHapus" method="POST">
            @method('DELETE')
            @csrf
            <div class="modal-body">
                <div class="text-center">
                    <i class="bi bi-exclamation-circle-fill fs-1 text-danger display-4"></i>
                    <h3>
                        Apakah anda yakin ingin menghapus web berikut?
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
<script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
<script src="{{ asset('assets/admin/assets/js/pages/web.js') }}"></script>


<script>
    @if ($errors->edit->any())
    $('#editWebModal').modal('show')
    @endif

    @if ($errors->tambah->any())
    $('#tambahWebModal').modal('show')
    @endif
</script>
@endsection