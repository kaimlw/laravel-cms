// Menambahkan click event listener ke media card untuk memunculkan modal
document.querySelectorAll('.media-card').forEach(el => {
    let id = el.getAttribute('data-media-id')
    el.addEventListener('click', function(){openMediaDetailModal(id)})
})

// FORM EDIT
let detail_media = document.querySelector('#detail_media')
let detail_tgl_upload = document.querySelector('#detail_tgl_upload')
let detail_user_uploader = document.querySelector('#detail_user_uploader')
let detail_nama_file = document.querySelector('#detail_nama_file')
let detail_tipe_file = document.querySelector('#detail_tipe_file')
let detail_ukuran_file = document.querySelector('#detail_ukuran_file')
let detail_dimensi_img = document.querySelector('#detail_dimensi_img')
let btn_hapus_media = document.querySelector('#btn_hapus_media')
let btn_download_media = document.querySelector('#btn_download_media')

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