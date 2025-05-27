const modal_hapus = new bootstrap.Modal('#hapusModal')

// Media browser
let target = null
let selected_media = null
const mediaBrowserModal = new bootstrap.Modal('#mediaBrowserModal')
const media_wrapper = document.querySelector('#media-wrapper')

document.querySelector('#btnMediaPilih').addEventListener('click', function(){
    if (selected_media == null || target == null) {
        return
    }

    if (target == 'main-slide') {
        insertMainSlideFromMediaBrowser(selected_media)
    } else if (target == 'agenda-slide') {
        insertAgendaSlideFromMediaBrowser(selected_media)
    } else if (target == 'gallery-slide') {
        insertGallerySlideFromMediaBrowser(selected_media)
    } else if (target == 'partnership-slide') {
        insertPartnershipSlideFromMediaBrowser(selected_media)
    } else if (target == 'kaprodi-photo') {
        insertKaprodiPhotoFromMediaBrowser(selected_media)
    }

    target = null
    mediaBrowserModal.hide()
})

// Slider Utama Upload Button 
const main_slide_media_btn = document.querySelector('#main_slide_media_btn')
const main_slide_upload_input = document.querySelector('#main_slide_upload_input')
const main_slide_upload_btn = document.querySelector('#main_slide_upload_btn')

main_slide_media_btn.addEventListener('click', function(){
    target = 'main-slide'
    openMediaBrowser('main-slide')
})
main_slide_upload_btn.addEventListener('click', function(){
    main_slide_upload_input.click();
})
main_slide_upload_input.addEventListener('change', function(){
    uploadImage('main-slide', main_slide_upload_input.files[0])
})
document.querySelectorAll('.main-slide .btn-hapus').forEach(el => {
    el.addEventListener('click', function(){deleteSlide(el.getAttribute('data-id'))})
})

// Kaprodi Upload Button 
const kaprodi_media_btn = document.querySelector('#kaprodi_photo_media_btn')
const kaprodi_upload_input = document.querySelector('#kaprodi_photo_upload_input')
const kaprodi_upload_btn = document.querySelector('#kaprodi_photo_upload_btn')
const kaprodi_remove_photo_btn = document.querySelector('#kaprodi_photo_remove_btn')

kaprodi_media_btn.addEventListener('click', function(){
    target = 'kaprodi-photo'
    openMediaBrowser('kaprodi-photo')
})
kaprodi_upload_btn.addEventListener('click', function(){
    kaprodi_upload_input.click();
})
kaprodi_upload_input.addEventListener('input', function(){
    uploadImage('kaprodi-photo', kaprodi_upload_input.files[0])
})
document.querySelectorAll('.kaprodi .btn-hapus').forEach(el => {
    el.addEventListener('click', function(){deleteSlide(el.getAttribute('data-id'))})
})
if (kaprodi_remove_photo_btn != null) {
    kaprodi_remove_photo_btn.addEventListener('click', function(){deleteKaprodiPhoto()})
}

// Agenda Upload Button 
const agenda_slide_media_btn = document.querySelector('#agenda_media_btn')
const agenda_slide_upload_input = document.querySelector('#agenda_upload_input')
const agenda_slide_upload_btn = document.querySelector('#agenda_upload_btn')

agenda_slide_media_btn.addEventListener('click', function(){
    target = 'agenda-slide'
    openMediaBrowser('agenda-slide')
})
agenda_slide_upload_btn.addEventListener('click', function(){
    agenda_slide_upload_input.click();
})
agenda_slide_upload_input.addEventListener('change', function(){
    uploadImage('agenda-slide', agenda_slide_upload_input.files[0])
})
document.querySelectorAll('.agenda-slide .btn-hapus').forEach(el => {
    el.addEventListener('click', function(){deleteSlide(el.getAttribute('data-id'))})
})

