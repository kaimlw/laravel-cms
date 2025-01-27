@extends('admin.template.template')

@section('title', 'Dashboard Admin')

@section('css-addOn')
<link rel="stylesheet" href="{{ asset('assets/vendor/simple-datatables/style.css') }}">
<style>
    .card-statistic{
        height: 100%;
    }
</style>
@endsection

@section('content')
<div class="page-title">
    <h3>Dashboard</h3>
    <p class="text-subtitle text-muted">Dashboard CMS Laravel</p>
</div>
<section class="section">
    <div class="row mb-3">
        <div class="col-12 col-md-3">
            <div class="card card-statistic">
                <div class="card-body px-3 py-3">
                    <div class="d-flex flex-column">
                        <div class='d-flex justify-content-between'>
                            <h3 class='card-title'>WEBS</h3>
                            <div class="card-right d-flex align-items-center">
                                <p>{{ $webs->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">DAFTAR WEB</h4>
                </div>
                <div class="card-body px-0 pb-0">
                    <div class="table-responsive">
                        <table class="table mb-0" id="table1">
                            <thead>
                                <tr>
                                    <th>Nama Web</th>
                                    <th>Subdomain</th>
                                    <th>Email</th>
                                    <th>No. Telepon</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($webs as $web)
                                <tr>
                                    <td>{{ $web->name }}</td>
                                    <td>{{ $web->subdomain }}</td>
                                    <td>{{ $web->email }}</td>
                                    <td>{{ $web->phone_number }}</td>
                                    <td>
                                        <a href="" class="btn btn-success"><i class="bi bi-eye-fill"></i> Lihat</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('js-addOn')
<script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
<script>
    let table1 = document.querySelector('#table1');
    let dataTable = new simpleDatatables.DataTable(table1);
</script>
@endsection