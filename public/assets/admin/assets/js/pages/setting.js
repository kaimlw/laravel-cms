// Media browser
let selected_media = null
const web_id = document.querySelector('#web').value;
const mediaBrowserModal = new bootstrap.Modal('#mediaBrowserModal')
const media_wrapper = document.querySelector('#media-wrapper')
document.querySelector('#banner_default_btn').addEventListener('click', function(){
    openMediaBrowser()
})

document.querySelector('#btnMediaPilih').addEventListener('click', function(){
    if (selected_media == null) {
        return
    }
    insertImageFromMediaBrowser(selected_media)
    mediaBrowserModal.hide()
})

// Hapus Banner Post
if (document.querySelector('#btn_hapus_banner_post')) {
    document.querySelector('#btn_hapus_banner_post').addEventListener('click', function(){
        hapusBannerPost(web_id);
    })
}

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
  })
}

function checkMediaSelected() {
  if ($('.media-item').length > 0) {
      $('#btnMediaPilih').removeAttr('disabled');
  } else{
      $('#btnMediaPilih').attr('disabled');
  }
}

function insertImageFromMediaBrowser(mediaId) {
  fetch(`${site_url}/cms-admin/media/${mediaId}`,{
      method: 'GET',
      headers: {
          'Accept':'application/json',
          "Content-type": "application/json",
      },
      credentials: 'same-origin',
  })
  .then(res => res.json())
  .then(data => {
      document.querySelector('#img_preview_banner_post').setAttribute('src', "/" + data.media_meta.filepath.medium)
      document.querySelector('#input_default_banner_post').value = data.media_meta.filepath.medium
  })
}

function hapusBannerPost(web_id){
  fetch(`${site_url}/cms-admin/setting/${web_id}/banner-null`,{
    method: 'PUT',
    credentials: 'same-origin',
    body: JSON.stringify({
        banner_post_web_media : "null" 
    }),
    headers: {
        "Content-type": "application/json",
        'x-csrf-token': document.querySelector('input[name="_token"]').value
    }
  })
  .then(res => res.json())
  .then(data => {
    let alert = `
        <div class="alert alert-${data.alert} alert-dismissible show fade">
            ${data.msg}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
    `
    $('.main-content').prepend(alert)
    document.querySelector('#img_preview_banner_post').setAttribute('src', "")
    document.querySelector('#btn_hapus_banner_post').remove()
    window.scrollTo({top: 0, behavior: 'smooth'})
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