document.addEventListener('DOMContentLoaded', function(){
    // INISIALISASI SLIDER BANNER
    var main_splide = new Splide('#main_slide', {
      type : 'loop',
      pagination: false,
      autoplay: true,
      interval: 5000,
      perPage: 1,
      arrows : false,
      gap : '0.5em',
      updateOnMove : true
    })
    var partner_splide = new Splide('#partner_slide', {
      type : 'loop',
      autoplay: true,
      interval: 2000,
      trimSpace: 'move',
      pagination: false,
      perPage: 3,
      perMove: 1,
      arrows : false,
      gap : '1em',
      autoWidth: true,
      updateOnMove : true
    })
    var agenda_splide = new Splide('#agenda_slide', {
      type : (agenda_count >= 4) ? "loop" : "slide",
      pagination: false,
      autoWidth: true,
      autoplay: true,
      interval: 5000,
      perPage: 4,
      arrows : false,
      gap : '1rem',
      updateOnMove : true
    })
  
    main_splide.mount()
    partner_splide.mount()
    agenda_splide.mount()

  // SHOW/HIDE SOME SERVICES
  let btn_service_cols = document.querySelectorAll(".service-col")
  let btn_service_show = document.querySelector('#btn-service-show')
  let btn_service_hide = document.querySelector('#btn-service-hide')
  
  function toggleBtnServiceDisplay(){
    btn_service_show.classList.toggle('d-none')
    btn_service_hide.classList.toggle('d-none')
  }

  for (let i = 12; i < btn_service_cols.length; i++) {
    btn_service_cols[i].classList.add('d-none')
  }

  btn_service_show.addEventListener('click', function(){
    btn_service_cols.forEach(el => {
      el.classList.remove('d-none')
    })
    toggleBtnServiceDisplay()    
  })

  btn_service_hide.addEventListener('click', function(){
    for (let i = 12; i < btn_service_cols.length; i++) {
      btn_service_cols[i].classList.add('d-none')
    }
    toggleBtnServiceDisplay()
    document.querySelector("#services").scrollIntoView()
  })

  // AGENDA SPLIDE BUTTON
  let agenda_next_button = document.querySelector('#btn-splide-next')
  let agenda_prev_button = document.querySelector('#btn-splide-prev')

  agenda_next_button.addEventListener('click', function(){
    agenda_splide.go('+${1}')    
  })
  agenda_prev_button.addEventListener('click', function(){
    agenda_splide.go('-${1}')    
  })

  // INFO CAMPUS CATEGORY TAB
  document.querySelectorAll('.info-category-list-item').forEach(el => {
    el.addEventListener('click', function(){
      let target_category = el.getAttribute('data-target')
      document.querySelector(".info-category-list-item.active").classList.remove('active')
      document.querySelector(".info-post-wrapper.show").classList.remove('show')

      el.classList.add('active')
      document.querySelector(`.info-post-wrapper[data-category="${target_category}"]`).classList.add('show')
    })
  })

  // SET IMAGE TO LIGHTBOX
  document.querySelectorAll('.gallery-img-wrapper').forEach(el => {
    el.addEventListener('click', function(){
      let img_url = el.children[0].getAttribute('src')    
      document.querySelector('#gallery-lightbox-img').setAttribute('src',img_url)
    })
  })
})