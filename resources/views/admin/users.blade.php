@extends('admin.template.template')

@section('title', 'Users')

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
            <h3>Pengguna</h3>
            <p class="text-subtitle text-muted">Halaman untuk menambah, mengedit, dan menghapus pengguna</a>.</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class='breadcrumb-header'>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Users</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<section class="section">
    <div class="card">
        <div class="card-header text-right">
            <button class="btn btn-primary" data-toggle="modal" data-target="#tambahUserModal">Tambah Pengguna</button>
        </div>
        <div class="card-body">
            <table class='table table-striped' id="table1">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Display Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->display_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->roles }}</td>
                        <td>
                            <button class="btn btn-sm btn-warning" onclick="openEditModal('{{ base64_encode(encrypt($user->id)) }}')">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            @if (auth()->user()->id != $user->id)
                            <button class="btn btn-sm btn-danger" onclick="openHapusModal('{{ base64_encode(encrypt($user->id)) }}')">
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
<div class="modal fade" id="tambahUserModal" tabindex="-1" aria-labelledby="tambahUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahUserModalLabel">Tambah User Baru</h5>
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
                                    <label for="usernameInput">Username</label>
                                    <input type="text" id="usernameInput" class="form-control @error('username','tambah') is-invalid @enderror" name="username" placeholder="Masukkan nama pengguna" value="{{ old('username') }}">
                                    @error('username','tambah')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="displayNameInput">Display Name</label>
                                    <input type="text" id="displayNameInput" class="form-control @error('displayName','tambah') is-invalid @enderror" name="displayName" placeholder="Masukkan nama yang akan ditampilkan" value="{{ old('displayName') }}">
                                    @error('displayName','tambah')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <fieldset class="form-group">
                                    <label for="roleSelect">Role Pengguna</label>
                                    <select class="form-select @error('role','tambah') is-invalid @enderror" id="roleSelect" name="role">
                                        @if (auth()->user()->desa_id == 0)
                                        <option value="super_admin" selected>Super Admin</option>
                                        @else
                                        <option value="web_admin" selected>Web Admin</option>
                                        @endif                                    
                                    </select>
                                    @error('role','tambah')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </fieldset>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="emailInput">Email</label>
                                    <input type="email" id="emailInput" class="form-control @error('email','tambah') is-invalid @enderror" name="email" placeholder="Masukkan email" value="{{ old('email') }}">
                                    @error('email','tambah')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="passwordInput">Password</label>
                                    <input type="password" id="passwordInput" class="form-control @error('password','tambah') is-invalid @enderror" name="password" placeholder="Masukkan password">
                                    @error('password','tambah')
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

{{-- Edit Modal --}}
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
                <form class="form form-vertical" id="formEdit" method="POST" action="{{ route('admin.user.update', ['id' => old('user') != null ? old('user') : 0 ])  }}">
                    @method('PUT')
                    @csrf
                    <input type="hidden" name="user" id="userEdit" value="{{ old('user') }}">
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
                                        @if (auth()->user()->web_id == 0)
                                        <option value="super_admin" selected>Super Admin</option>
                                        @else
                                        <option value="web_admin" selected>Web Admin</option>
                                        @endif
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
<script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
<script src="{{ asset('assets/admin/assets/js/pages/users.js') }}"></script>


<script>
    @if ($errors->edit->any())
    $('#editUserModal').modal('show')
    @endif

    @if ($errors->tambah->any())
    $('#tambahUserModal').modal('show')
    @endif
</script>
@endsection