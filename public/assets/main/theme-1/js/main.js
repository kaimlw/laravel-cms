document.addEventListener('DOMContentLoaded', ()=>{
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
    type : 'loop',
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

  // SET MAIN NAVBAR STICKY JIKA SCROLL
  const mainNavbar = document.querySelector("#main-nav");
  const topNavbarHeight = document.querySelector("#top-nav").offsetHeight;
  window.addEventListener('scroll', ()=>{
    if (window.scrollY >= topNavbarHeight) {
      mainNavbar.classList.add("sticky");
    } else {
      mainNavbar.classList.remove("sticky");
    }
  })

  // NAVBAR SUB MENU CLICK LISTENER IF SCREEN <=MEDIUM
  document.querySelectorAll('#main-nav li.has-sub a').forEach(el => {
    el.addEventListener('click', function(){
      if (el.parentElement.children.length == 3){
        el.parentElement.children[2].classList.toggle('show')
      }else{
        el.parentElement.children[1].classList.toggle('show')
      }
    })
  })

  // SEARCH BUTTON CLICK LISTENER
  document.querySelector("#btn-search-md").addEventListener('click', function(el){
    document.querySelector('#searchbar').classList.toggle('show')
  })
  document.querySelector("#btn-search-lg").addEventListener('click', function(el){
    document.querySelector('#searchbar').classList.toggle('show')
  })

  // TOGGLE CLASS ACTIVE KE IMG WELCOME
  document.querySelectorAll(".welcome-dean-container-item-img").forEach(e => {
    e.addEventListener('mouseover', ()=>{
      e.parentElement.classList.add('active')
    })
    e.addEventListener('mouseout', ()=>{
      e.parentElement.classList.remove('active')
    })
  })

  // MENAMPILKAN VIDEO YOUTUBE SETELAH OVERLAY DI CLICK
  document.querySelectorAll('.video-fkip .video-wrapper').forEach(element =>{
    let video_player = element.children[0]
    let url = element.getAttribute('data-url')
    let img = element.getAttribute('data-img')

    video_player.innerHTML += `
      <i class="display-3 bi bi-play-circle-fill text-primary video-player-icon"></i>
      <img src="${img}" class="img-fluid">
    `

    video_player.addEventListener('click', function(){
      video_player.innerHTML = `
        <iframe width="853" height="480" src="${url}?autoplay=1" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
      `
      video_player.removeEventListener('click')
    })
  })

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