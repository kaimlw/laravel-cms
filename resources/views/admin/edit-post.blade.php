@extends('admin.template.create-post-template')

@section('title', $post->title)

@section('css-addOn')
<link rel="stylesheet" href="{{ asset('assets/vendor/simple-datatables/style.css') }}">
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
    <div id="editor">
        {!! $post->content !!}
    </div>
</section>  
@endsection

@section('js-addOn')
<script>
    let post_id = {{ $post->id }}
    let post_type = '{{ $post->type }}'
</script>
<script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
<script src="{{ asset('assets/admin/assets/js/pages/edit-post.js') }}"></script>
@endsection