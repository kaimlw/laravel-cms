@extends('admin.template.template')

@section('title', 'Desa')

@section('css-addOn')
<link rel="stylesheet" href="{{ asset('vendor/simple-datatables/style.css') }}">
<link rel="stylesheet" href="{{ asset('admin/assets/css/menu.css') }}">
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
            <h3>Menu</h3>
            <p class="text-subtitle text-muted">Halaman untuk mengatur struktur menu pada halaman utama.</p>
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
    <div class="row">
        <div class="col-md-5 mb-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="m-0">Tambah Menu</h5>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" id="addMenuTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="page-tab" data-toggle="tab" href="#page" role="tab" aria-controls="page" aria-selected="false">Page</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="post-tab" data-toggle="tab" href="#post" role="tab" aria-controls="post" aria-selected="false">Post</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="kategori-tab" data-toggle="tab" href="#kategori" role="tab" aria-controls="kategori" aria-selected="false">Kategori</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="custom-link-tab" data-toggle="tab" href="#custom-link" role="tab" aria-controls="custom-link" aria-selected="false">Custom Link</a>
                        </li>
                    </ul>

                    <div class="tab-content mt-3" id="addMenuTabContent">
                        <div class="tab-pane fade active show" id="page" role="tabpanel" aria-labelledby="page-tab">
                            <form action="{{ route('dashboard.menu.store') }}" id="formPage" method="POST">
                                @csrf
                                <input type="hidden" name="menuItemType" value="page">
                                <input type="hidden" name="menuItemTitle" id="pageMenuTitle" value="">
                                <input type="hidden" name="menuItemSlug" id="pageMenuSlug" value="">
                                <ul class="list-group border rounded p-2">
                                    @foreach ($pages as $page)
                                    <li class="list-group-item">
                                        <div class="form-check">
                                            <input class="form-check-input page-radio" type="radio" name="pageSelect" data-title="{{ $page->title }}" data-slug="{{ $page->slug }}" id="pageSelect{{ $page->id }}">
                                            <label class="form-check-label" for="pageSelect{{ $page->id }}">
                                                {{ $page->title }}
                                            </label>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                                <fieldset class="form-group mt-2">
                                    <label for="pageParentSelect">Menu Induk</label>
                                    <select class="form-select" name="parent" id="pageParentSelect">
                                        <option value="">Tidak Ada</option>
                                        @foreach ($menu as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </fieldset>
                                <div class="form-group d-none" id="pageChildrenGroupInput">
                                    <label for="childGroupInput">Group Sub Menu</label>
                                    <input type="text" class="form-control" id="pagechildGroupInput" name="menuChildGroup" placeholder="Masukkan group menu">
                                </div>
                                <div class="form-group">
                                    <label for="labelInput">Urutan Menu</label>
                                    <input type="number" class="form-control" id="labelInput" name="menuOrder" placeholder="Masukkan urutan menu" value="1">
                                </div>
                                <div class="text-right mt-2">
                                    <button class="btn btn-primary" type="submit">Tambah</button>
                                    <button class="btn btn-secondary" type="reset">Reset</button>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="post" role="tabpanel" aria-labelledby="post-tab">
                            <form action="{{ route('dashboard.menu.store') }}" id="formPost" method="POST">
                                @csrf
                                <input type="hidden" name="menuItemType" value="post">
                                <input type="hidden" name="menuItemTitle" id="postMenuTitle" value="">
                                <input type="hidden" name="menuItemSlug" id="postMenuSlug" value="">

                                <ul class="list-group border rounded p-2">
                                    @foreach ($posts as $post)
                                    <li class="list-group-item">
                                        <div class="form-check">
                                            <input class="form-check-input post-radio" type="radio" name="postSelect" data-title="{{ $post->title }}" data-slug="{{ $post->slug }}" id="postSelect{{ $post->id }}">
                                            <label class="form-check-label" for="postSelect{{ $post->id }}">
                                                {{ $post->title }}
                                            </label>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                                <fieldset class="form-group mt-2">
                                    <label for="postParentSelect">Menu Induk</label>
                                    <select class="form-select" name="parent" id="postParentSelect">
                                        <option value="">Tidak Ada</option>
                                        @foreach ($menu as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </fieldset>
                                <div class="form-group d-none" id="postChildrenGroupInput">
                                    <label for="childGroupInput">Group Sub Menu</label>
                                    <input type="text" class="form-control" id="postchildGroupInput" name="menuChildGroup" placeholder="Masukkan group menu">
                                </div>
                                <div class="form-group">
                                    <label for="labelInput">Urutan Menu</label>
                                    <input type="number" class="form-control" id="labelInput" name="menuOrder" placeholder="Masukkan urutan menu" value="1">
                                </div>
                                <div class="text-right mt-2">
                                    <button class="btn btn-primary" type="submit">Tambah</button>
                                    <button class="btn btn-secondary" type="reset">Reset</button>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="kategori" role="tabpanel" aria-labelledby="kategori-tab">
                            <form action="{{ route('dashboard.menu.store') }}" id='formCategory' method="POST">
                                @csrf
                                <input type="hidden" name="menuItemType" value="category">
                                <input type="hidden" name="menuItemTitle" id="categoryMenuTitle" value="">
                                <input type="hidden" name="menuItemSlug" id="categoryMenuSlug" value="">

                                <ul class="list-group border rounded p-2">
                                    @foreach ($categories as $category)
                                    <li class="list-group-item">
                                        <div class="form-check">
                                            <input class="form-check-input category-radio" type="radio" name="categorySelect" data-title="{{ $category->name }}" data-slug="{{ $category->slug }}" id="categorySelect{{ $category->id }}">
                                            <label class="form-check-label" for="categorySelect{{ $category->id }}">
                                                {{ $category->name }}
                                            </label>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                                <fieldset class="form-group mt-2">
                                    <label for="categoryParentSelect">Menu Induk</label>
                                    <select class="form-select" name="parent" id="categoryParentSelect">
                                        <option value="">Tidak Ada</option>
                                        @foreach ($menu as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </fieldset>
                                <div class="form-group d-none" id="categoryChildrenGroupInput">
                                    <label for="categoryChildGroupInput">Group Sub Menu</label>
                                    <input type="text" class="form-control" id="categoryChildGroupInput" name="menuChildGroup" placeholder="Masukkan group menu">
                                </div>
                                <div class="form-group">
                                    <label for="labelInput">Urutan Menu</label>
                                    <input type="number" class="form-control" id="labelInput" name="menuOrder" placeholder="Masukkan urutan menu" value="1">
                                </div>
                                <div class="text-right mt-2">
                                    <button class="btn btn-primary" type="submit">Tambah</button>
                                    <button class="btn btn-secondary" type="reset">Reset</button>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="custom-link" role="tabpanel" aria-labelledby="custom-link-tab">
                            <form action="{{ route('dashboard.menu.store') }}" id="formCustom" method="POST">
                                @csrf
                                <input type="hidden" name="menuItemType" value="custom">
                                <div class="form-group">
                                    <label for="labelInput">Label</label>
                                    <input type="text" class="form-control" id="labelInput" name="menuItemTitle" placeholder="Masukkan label menu...">
                                </div>
                                <div class="form-group">
                                    <label for="linkInput">Link</label>
                                    <input type="text" class="form-control" id="linkInput" name="menuItemLink" placeholder="Masukkan link menu...">
                                </div>
                                <fieldset class="form-group mt-2">
                                    <label for="customParentSelect">Menu Induk</label>
                                    <select class="form-select" id="customParentSelect" name="parent">
                                        <option value="">Tidak Ada</option>
                                        @foreach ($menu as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </fieldset>
                                <div class="form-group d-none" id="customChildrenGroupInput">
                                    <label for="customChildGroupInput">Group Sub Menu</label>
                                    <input type="text" class="form-control" id="customChildGroupInput" name="menuChildGroup" placeholder="Masukkan group menu">
                                </div>
                                <div class="form-group">
                                    <label for="orderInput">Urutan Menu</label>
                                    <input type="number" class="form-control" id="orderInput" name="menuOrder" placeholder="Masukkan urutan menu" value="1">
                                </div>
                                <div class="text-right">
                                    <button class="btn btn-primary" type="submit">Tambah</button>
                                    <button class="btn btn-secondary" type="reset">Reset</button>
                                </div>
                            </form>
                        </div>
                    </div>                      
                </div>
            </div>
        </div>
        <div class="col-md-7 mb-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="m-0">Struktur Menu</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        @foreach ($menuInArray as $parent => $child)
                            <li class="parent-item menu-list-item">
                                {{ $parent }}
                                <div class="">
                                    <button class="btn btn-sm btn-warning" onclick="openEditModal({{ $child[0] }})"><i class="bi bi-pencil-square"></i></button>
                                    <button class="btn btn-sm btn-danger" onclick="openHapusModal({{ $child[0] }})"><i class="bi bi-x"></i></button>
                                </div>
                            </li>
                            @if (count($child[1]) != 0)
                                @foreach ($child[1] as $parent2 => $child2)
                                    <ul class="child-ul">
                                        <li class="child-group-label">{{ $parent2 }}</li>
                                        <ul class="child-item-ul">
                                            @foreach ($child2 as $item)
                                                <li class="child-item menu-list-item">
                                                    {{ $item[1] }}
                                                    <div class="">
                                                        <button class="btn btn-sm btn-warning" onclick="openEditModal({{ $item[0] }})"><i class="bi bi-pencil-square"></i></button>
                                                        <button class="btn btn-sm btn-danger" onclick="openHapusModal({{ $item[0] }})"><i class="bi bi-x"></i></button>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </ul>
                                @endforeach
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="editMenuItemModal" tabindex="-1" aria-labelledby="editMenuItemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editMenuItemModalLabel">Edit Menu</h5>
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
                                    <label for="labelEditInput">Label Menu</label>
                                    <input type="text" id="labelEditInput" class="form-control @error('menuItemTitle','edit') is-invalid @enderror" name="menuItemTitle" placeholder="Masukkan label menu..." value="{{ old('menuItemTitle') }}">
                                    @error('menuItemTitle','edit')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="linkEditInput">Link</label>
                                    <input type="text" class="form-control" id="linkEditInput" name="menuItemLink" placeholder="Masukkan link menu...">
                                </div>
                            </div>
                            <div class="col-12">
                                <fieldset class="form-group mt-2">
                                    <label for="parentEditSelect">Menu Induk</label>
                                    <select class="form-select" id="parentEditSelect" name="parent">
                                        <option value="">Tidak Ada</option>
                                        @foreach ($menu as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </fieldset>
                            </div>
                            <div class="col-12">
                                <div class="form-group d-none" id="editChildrenGroupInput">
                                    <label for="childGroupEditInput">Group Sub Menu</label>
                                    <input type="text" class="form-control" id="childGroupEditInput" name="menuChildGroup" placeholder="Masukkan group menu">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="menuOrderEditInput">Urutan Menu</label>
                                    <input type="text" id="menuOrderEditInput" class="form-control @error('menuOrder','edit') is-invalid @enderror" name="menuOrder" placeholder="Masukkan urutan menu" value="{{ old('menuOrder') }}">
                                    @error('menuOrder','edit')
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
                        Apakah anda yakin ingin menghapus menu berikut?
                    </h3>
                    <h5>Sub menu didalamnya juga akan terhapus!</h5>
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
<script src="{{ asset('admin/assets/js/pages/menu.js') }}"></script>
@endsection