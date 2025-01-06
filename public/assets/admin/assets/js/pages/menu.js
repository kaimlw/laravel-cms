// Form Tambah Page
let pageRadios = document.querySelectorAll('.page-radio')
let pageTitleSelected = document.getElementById('pageMenuTitle')
let pageSlugSelected = document.getElementById('pageMenuSlug')
let pageParentSelect = document.getElementById('pageParentSelect')
let pageChildrenGroupInput = document.getElementById('pageChildrenGroupInput')

// Form Tambah Post
let postRadio = document.querySelectorAll('.post-radio')
let postTitleSelected = document.getElementById('postMenuTitle')
let postSlugSelected = document.getElementById('postMenuSlug')
let postParentSelect = document.getElementById('postParentSelect')
let postChildrenGroupInput = document.getElementById('postChildrenGroupInput')

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
addChangeListenerToParentSelect(pageParentSelect,pageChildrenGroupInput)
// ---TO FORM POST
addChangeListenerToRadiosSelect(postRadio,postTitleSelected,postSlugSelected)
addChangeListenerToParentSelect(postParentSelect,postChildrenGroupInput)
// ---TO FORM CATEGORY
addChangeListenerToRadiosSelect(categoryRadio, categoryTitleSelected, categorySlugSelected)
addChangeListenerToParentSelect(categoryParentSelect,categoryChildrenGroupInput)
// ---TO FORM CUSTOM LINK
addChangeListenerToParentSelect(customParentSelect,customChildrenGroupInput)
// ---TO FORM EDIT
addChangeListenerToParentSelect(parentEditSelect,editChildrenGroupInput)

// FUNCTION
function addChangeListenerToParentSelect(parentSelect,childrenGroupInput){
    parentSelect.addEventListener('change', ()=>{
        if (parentSelect.value != '') {
            childrenGroupInput.classList.remove('d-none')
            childrenGroupInput.value = ''
        }else{
            childrenGroupInput.classList.add('d-none')
            childrenGroupInput.value = ''
        }
    })
    
}

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
    fetch(`/desa-admin/menu/get-item/${id}`,{
        method: 'GET',
        credentials: 'same-origin'
    })
    .then((res)=>res.json())
    .then((data)=>{
        $('#editMenuItemModal').modal('show')
        $('#formEdit').attr('action',`/desa-admin/menu/${id}`)
        
        let parentEditSelectChildren = parentEditSelect.children

        labelEditInput.value = data.name;
        linkEditInput.value = data.link;
        for (let i = 0; i < parentEditSelectChildren.length; i++) {
            if (parentEditSelectChildren[i].value == data.parent_id) {
                parentEditSelectChildren[i].selected = true;
            }else{
                parentEditSelectChildren[i].selected = false;
            }
        }
        childGroupEditInput.value = data.children_group;
        menuOrderEditInput.value = data.order_index;

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
    $('#hapusDesaModal').modal('show')
    $('#formHapus').attr('action',`/desa-admin/menu/${id}`)
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