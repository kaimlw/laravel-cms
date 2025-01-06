const largeQuery = window.matchMedia("(max-width: 976px)");
const xsmallQuery = window.matchMedia("(max-width: 576px)");

let navDropdownToggler = document.querySelectorAll('.dropdown-toggler')
let navDropdownMenu = document.querySelectorAll('.nav-dropdown-menu')
let searchBtn = document.getElementById('searchBtn');
let searchInput = document.getElementById('searchInput')
let banner = document.getElementById('banner')

handleBreakpoint()
window.onscroll = function() {scrollFunction()};
largeQuery.addListener(handleBreakpoint);

searchBtn.addEventListener('click', ()=>{
    searchInput.classList.toggle('d-block');
})

// FUNCTION
function scrollFunction() {
    if (document.documentElement.scrollTop > banner.scrollHeight || document.documentElement.scrollTop > window.innerHeight-50) {
        document.getElementById('header').classList.add('visible')
        document.getElementById('navbar-btn').classList.add('scroll')
        // document.getElementById('darkModeCheckboxLabel').classList.remove('text-white')
        document.getElementById('searchBtn').classList.remove('text-white')
    } else {
        document.getElementById('searchBtn').classList.add('text-white')
        document.getElementById('navbar-btn').classList.remove('scroll')
        document.getElementById('header').classList.remove('visible')
        // document.getElementById('darkModeCheckboxLabel').classList.add('text-white')
    }
}

function handleBreakpoint(){
    if (largeQuery.matches){
        navDropdownToggler.forEach(item => {
            item.addEventListener('click',()=>{
                item.lastElementChild.classList.toggle('d-block')
            })
        })
    }else{
        navDropdownMenu.forEach(item => {
            item.classList.remove('d-block')
        })
    }

    if (xsmallQuery.matches) {
        document.getElementById('navbarToggler').classList.add('order-3');
        document.getElementById('navbarMenu').classList.add('order-2');
        // document.getElementById('darkModeToggler').classList.add('d-none');
        // document.getElementById('darkModeToggler').classList.remove('d-flex');
        }else{
        // document.getElementById('darkModeToggler').classList.remove('d-none');
        // document.getElementById('darkModeToggler').classList.add('d-flex');
        document.getElementById('navbarToggler').classList.remove('order-3');
        document.getElementById('navbarMenu').classList.remove('order-2');
    }
}
