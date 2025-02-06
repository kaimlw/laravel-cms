// Menambahkan click event listener ke media card untuk memunculkan modal
document.querySelectorAll('.media-card').forEach(el => {
    let id = el.getAttribute('data-media-id')
    el.addEventListener('click', function(){openMediaDetailModal(id)})
})

// Preview media
let detail_media = document.querySelector('#detail_media')
let detail_tgl_upload = document.querySelector('#detail_tgl_upload')
let detail_user_uploader = document.querySelector('#detail_user_uploader')
let detail_nama_file = document.querySelector('#detail_nama_file')
let detail_tipe_file = document.querySelector('#detail_tipe_file')
let detail_ukuran_file = document.querySelector('#detail_ukuran_file')
let detail_dimensi_img = document.querySelector('#detail_dimensi_img')
let btn_hapus_media = document.querySelector('#btn_hapus_media')
let btn_download_media = document.querySelector('#btn_download_media')

// Load Media
const btn_load_media = document.querySelector("#btn_load")
const spinner_load_media = document.querySelector("#load_spinner")
if (btn_load_media) {
    btn_load_media.addEventListener("click", function(){loadMedia()})
}


// FUNCTION
function openMediaDetailModal(id){
    fetch(`${site_url}/cms-admin/media/${id}`,{
        method: 'GET',
        credentials: 'same-origin'
    })
    .then((res)=>res.json())
    .then((data)=>{        
        $('#mediaDetailModal').modal('show')

        // Jika mimetype adalah image
        if (data.media_meta.mime_type.includes('image')) {
            // Menampilkan gambar
            detail_media.innerHTML = `
                <img src="${site_url}/${data.media_meta.filepath.original}" class="img-fluid" style="max-height: 500px">
            `
            // Menampilkan detail dimensi
            detail_dimensi_img.innerHTML = `<b>Dimensi Gambar:</b> ${data.media_meta.width} &times ${data.media_meta.height} `
            detail_dimensi_img.classList.remove('d-none');
        } else {
            // Menampilkan icon file
            detail_media.innerHTML = `
            <i class="bi bi-file-earmark-fill fs-1 d-block"></i>
            `
            // Menyembunyikan detail dimensi
            detail_dimensi_img.classList.add('d-none');
            detail_dimensi_img.innerHTML = `<b>Dimensi Gambar:</b>`
        }

        let d = new Date(data.created_at)
        detail_tgl_upload.innerHTML = `<b>Tanggal Unggah:</b> ${d.getDate()} ${d.toLocaleString('default', {month: 'long'})} ${d.getFullYear()}`
        detail_user_uploader.innerHTML = `<b>Diunggah Oleh:</b> ${data.author}`
        detail_nama_file.innerHTML = `<b>Nama File:</b> ${data.filename}`
        detail_tipe_file.innerHTML = `<b>Tipe File:</b> ${data.media_meta.mime_type}`
        detail_ukuran_file.innerHTML = `<b>Ukuran File:</b> ${formatBytes(data.media_meta.size, 0)} `

        btn_hapus_media.addEventListener('click', function(){openHapusModal(id)})
        btn_download_media.setAttribute('href', site_url + "/" + data.media_meta.filepath.original)

        $('.invalid-feedback').remove();
        $('.is-invalid').removeClass('is-invalid')
    })
    .catch((err)=>{
        let alert = `
            <div class="alert alert-danger alert-dismissible show fade">
                Terjadi kesalahan! Coba beberapa saat lagi.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        `
        $('.main-content').prepend(alert)
    })
}

function openHapusModal(id){
    $('#hapusMediaModal').modal('show')
    $('#formHapus').attr('action',`${site_url}/cms-admin/media/${id}`)
}

function formatBytes(bytes, decimals = 2) {
    if (!+bytes) return '0 Bytes'

    const k = 1024
    const dm = decimals < 0 ? 0 : decimals
    const sizes = ['Bytes', 'KB', 'MB']

    const i = Math.floor(Math.log(bytes) / Math.log(k))

    return `${parseFloat((bytes / Math.pow(k, i)).toFixed(dm))} ${sizes[i]}`
}

function loadMedia() {
    btn_load_media.classList.add('d-none')
    spinner_load_media.classList.remove('d-none')

    const URLParam = new URLSearchParams()
    const file_type = URLParam.get('file_type')
    const file_date = URLParam.get('file_date')
    const file_search = URLParam.get('file_search')

    fetch(`${site_url}/cms-admin/media/load`,{
        method: 'POST',
        credentials: 'same-origin',
        headers: {
            'Accept':'application/json',
            "Content-type": "application/json",
            "X-CSRF-TOKEN" : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            file_type: file_type,
            file_date: file_date,
            file_search: file_search,
            offset: displayed_media,
        })
    })
    .then((res)=>res.json())
    .then(data => {
        data.forEach(item => {
            let mime_type = item.media_meta.mime_type;
            let filename = item.filename;
            let filepath = item.media_meta.filepath.thumbnail;
            let element = `
                <div class="col-lg-2 col-sm-3 col-5 p-0">
                    <div class="card m-0 me-1 mb-1 media-card" data-media-id="${item.id}" data-bs-toggle="modal" data-bs-target="#mediaDetailModal">
                        <div class="card-body p-1 text-center h-100 w-100">
                            <div class="overflow-hidden h-100 w-100">`
            
            if (mime_type.indexOf("image") === 0) {
                element += `<img src="${site_url}/${filepath}" class="img-fluid">`
            } else {
                element += `
                    <i class="bi bi-file-earmark-fill fs-1"></i>
                    <div class="media-filename">
                        ${(filename.length > 30) ? filename.substr(0,20) + " ... " + filename.substr(filename.length-5, filename.length) : filename}
                    </div>
                `
            }
            element += `
                            </div>
                        </div>
                    </div>
                </div>
            `
            document.querySelector("#media_row").insertAdjacentHTML('beforeend', element)
        });

        document.querySelectorAll('.media-card').forEach(el => {
            let id = el.getAttribute('data-media-id')
            el.addEventListener('click', function(){openMediaDetailModal(id)})
        })

        displayed_media += data.length
        document.querySelector('#displayed_media').innerHTML = displayed_media
        spinner_load_media.classList.add('d-none')
        if (displayed_media < media_count) {
            btn_load_media.classList.remove('d-none')
        }
    })
    .catch(err => {
        console.log(err);
        let alert = `
            <div class="alert alert-danger alert-dismissible show fade">
                Terjadi kesalahan! Coba beberapa saat lagi.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        `
        $('.main-content').prepend(alert)
    })
}