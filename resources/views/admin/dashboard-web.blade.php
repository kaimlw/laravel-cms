@extends('admin.template.template')

@section('title', 'Dashboard Admin')

@section('css-addOn')
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
    <div class="row mb-2">
        <div class="col-12 col-md-3">
            <div class="card card-statistic">
                <div class="card-body px-3 py-3">
                    <div class="d-flex flex-column">
                        <div class='d-flex justify-content-between'>
                            <h3 class='card-title'>POST</h3>
                            <div class="card-right d-flex align-items-center">
                                <p>{{ $post_count[0]->total_posts }}</p>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-3">
                            <div class="text-white text-center">
                                <h5 class="m-0 text-white">Draft</h5>
                                <p class="h4 text-white">{{ $post_count[0]->draft }}</p>
                            </div>
                            <div class="text-white text-center">
                                <h5 class="m-0 text-white">Publish</h5>
                                <p class="h4 text-white">{{ $post_count[0]->publish }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="card card-statistic">
                <div class="card-body px-3 py-3">
                    <div class="d-flex flex-column">
                        <div class='d-flex justify-content-between'>
                            <h3 class='card-title'>PAGE</h3>
                            <div class="card-right d-flex align-items-center">
                                <p>{{ $page_count[0]->total_pages }}</p>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-3">
                            <div class="text-white text-center">
                                <h5 class="m-0 text-white">Draft</h5>
                                <p class="h4 text-white">{{ $page_count[0]->draft }}</p>
                            </div>
                            <div class="text-white text-center">
                                <h5 class="m-0 text-white">Publish</h5>
                                <p class="h4 text-white">{{ $page_count[0]->publish }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="card card-statistic">
                <div class="card-body p-0">
                    <div class="d-flex flex-column">
                        <div class='px-3 py-3 d-flex justify-content-between'>
                            <h3 class='card-title'>CATEGORY</h3>
                            <div class="card-right d-flex align-items-center">
                                <p>{{ $category_count }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="card card-statistic">
                <div class="card-body p-0">
                    <div class="d-flex flex-column">
                        <div class='px-3 py-3 d-flex justify-content-between'>
                            <h3 class='card-title'>MEDIA</h3>
                            <div class="card-right d-flex align-items-center">
                                <p>{{ $media_count }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</section>
@endsection