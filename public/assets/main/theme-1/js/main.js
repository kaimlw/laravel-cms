document.addEventListener('DOMContentLoaded', ()=>{
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
})