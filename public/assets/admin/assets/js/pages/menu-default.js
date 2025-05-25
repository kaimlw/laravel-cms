// Form Tambah Page
let pageRadios = document.querySelectorAll('.page-radio')
let pageTitleSelected = document.getElementById('pageMenuTitle')
let pageSlugSelected = document.getElementById('pageMenuSlug')
let pageParentSelect = document.getElementById('pageParentSelect')
let pageChildrenGroupInput = document.getElementById('pageChildrenGroupInput')

// Form Tambah Category
let categoryRadio = document.querySelectorAll('.category-radio')
let categoryTitleSelected = document.getElementById('categoryMenuTitle')
let categorySlugSelected = document.getElementById('categoryMenuSlug')
let categoryParentSelect = document.getElementById('categoryParentSelect')
let categoryChildrenGroupInput = document.getElementById('categoryChildrenGroupInput')

// Form Tambah Custom Link
let customParentSelect = document.getElementById('customParentSelect')
let customChildrenGroupInput = document.getElementById('customChildrenGroupInput')

// Form Edit
let labelEditInput = document.getElementById('labelEditInput');
let linkEditInput = document.getElementById('linkEditInput')
let parentEditSelect = document.getElementById('parentEditSelect')
let editChildrenGroupInput = document.getElementById('editChildrenGroupInput')
let childGroupEditInput = document.getElementById('childGroupEditInput')
let menuOrderEditInput = document.getElementById('menuOrderEditInput');

// ADD CHANGE EVENT LISTENER
// ---TO FORM PAGE
addChangeListenerToRadiosSelect(pageRadios,pageTitleSelected,pageSlugSelected)
// ---TO FORM CATEGORY
addChangeListenerToRadiosSelect(categoryRadio, categoryTitleSelected, categorySlugSelected)

// FUNCTION


function addChangeListenerToRadiosSelect(radioSelect,titleInput,slugInput){
    radioSelect.forEach(item => {
        item.addEventListener('change', ()=>{
            let selected = checksSelected(radioSelect)
            titleInput.value = selected[0]
            slugInput.value = selected[1]
        })
    });
}

function openEditModal(id){
    fetch(`${site_url}/cms-admin/default/menu/${id}`,{
        method: 'GET',
        credentials: 'same-origin'
    })
    .then((res)=>res.json())
    .then((data)=>{
        $('#editMenuItemModal').modal('show')
        $('#formEdit').attr('action',`${site_url}/cms-admin/default/menu/${id}`)
        
        let parentEditSelectChildren = parentEditSelect.children

        labelEditInput.value = data.name;
        linkEditInput.value = data.target;
        for (let i = 0; i < parentEditSelectChildren.length; i++) {
            if (parentEditSelectChildren[i].value == data.parent_id) {
                parentEditSelectChildren[i].selected = true;
            }else{
                parentEditSelectChildren[i].selected = false;
            }

            if (parentEditSelectChildren[i].value == data.id) {
                parentEditSelectChildren[i].classList.add('d-none')
            } else {
                parentEditSelectChildren[i].classList.remove('d-none')
            }
        }
        menuOrderEditInput.value = data.menu_order;

        $('.invalid-feedback').remove();
        $('.is-invalid').removeClass('is-invalid')
    })
    .catch((err)=>{
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

function openHapusModal(id){
    $('#hapusMenuModal').modal('show')
    $('#formHapus').attr('action',`${site_url}/cms-admin/default/menu/${id}`)
}

function checksSelected(selectElements){
    let title,slug
    selectElements.forEach(item => {
        if (item.checked == true) {
            title = item.getAttribute('data-title')
            slug = item.getAttribute('data-slug')
        }
    })

    return [title,slug]
}