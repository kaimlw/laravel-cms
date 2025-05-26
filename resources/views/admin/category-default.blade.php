@extends('admin.template.template')

@section('title', 'Default Categories')

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
            <h3>Default Categories</h3>
            <p class="text-subtitle text-muted">Halaman untuk menambah, mengedit, dan menghapus default categories</a>.</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class='breadcrumb-header'>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Default Categories</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<section class="section">
    <div class="card">
        <div class="card-header text-right">
            <button class="btn btn-primary" data-toggle="modal" data-target="#tambahCategoryModal" >Tambah Categories</button>
        </div>
        <div class="card-body">
            <table class='table table-striped' id="table1">
                <thead>
                    <tr>
                        <th>Kategori</th>
                        <th>Deskripsi</th>
                        <th>Slug</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->description }}</td>
                        <td>{{ $category->slug }}</td>
                        <td>
                            @if (!in_array($category->slug, ["uncategorized", "latest-news"]))
                            <button class="btn btn-sm btn-warning" onclick="openEditModal('{{ $category->id }}')">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="openHapusModal('{{ $category->id }}')">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

{{-- Insert Modal --}}
<div class="modal fade" id="tambahCategoryModal" tabindex="-1" aria-labelledby="tambahCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahCategoryModalLabel">Tambah Kategori Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form form-vertical" method="POST" action="" id="formTambah">
                    @csrf
                    <div class="form-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="nameInput">Nama Kategori</label>
                                    <input type="text" id="nameInput" class="form-control @error('name','tambah') is-invalid @enderror" name="name" placeholder="Masukkan nama kategori" value="{{ old('name') }}">
                                    @error('name','tambah')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="deskripsiInput" class="form-label">Deskripsi (Opsional)</label>
                                    <textarea class="form-control @error('deskripsi','tambah') is-invalid @enderror" id="deskripsiInput" name="deskripsi" rows="3" maxlength="400">{{ old('deskripsi') }}</textarea>
                                    @error('deskripsi','tambah')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <fieldset class="form-group">
                                    <label for="parentCategorySelect">Kategori Induk</label>
                                    <select class="form-select @error('parent_category','tambah') is-invalid @enderror" id="parentCategorySelect" name="parent_category">
                                        <option value="">Tidak Ada</option>
                                        @foreach ($categories as $category)
                                            @if ($category->slug != 'uncategorized')
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('parent_category','tambah')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </fieldset>
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

{{-- Edit Modal --}}
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCategoryModalLabel">Edit Kategori</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form form-vertical" id="formEdit" method="POST" action="{{ route('admin.default.category.update', ['id' => old('category') != null ? old('category') : 0 ])  }}">
                    @method('PUT')
                    @csrf
                    <input type="hidden" name="category" id="categoryEdit" value="{{ old('category') }}">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="nameInput">Nama Kategori</label>
                                    <input type="text" id="nameInput" class="form-control @error('name','edit') is-invalid @enderror" name="name" placeholder="Masukkan nama kategori" value="{{ old('name') }}">
                                    @error('name','edit')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="deskripsiInput" class="form-label">Deskripsi (Opsional)</label>
                                    <textarea class="form-control @error('deskripsi','edit') is-invalid @enderror" id="deskripsiInput" name="deskripsi" rows="3">{{ old('deskripsi') }}</textarea>
                                    @error('deskripsi','edit')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <fieldset class="form-group">
                                    <label for="parentCategorySelect">Kategori Induk</label>
                                    <select class="form-select @error('parentCategory','edit') is-invalid @enderror" id="parentCategorySelect" name="parentCategory">
                                        <option value="0">Tidak Ada</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('parentCategory','edit')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </fieldset>
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

<div class="modal fade" id="hapusCategoryModal" tabindex="-1" aria-labelledby="hapusPageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form id="formHapus" method="POST">
            @method('DELETE')
            @csrf
            <div class="modal-body">
                <div class="text-center">
                    <i class="bi bi-exclamation-circle-fill fs-1 text-danger display-4"></i>
                    <h3>
                        Apakah anda yakin ingin menghapus halaman berikut?
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
<script src="{{ asset('assets/admin/assets/js/pages/category-default.js') }}"></script>
<script>
    const site_url = "{{ $web->site_url ?? route('main') }}"
    @if ($errors->edit->any())
    $('#editCategoryModal').modal('show')
    @endif

    @if ($errors->tambah->any())
    $('#tambahCategoryModal').modal('show')
    @endif
</script>
@endsection