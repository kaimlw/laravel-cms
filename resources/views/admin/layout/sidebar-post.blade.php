<div class="sidebar-wrapper active">
    <div class="sidebar-header border-bottom">
        <a href="{{ route('admin.post') }}?type={{ $type }}" class="btn-back"> <i class="bi bi-chevron-left"></i></a>
    </div>
    <div class="sidebar-menu">
        <div class="menu-container">
            <input type="hidden" id="postId" value="{{ $post->id }}">
            <div class="form-group mb-3">
                <label for="judulInput">Judul Halaman</label>
                <input type="text" class="form-control" id="judulInput" placeholder="Masukkan judul..." value="{{ $post->title }}">
            </div>
            <fieldset class="form-group">
                <label for="authorSelect">Penulis</label>
                <select class="form-select" id="authorSelect" name="author">
                    @foreach ($authors as $a)
                        <option value="{{ $a->id }}" {{ $post->author == $a->id ? 'selected' : '' }}>{{ $a->display_name }}</option>
                    @endforeach
                </select>
            </fieldset>

            @if ($type == 'post')
            <div class="form-group">
                <label for="kategoriCheck">Kategori</label>
                <div class="kategori-container">
                    <ul class="list-unstyled kategori-list">
                        @foreach ($categories as $category)
                            <li>
                                <div class="form-check">
                                    <div class="checkbox">
                                        <input type="checkbox" id="{{ 'kategori'.$category->id }}" class="form-check-input kategori-check"  value="{{ $category->id }}" data-parent="{{ $category->parent }}" {{ $post_categories->contains($category->id) ? 'checked' : '' }}>
                                        <label for="{{ 'kategori'.$category->id }}">{{ $category->name }}</label>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

            <div class="form-group">
                <input type="file" class="custom-file-input" id="banner_post_input" name="bannerPost" style="display: none">
                <label for="bannerPost">Banner Page/Post</label>
                <div class="w-100 mb-3" id="banner_post_upload_progress_wrapper" style="display: none">
                    <h6>Upload Progress</h6>
                    <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="height: 10px">
                        <div class="progress-bar" style="width: 25%"></div>
                    </div>
                </div>
                <div id="banner_post_preview" class="text-center">
                    @if ($post->banner_post_path)
                    <img src="{{ asset($post->banner_post_path) }}" style="height:100px; width:100%" loading="lazy">
                    <button class="btn-danger btn btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#hapusBannerModal"><i class="bi bi-trash-fill"></i></button>
                    @else
                    <small class="d-block">Tidak ada banner post</small>
                    @endif
                </div>
                <div class="btn-group mt-3" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-sm btn-outline-primary" id="banner_post_media_btn"><i class="bi bi-images"></i> Buka Media Browser</button>
                    <button type="button" class="btn btn-sm btn-outline-primary" id="banner_post_upload_btn">Upload <i class="bi bi-upload"></i></button>
                </div>

            </div>
        </div>
    </div>
    <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
</div>

{{-- Hapus Banner Modal --}}
<div class="modal fade" id="hapusBannerModal" tabindex="-1" aria-labelledby="hapusBannerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-body">
            <div class="text-center">
                <i class="bi bi-exclamation-circle-fill fs-1 text-danger display-4"></i>
                <h3>
                    Apakah anda yakin ingin menghapus banner post?
                </h3>
            </div>
        </div>
        <div class="modal-footer justify-content-center">
            <button type="submit" class="btn btn-danger" id="banner_post_delete_submit">Hapus</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
    </div>
    </div>
</div>