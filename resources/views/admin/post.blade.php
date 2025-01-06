@extends('admin.template.template')

@section('title', 'Posts')

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

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

<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Posts</h3>
            <p class="text-subtitle text-muted">Halaman untuk menambah, mengedit, dan menghapus post</a>.</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class='breadcrumb-header'>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.main') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Pages</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<section class="section">
    <div class="card">
        <div class="card-header text-right">
            {{-- <a href="{{ route('dashboard.post.create') }}?type=page" class="btn btn-primary">Buat Halaman Baru</a> --}}
            <button class="btn btn-primary" id="btnNewPage">Buat Halaman Baru</button>
        </div>
        <div class="card-body">
            <table class='table table-striped' id="table1">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Penulis</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($posts as $post)
                    <tr>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->postCategories }}</td>
                        <td>{{ $post->user->display_name }}</td>
                        <td>{{ $post->updated_at->format('d-m-Y') }}</td>
                        <td>{{ ucfirst($post->status) }}</td>
                        <td>
                            <a class="btn btn-sm btn-primary" href="{{ route('home.post',['slug'=>$post->slug]) }}"><i class="bi bi-eye-fill"></i></a>
                            <a href="{{ route('dashboard.post.edit',['id' => $post->id]) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></a>
                            <button class="btn btn-sm btn-danger" onclick="openHapusModal({{ $post->id }})"><i class="bi bi-trash-fill"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

<div class="modal fade" id="hapusPageModal" tabindex="-1" aria-labelledby="hapusUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form id="formHapus" method="POST">
            @method('DELETE')
            @csrf
            <div class="modal-body">
                <div class="text-center">
                    <i class="bi bi-exclamation-circle-fill fs-1 text-danger display-4"></i>
                    <h3>
                        Apakah anda yakin ingin menghapus page berikut?
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
<script src="{{ asset('admin/assets/js/pages/pages.js') }}"></script>

@endsection