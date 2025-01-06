@extends('admin.template.template')

@section('title', 'Desa')

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
            <h3>Desa</h3>
            <p class="text-subtitle text-muted">Halaman untuk menambah, mengedit, dan menghapus desa</a>.</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class='breadcrumb-header'>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.main') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Desa</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<section class="section">
    <div class="card">
        <div class="card-header text-right">
            <button class="btn btn-primary" data-toggle="modal" data-target="#tambahDesaModal">Tambah Desa</button>
        </div>
        <div class="card-body">
            <table class='table table-striped' id="table1">
                <thead>
                    <tr>
                        <th>Nama Desa</th>
                        <th>Subdomain</th>
                        <th>Kode Desa</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($desa as $item)
                        <tr>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->subdomain }}</td>
                            <td>{{ $item->kode_desa }}</td>
                            <td>
                                <button class="btn btn-sm btn-warning" onclick="openEditModal({{ $item->id }})">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="openHapusModal({{ $item->id }})">
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

<div class="modal fade" id="tambahDesaModal" tabindex="-1" aria-labelledby="tambahDesaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahDesaModalLabel">Tambah Desa Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form form-vertical" method="POST" action="{{ route('dashboard.desa.store') }}">
                    @csrf
                    <div class="form-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="namaDesaInput">Nama Desa/Instansi</label>
                                    <input type="text" id="namaDesaInput" class="form-control @error('namaDesa','tambah') is-invalid @enderror" name="namaDesa" placeholder="Masukkan nama desa" value="{{ old('namaDesa') }}">
                                    @error('namaDesa','tambah')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="subDomainInput">Sub Domain</label>
                                    <input type="text" id="subDomainInput" class="form-control @error('subDomain','tambah') is-invalid @enderror" name="subDomain" placeholder="Masukkan sub domain" value="{{ old('subDomain') }}">
                                    @error('subDomain','tambah')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="kodeDesaInput">Kode Desa</label>
                                    <input type="text" id="kodeDesaInput" class="form-control @error('kodeDesa','tambah') is-invalid @enderror" name="kodeDesa" placeholder="Masukkan kode desa" value="{{ old('kodeDesa') }}">
                                    @error('kodeDesa','tambah')
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
<div class="modal fade" id="editDesaModal" tabindex="-1" aria-labelledby="editDesaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDesaModalLabel">Edit Pengguna</h5>
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
                                    <label for="namaDesaInput">Nama Desa/Instansi</label>
                                    <input type="text" id="namaDesaInput" class="form-control @error('namaDesa','edit') is-invalid @enderror" name="namaDesa" placeholder="Masukkan nama desa" value="{{ old('namaDesa') }}">
                                    @error('namaDesa','edit')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="subDomainInput">Sub Domain</label>
                                    <input type="text" id="subDomainInput" class="form-control @error('subDomain','edit') is-invalid @enderror" name="subDomain" placeholder="Masukkan sub domain" value="{{ old('subDomain') }}">
                                    @error('subDomain','edit')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="kodeDesaInput">Kode Desa</label>
                                    <input type="text" id="kodeDesaInput" class="form-control @error('kodeDesa','edit') is-invalid @enderror" name="kodeDesa" placeholder="Masukkan kodeDesa" value="{{ old('kodeDesa') }}">
                                    @error('kodeDesa','edit')
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
<div class="modal fade" id="hapusDesaModal" tabindex="-1" aria-labelledby="hapusDesaModalLabel" aria-hidden="true">
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
<script src="{{ asset('vendor/simple-datatables/simple-datatables.js') }}"></script>
<script src="{{ asset('admin/assets/js/pages/desa.js') }}"></script>


<script>
    @if ($errors->edit->any())
    $('#editDesaModal').modal('show')
    @endif

    @if ($errors->tambah->any())
    $('#tambahDesaModal').modal('show')
    @endif
</script>
@endsection