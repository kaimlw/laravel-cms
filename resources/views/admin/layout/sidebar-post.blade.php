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
                <label for="bannerPost">Banner Page/Post</label>
                <div class="form-file w-75">
                    <form action="" id="formBannerPost" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="bannerPost" name="bannerPost">
                        </div>
                        <div class="mt-1 text-center">
                            <button class="btn btn-sm btn-primary">Upload</button>
                        </div>
                    </form>
                </div>
                @if ($post->url_post_image)
                <h6 class="mt-2">Preview Banner Post:</h6>
                <img src="{{ $post->url_post_thumbnail }}" style="height:100px; width:100%" loading="lazy">
                @endif
            </div>
        </div>

        <div class="sidebar-footer">
            <button class="btn btn-success" disabled id="btnSave">Save</button>

            @if ($post->status != 'publish')
            <button class="btn btn-primary" id="btnPublish">Publish</button>
            @endif
        </div>
    </div>
    <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
</div>
