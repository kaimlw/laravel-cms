const postId = document.getElementById('postId').value
const judulInput = document.getElementById('judulInput');
const authorSelect = document.getElementById('authorSelect');
const btnSave = document.getElementById('btnSave');
const btnPublish = document.getElementById('btnPublish');

let checkedCategory
const kategoriChecks = document.querySelectorAll('.kategori-check');

// Media Browser
let target_media = null;
let selected_media = null;
const mediaBrowserModal = new bootstrap.Modal('#mediaBrowserModal')
const media_wrapper = document.querySelector('#media-wrapper')

// Insert image from media browser to text editor
document.querySelector('#btnInsertImage').addEventListener('click', function(){
    target_media = 'text-editor'
    openMediaBrowser()
})
document.querySelector('#btnMediaPilih').addEventListener('click', function(){
    if (selected_media == null) {
        return
    }

    if (target_media == 'text-editor') {
        insertImageFromMediaBrowser(selected_media)
    } else if ( target_media == 'banner-post') {
        setBannerFromMedia(selected_media)
    }

    target_media = null;
    mediaBrowserModal.hide()
})

// Menambahkan change event listener jika ada perubahan ceklis kategori
kategoriChecks.forEach(item =>{
    item.addEventListener('change',()=>{
        if (item.getAttribute('data-parent') != 0) {
            let parentId = item.getAttribute('data-parent')
            let parentElement = document.querySelector('#kategori'+parentId)
            if (item.checked && !parentElement.checked ) {
                parentElement.checked = true;
            }
        }
        checkSubKategoriCondition(item)
        checkedCategory = checkAndPushKategoriId()
    })
})

// Inisialisasi CKEditor
import {
    ClassicEditor,
    Autoformat,
    Bold,
    Italic,
    Underline,
    BlockQuote,
    SimpleUploadAdapter,
    CloudServices,
    CKBox,
    Essentials,
    Heading,
    Image,
    AutoImage,
    ImageInsert,
    ImageCaption,
    ImageResize,
    ImageStyle,
    ImageToolbar,
    ImageUpload,
    PictureEditing,
    Indent,
    IndentBlock,
    Link,
    List,
    MediaEmbed,
    Mention,
    Paragraph,
    PasteFromOffice,
    Table,
    TableColumnResize,
    TableToolbar,
    TextTransformation
    } from 'ckeditor5';

let editor;
ClassicEditor
    .create( document.querySelector( '#editor' ), {
        licenseKey: 'GPL',
        plugins: [ 
            Autoformat,
            BlockQuote,
            Bold,
            CloudServices,
            Essentials,
            Heading,
            Image,
            AutoImage,
            ImageInsert,
            ImageCaption,
            ImageResize,
            ImageStyle,
            ImageToolbar,
            ImageUpload,
            SimpleUploadAdapter,
            Indent,
            IndentBlock,
            Italic,
            Link,
            List,
            MediaEmbed,
            Mention,
            Paragraph,
            PasteFromOffice,
            PictureEditing,
            Table,
            TableColumnResize,
            TableToolbar,
            TextTransformation,
            Underline,
        ],
        toolbar: [
            'undo',
            'redo',
            '|',
            'heading',
            '|',
            'bold',
            'italic',
            'underline',
            '|',
            'link',
            'insertImage',
            'insertTable',
            'blockQuote',
            'mediaEmbed',
            '|',
            'bulletedList',
            'numberedList',
            '|',
            'outdent',
            'indent'
        ],
        image: {
            resizeOptions: [
                {
                    name: 'resizeImage:original',
                    label: 'Default image width',
                    value: null
                },
                {
                    name: 'resizeImage:50',
                    label: '50% page width',
                    value: '50'
                },
                {
                    name: 'resizeImage:75',
                    label: '75% page width',
                    value: '75'
                }
            ],
            toolbar: [
                'imageTextAlternative',
                'toggleImageCaption',
                '|',
                'imageStyle:inline',
                'imageStyle:wrapText',
                'imageStyle:breakText',
                '|',
                'resizeImage'
            ]
        },
        link: {
            addTargetToExternalLinks: true,
            defaultProtocol: 'https://'
        },
        table: {
            contentToolbar: [ 'tableColumn', 'tableRow', 'mergeTableCells' ]
        },
        simpleUpload: {
            uploadUrl: '/cms-admin/media/upload',

            // Enable the XMLHttpRequest.withCredentials property.
            withCredentials: true,

            // Headers sent along with the XMLHttpRequest to the upload server.
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                // Authorization: 'Bearer <JSON Web Token>'
            }
        }
    } )
    .then(newEditor => {
        editor=newEditor;
        editor.model.document.on( 'change:data', ( evt, data ) => {
            btnSave.removeAttribute('disabled')
        } );
    })
    .catch( error => {
        console.log( error );
    } );

// Menambahkan click event ke tombol Save untuk menyimpan perubahan
btnSave.addEventListener('click',function() {
    saveContentChanges(editor)
});

