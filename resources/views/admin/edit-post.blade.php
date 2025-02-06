@extends('admin.template.create-post-template')

@section('title', $post->title)

@section('css-addOn')
<link rel="stylesheet" href="{{ asset('assets/vendor/simple-datatables/style.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-5.3.3/css/bootstrap.min.css') }}">
<style>
    .ck-editor__editable_inline{
        height: 70vh;
    }
    .kategori-container{
        height: 150px;
        padding: 0.5em;
        border: 1px solid lightgray;
        border-radius: 10px;
        overflow: scroll;
    }

    #mediaBrowserModal .media-wrapper{
        list-style: none;
        display: flex;
        align-items: flex-start;
        height: 60vh;
        flex-wrap: wrap;
        gap: 0.5em;
        overflow: scroll;
    }

    #mediaBrowserModal .media-wrapper .media-item{
        position: relative;
        width: 125px;
        height: 125px;
        cursor: pointer;
        padding: 0.15em
    }
    
    #mediaBrowserModal .media-wrapper .media-item.selected{
        border: 3px solid blue;
    }
    
    #mediaBrowserModal .media-wrapper .media-item .thumbnail{
        border: 1px solid gray;
        position: absolute;
        right: 0.15em;
        left: 0.15em;
        top: 0.15em;
        bottom: 0.15em;
        background: url("{{ asset('assets/img/png_bg.jpg') }}");
        background-size: cover;
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

<section class="section">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="">
            <button class="btn btn-success btn-sm" disabled id="btnSave"><i class="bi bi-floppy-fill"></i> Save</button>

            @if ($post->status != 'publish')
            <button class="btn btn-primary btn-sm" id="btnPublish"><i class="bi bi-globe2"></i> Publish</button>
            @endif
        </div>
        <button class="btn btn-success btn-sm" id="btnInsertImage"><i class="bi bi-images"></i> Insert Image From Media</button>
    </div>
    <div id="editor">
        {!! $post->content !!}
    </div>
</section> 

{{-- Media Browser Modal --}}
<div class="modal fade" id="mediaBrowserModal" tabindex="-1" aria-labelledby="mediaBrowserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="mediaBrowserModalLabel">Pilih Media</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="media-wrapper" id="media-wrapper">
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" disabled id="btnMediaPilih">Pilih</button>
            </div>
        </div>
    </div>
</div>
  
@endsection

@section('js-addOn')
<script>
    const site_url = "{{ $web->site_url }}"
</script>
<script src="{{ asset('assets/vendor/bootstrap-5.3.3/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/admin/assets/js/pages/edit-post.js') }}" type="module"></script>
@endsection