// Gallery Upload Button 
const gallery_slide_media_btn = document.querySelector('#gallery_media_btn')
const gallery_slide_upload_input = document.querySelector('#gallery_upload_input')
const gallery_slide_upload_btn = document.querySelector('#gallery_upload_btn')

gallery_slide_media_btn.addEventListener('click', function(){
    target = 'gallery-slide'
    openMediaBrowser('gallery-slide')
})
gallery_slide_upload_btn.addEventListener('click', function(){
    gallery_slide_upload_input.click();
})
gallery_slide_upload_input.addEventListener('change', function(){
    uploadImage('gallery-slide', gallery_slide_upload_input.files[0])
})
document.querySelectorAll('.gallery-slide .btn-hapus').forEach(el => {
    el.addEventListener('click', function(){deleteSlide(el.getAttribute('data-id'))})
})

// Gallery Upload Button 
const partnership_slide_media_btn = document.querySelector('#partnership_media_btn')
const partnership_slide_upload_input = document.querySelector('#partnership_upload_input')
const partnership_slide_upload_btn = document.querySelector('#partnership_upload_btn')

partnership_slide_media_btn.addEventListener('click', function(){
    target = 'partnership-slide'
    openMediaBrowser('partnership-slide')
})
partnership_slide_upload_btn.addEventListener('click', function(){
    partnership_slide_upload_input.click();
})
partnership_slide_upload_input.addEventListener('change', function(){
    uploadImage('partnership-slide', partnership_slide_upload_input.files[0])
})
document.querySelectorAll('.partnership-slide .btn-hapus').forEach(el => {
    el.addEventListener('click', function(){deleteSlide(el.getAttribute('data-id'))})
})