// Jika ada tombol Publish, menambahkan event click untuk mempublish post
if (btnPublish) {
    btnPublish.addEventListener('click',publishPost);
}

// Banner Post
// -- Mengubah banner post dari file upload
document.querySelector('#banner_post_upload_btn').addEventListener('click', function(){
    document.querySelector('#banner_post_input').click()
})
document.querySelector('#banner_post_input').addEventListener('change', function(){
    uploadMedia(document.querySelector('#banner_post_input').files[0]);
})

// -- Mengubah banner post dari media browser
document.querySelector('#banner_post_media_btn').addEventListener('click', function(){
    target_media = 'banner-post';
    openMediaBrowser();
})

// -- Menghapus banner post
const banner_post_delete_modal = new bootstrap.Modal('#hapusBannerModal');
document.querySelector('#banner_post_delete_submit').addEventListener('click', function(){deleteBanner()})

// Menambahkan change event ke semua input untuk mengaktifkan tombol save
addChangeListenerToActivateSave(judulInput)
addChangeListenerToActivateSave(authorSelect)
if (kategoriChecks) {    
    addChangeListenerToActivateSave(kategoriChecks)
}

// ----- FUNCTION
// Save Content Function
function saveContentChanges(editor){
    btnSave.setAttribute('disabled', true)
    fetch(`/cms-admin/post/${postId}`,{
        method: 'PUT',
        headers: {
            'Accept':'application/json',
            "Content-type": "application/json",
            'x-csrf-token': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        credentials: 'same-origin',
        body:
            JSON.stringify({
                title: judulInput.value,
                author: authorSelect.value,
                content: editor.getData(),
                categories : checkedCategory,
            })
    })
    .then((res)=>res.json())
    .then((data)=>{
        // Jika return data alert = danger, munculkan alert di halaman post
        if (data.alert == 'danger') {
            if (data.msg instanceof Array) {
                data.msg.forEach(item => {
                    let alert = `
                    <div class="alert alert-danger alert-dismissible show fade">
                        ${item.msg[0]} 
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    `
                    $('.main-content').prepend(alert)
                });
            } else{
                let alert = `
                <div class="alert alert-danger alert-dismissible show fade">
                    ${data.msg} 
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                `
                $('.main-content').prepend(alert)
            }
            return 
        }

        // Munculkan alert berhasil
        let alert = `
            <div class="alert alert-${data.alert} alert-dismissible show fade">
                ${data.msg}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        `
        $('.main-content').prepend(alert)
        btnSave.setAttribute('disabled',true)
    })
    .catch((err)=>{
        btnSave.removeAttribute('disabled')
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

// Publish Post Function
function publishPost(){
    btnPublish.setAttribute('disabled', true);
    fetch(`/cms-admin/post/${postId}/publish`,{
        method: 'PUT',
        credentials: 'same-origin',
        body: JSON.stringify({
            postStatus: 'publish' 
        }),
        headers: {
            "Content-type": "application/json",
            'x-csrf-token': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then((res)=>res.json())
    .then((data)=>{
        let alert = `
            <div class="alert alert-${data.alert} alert-dismissible show fade">
                ${data.msg}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        `
        $('.main-content').prepend(alert)
        btnPublish.style.display="none"
    })
    .catch((err)=>{
        btnPublish.removeAttribute('disabled');
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

function checkAndPushKategoriId() {
    let checkedCategories = []
    kategoriChecks.forEach(item => {
        if (item.checked == true) {
            checkedCategories.push(item.value)
        }
    })

    return checkedCategories
}

function checkSubKategoriCondition(parent) {
    let parentId = parent.value
    let subKategori = document.querySelectorAll(`.kategori-check[data-parent='${parentId}']`)
    
    if (subKategori.length > 0) {
        if (parent.checked == false) {
            subKategori.forEach(item => {
                item.checked = false;
            })
        }
    }
}

function addChangeListenerToActivateSave(element){   
    if (element.length > 1 || NodeList.prototype.isPrototypeOf(element)) {
        element.forEach(item => {
            item.addEventListener('change', ()=>{
                btnSave.removeAttribute('disabled')
            })
        })
    }else{
        element.addEventListener('change', () => {
            btnSave.removeAttribute('disabled')
        })
    }
}

function openMediaBrowser() {
    fetch(`/cms-admin/media/all`,{
        method: 'GET',
        headers: {
            'Accept':'application/json',
            "Content-type": "application/json",
        },
        credentials: 'same-origin',
    })
    .then(res => res.json())
    .then(data => {
        // Reset Media
        checkMediaSelected()
        media_wrapper.innerHTML ="";
        selected_media = null;
        $('.media-item').removeClass('selected');

        // Untuk setiap item data
        data.forEach(item => {
            // Jika mime_type media bukan gambar, lewati
            if (!item.media_meta.mime_type.includes("image/")) {
                return;
            }

            // Menambahkan elemen media ke wrapper
            let media_item_element = document.createElement('li')
            media_item_element.classList.add('media-item');
            media_item_element.setAttribute('data-id', item.id)
            media_item_element.innerHTML = `
                <div class="thumbnail">
                    <img src="/${item.media_meta.filepath.thumbnail}" alt="" class="img-fluid">
                </div>
            `
            media_wrapper.insertAdjacentElement('beforeend', media_item_element)

            // Menambahkan event click pada tiap media item
            media_item_element.addEventListener('click', function(){
                $('.media-item').removeClass('selected')
                selected_media = media_item_element.getAttribute('data-id')
                media_item_element.classList.add('selected')
                checkMediaSelected()
            })
        })

        mediaBrowserModal.show()
    })
}

function insertImageFromMediaBrowser(mediaId) {
    fetch(`/cms-admin/media/${mediaId}`,{
        method: 'GET',
        headers: {
            'Accept':'application/json',
            "Content-type": "application/json",
        },
        credentials: 'same-origin',
    })
    .then(res => res.json())
    .then(data => {
        editor.execute( 'insertImage', { source: "/" + data.media_meta.filepath.medium } );
    })
}

function checkMediaSelected() {
    if ($('.media-item').length > 0) {
        $('#btnMediaPilih').removeAttr('disabled');
    } else{
        $('#btnMediaPilih').attr('disabled');
    }
}

function setBannerFromMedia(mediaId) {
    fetch(`/cms-admin/post/${postId}/banner-media`,{
        method: 'POST',
        headers: {
            'Accept':'application/json',
            "Content-type": "application/json",
            'x-csrf-token': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            media_id: mediaId 
        }),
        credentials: 'same-origin',
    })
    .then(res => res.json())
    .then(data => {
        let element = `
            <img src="/${data.img_path}" style="height:100px; width:100%" loading="lazy">
            <button class="btn-danger btn btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#hapusBannerModal"><i class="bi bi-trash-fill"></i></button>
        `
        document.querySelector(`#banner_post_preview`).innerHTML = element;
        
        let alert = `
        <div class="alert alert-success alert-dismissible show fade">
            Banner post telah diperbarui!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        `
        $('.main-content').prepend(alert)
    })
    .catch(err => {
        let alert = `
            <div class="alert alert-danger alert-dismissible show fade">
                ${err.msg}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            `
            $('.main-content').prepend(alert)
    })
}

function uploadMedia(file) {
    if (file == null) {
        console.log('file null');
        return
    }

    const formData = new FormData();
    formData.append('upload', file);

    const xhr = new XMLHttpRequest()
    xhr.open('POST', `/cms-admin/post/${postId}/banner`, true)
    xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'))
    xhr.withCredentials = true
    xhr.upload.addEventListener('progress', (event) => {
        if (event.lengthComputable) {
            const percentComplete = (event.loaded / event.total) * 100;
            toggleBannerUploadProgress(percentComplete)
        }
    })
    xhr.onload = () => {
        toggleBannerUploadProgress(0)
        const data = JSON.parse(xhr.response)

        if (xhr.status == 200) {
            let element = `
                <img src="/${data.img_path}" style="height:100px; width:100%" loading="lazy">
                <button class="btn-danger btn btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#hapusBannerModal"><i class="bi bi-trash-fill"></i></button>
            `
            document.querySelector(`#banner_post_preview`).innerHTML = element;
            
            let alert = `
            <div class="alert alert-success alert-dismissible show fade">
                Banner post telah diperbarui!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            `
            $('.main-content').prepend(alert)
        } else {
            let alert = `
            <div class="alert alert-danger alert-dismissible show fade">
                ${data.msg}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            `
            $('.main-content').prepend(alert)
        }
    };
    
    xhr.send(formData);
}

function toggleBannerUploadProgress(progressValue) {
    let display ='block';
    if (progressValue == 0) {
        display = 'none'
    }
    document.querySelector('#banner_post_upload_progress_wrapper').style.display = display
    document.querySelector('#banner_post_upload_progress_wrapper .progress').setAttribute('aria-value-now', progressValue)
    document.querySelector('#banner_post_upload_progress_wrapper .progress-bar').style.width = progressValue + '%'
    document.querySelector('#banner_post_upload_progress_wrapper .progress-bar').innerHTML = progressValue + '%'
}

function deleteBanner() {
    fetch(`/cms-admin/post/${postId}/banner`,{
        method: 'DELETE',
        headers: {
            'Accept':'application/json',
            "Content-type": "application/json",
            'x-csrf-token': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        credentials: 'same-origin',
    })
    .then(res => res.json())
    .then(data => {
        document.querySelector(`#banner_post_preview`).innerHTML = `<small class="d-block">Tidak ada banner post</small>`;
        let alert = `
            <div class="alert alert-success alert-dismissible show fade">
                Banner post telah dihapus!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            `
        $('.main-content').prepend(alert)
        banner_post_delete_modal.hide()
    })
    .catch(err => {
        let alert = `
            <div class="alert alert-danger alert-dismissible show fade">
                Terjadi kesalahan! Coba beberapa saat lagi.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            `
        $('.main-content').prepend(alert)
        banner_post_delete_modal.hide()
    })
}