// FUNCTION
function openMediaBrowser() {
  fetch(`${site_url}/cms-admin/media/all`,{
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
              <div class="thumbnail overflow-hidden">
                  <img src="${site_url}/${item.media_meta.filepath.thumbnail}" alt="" class="img-fluid">
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
  .catch(err => {
    console.log(err);
    
    let alert = `
            <div class="alert alert-danger alert-dismissible show fade">
                Terjadi Kesalahan! Coba beberapa saat lagi.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        `
    $('.main-content').prepend(alert)
  })
}

function checkMediaSelected() {
  if ($('.media-item').length > 0) {
      $('#btnMediaPilih').removeAttr('disabled');
  } else{
      $('#btnMediaPilih').attr('disabled');
  }
}

function insertMainSlideFromMediaBrowser(mediaId) {
    fetch(`${site_url}/cms-admin/theme/main-slide/${mediaId}`,{
        method: 'POST',
        headers: {
            'Accept':'application/json',
            "Content-type": "application/json",
            "X-CSRF-TOKEN" : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        credentials: 'same-origin',
    })
    .then(res => res.json())
    .then(data => {
        let element = `
            <li class="slide-item main-slide" data-id="${data.slide_id}">
                <button class="btn btn-hapus" data-id="${data.slide_id}" data-section="main-slide"><i class="bi bi-trash-fill"></i></button>
                <img class="img-fluid rounded-2" src="${site_url}/${data.img_path}">
            </li>
        `
        document.querySelector(`#main-slide`).insertAdjacentHTML('beforeend', element)
        document.querySelectorAll(`#main-slide .btn-hapus`).forEach(el => {
            el.addEventListener('click', function(){deleteSlide(el.getAttribute('data-id'))})
        })

        let alert = `
            <div class="alert alert-success alert-dismissible show fade">
                Slider berhasil ditambahkan!
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
                ${err}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        `
        $('.main-content').prepend(alert)
    })
}

function insertKaprodiPhotoFromMediaBrowser(mediaId) {
    fetch(`${site_url}/cms-admin/theme/kaprodi-photo/${mediaId}`,{
        method: 'POST',
        headers: {
            'Accept':'application/json',
            "Content-type": "application/json",
            "X-CSRF-TOKEN" : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        credentials: 'same-origin',
    })
    .then(res => res.json())
    .then(data => {
        setKaprodiPhoto(data.img_path)
        
        let alert = `
            <div class="alert alert-success alert-dismissible show fade">
                Foto Kaprodi berhasil ditambahkan!
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
                ${err}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        `
        $('.main-content').prepend(alert)
    })
}

function insertAgendaSlideFromMediaBrowser(mediaId) {
    fetch(`${site_url}/cms-admin/theme/agenda-slide/${mediaId}`,{
        method: 'POST',
        headers: {
            'Accept':'application/json',
            "Content-type": "application/json",
            "X-CSRF-TOKEN" : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        credentials: 'same-origin',
    })
    .then(res => res.json())
    .then(data => {
        let element = `
            <li class="slide-item agenda-slide" data-id="${data.slide_id}">
                <button class="btn btn-hapus" data-id="${data.slide_id}" data-section="agenda-slide"><i class="bi bi-trash-fill"></i></button>
                <img class="img-fluid rounded-2" src="${site_url}/${data.img_path}">
            </li>
        `
        document.querySelector(`#agenda-slide`).insertAdjacentHTML('beforeend', element)
        document.querySelectorAll(`#agenda-slide .btn-hapus`).forEach(el => {
            el.addEventListener('click', function(){deleteSlide(el.getAttribute('data-id'))})
        })

        let alert = `
            <div class="alert alert-success alert-dismissible show fade">
                Slider berhasil ditambahkan!
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
                ${err}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        `
        $('.main-content').prepend(alert)
    })
}

function insertGallerySlideFromMediaBrowser(mediaId) {
    fetch(`${site_url}/cms-admin/theme/gallery-slide/${mediaId}`,{
        method: 'POST',
        headers: {
            'Accept':'application/json',
            "Content-type": "application/json",
            "X-CSRF-TOKEN" : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        credentials: 'same-origin',
    })
    .then(res => res.json())
    .then(data => {
        let element = `
            <li class="slide-item gallery-slide" data-id="${data.slide_id}">
                <button class="btn btn-hapus" data-id="${data.slide_id}" data-section="gallery-slide"><i class="bi bi-trash-fill"></i></button>
                <img class="img-fluid rounded-2" src="${site_url}/${data.img_path}">
            </li>
        `
        document.querySelector(`#gallery-slide`).insertAdjacentHTML('beforeend', element)
        document.querySelectorAll(`#gallery-slide .btn-hapus`).forEach(el => {
            el.addEventListener('click', function(){deleteSlide(el.getAttribute('data-id'))})
        })

        let alert = `
            <div class="alert alert-success alert-dismissible show fade">
                Slider berhasil ditambahkan!
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
                ${err}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        `
        $('.main-content').prepend(alert)
    })
}

function insertPartnershipSlideFromMediaBrowser(mediaId) {
    fetch(`${site_url}/cms-admin/theme/partnership-slide/${mediaId}`,{
        method: 'POST',
        headers: {
            'Accept':'application/json',
            "Content-type": "application/json",
            "X-CSRF-TOKEN" : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        credentials: 'same-origin',
    })
    .then(res => res.json())
    .then(data => {
        let element = `
            <li class="slide-item partnership-slide" data-id="${data.slide_id}">
                <button class="btn btn-hapus" data-id="${data.slide_id}" data-section="partnership-slide"><i class="bi bi-trash-fill"></i></button>
                <img class="img-fluid rounded-2" src="${site_url}/${data.img_path}">
            </li>
        `
        document.querySelector(`#partnership-slide`).insertAdjacentHTML('beforeend', element)
        document.querySelectorAll(`#partnership-slide .btn-hapus`).forEach(el => {
            el.addEventListener('click', function(){deleteSlide(el.getAttribute('data-id'))})
        })

        let alert = `
            <div class="alert alert-success alert-dismissible show fade">
                Slider berhasil ditambahkan!
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
                ${err}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        `
        $('.main-content').prepend(alert)
    })
}

function uploadImage(section, file) {
    if (file == null) {
        console.log('file null');
        return
    }

    const formData = new FormData();
    formData.append('upload', file);

    const xhr = new XMLHttpRequest()
    xhr.open('POST', `${site_url}/cms-admin/theme/${section}`, true)
    xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'))
    xhr.withCredentials = true
    xhr.upload.addEventListener('progress', (event) => {
        if (event.lengthComputable) {
            const percentComplete = (event.loaded / event.total) * 100;
            toggleProgress(section, percentComplete)
        }
    })
    xhr.onload = () => {
        toggleProgress(section, 0)
        const data = JSON.parse(xhr.response)

        if (xhr.status == 200) {
            if (section == 'kaprodi-photo') {
                setKaprodiPhoto(data.img_path)
            } else {
                let element = `
                    <li class="slide-item ${section}" data-id="${data.slide_id}">
                        <button class="btn btn-hapus" data-id="${data.slide_id}" data-section="${section}"><i class="bi bi-trash-fill"></i></button>
                        <img class="img-fluid rounded-2" src="${site_url}/${data.img_path}">
                    </li>
                `
                document.querySelector(`.slide-preview-wrapper#${section}`).insertAdjacentHTML('beforeend', element)
                document.querySelectorAll(`.${section} .btn-hapus`).forEach(el => {
                    el.addEventListener('click', function(){deleteSlide(el.getAttribute('data-id'))})
                })
            }
        } else {
            let alert = `
            <div class="alert alert-danger alert-dismissible show fade">
                ${data.msg.upload}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            `
            $('.main-content').prepend(alert)
            window.scrollTo(0,0)
        }
    };
    
    xhr.send(formData);
}

function toggleProgress(section, progressValue) {
    let display ='block';
    let className = getClassNameBySection(section)
    if (progressValue == 0) {
        display = 'none'
    }
    document.querySelector("#" + className + '_upload_progress_wrapper').style.display = display
    document.querySelector("#" + className + '_upload_progress_wrapper .progress').setAttribute('aria-value-now', progressValue)
    document.querySelector("#" + className + '_upload_progress_wrapper .progress-bar').style.width = progressValue + '%'
    document.querySelector("#" + className + '_upload_progress_wrapper .progress-bar').innerHTML = progressValue + '%'
}

function deleteSlide(id) {
    document.querySelector('#formHapus').setAttribute('action', `${site_url}/cms-admin/theme/slide/${id}`);
    modal_hapus.show()
}

function deleteKaprodiPhoto(){
    document.querySelector('#formHapus').setAttribute('action', `${site_url}/cms-admin/theme/kaprodi-photo-delete`);
    modal_hapus.show()
}

function setKaprodiPhoto(img_path) {
    const element = `<img src="${site_url}/${img_path}" alt="" class="img-fluid">`
    document.querySelector('#kaprodi_photo_preview').innerHTML = element
    
    if (document.querySelector('#kaprodi_photo_remove_btn') == null) {
        let btnHapus = `<button class="btn btn-danger btn-sm mb-1" id="kaprodi_photo_remove_btn"><i class="bi bi-trash"></i> Hapus Foto</button>`
        document.querySelector('#kaprodi_photo_buttons').insertAdjacentHTML('afterbegin', btnHapus)
        document.querySelector('#kaprodi_photo_remove_btn').addEventListener('click', ()=>{deleteKaprodiPhoto()})
    }
}

function getClassNameBySection(section) {
    let className = ""
    switch (section) {
        case 'main-slide':
            className = 'main_slide'
            break;

        case 'kaprodi-photo':
            className = 'kaprodi_photo'
            break;
            
        case 'agenda-slide':
            className = 'agenda'
            break;

        case 'gallery-slide':
            className = 'gallery'
            break;

        case 'partnership-slide':
            className = 'partnership'
            break;
    
        default:
            break;
    }
    return className
}