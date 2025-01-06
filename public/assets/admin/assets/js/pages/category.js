// Simple Datatable
let table1 = document.querySelector('#table1');
let dataTable = new simpleDatatables.DataTable(table1);

// FORM EDIT
let kategoriEditInput = document.querySelector('#formEdit #kategoriInput');
let deskripsiEditInput = document.querySelector('#formEdit #deskripsiInput');
let parentCategoryEditSelect = document.querySelector('#formEdit #parentCategorySelect');
let parentCategoryEditSelectOptions = parentCategoryEditSelect.children

console.log();
// FUNCTION
function openEditModal(id){
    fetch(`/desa-admin/category/get-category/${id}`,{
        method: 'GET',
        credentials: 'same-origin'
    })
    .then((res)=>res.json())
    .then((data)=>{
        $('#editKategoriModal').modal('show')
        $('#formEdit').attr('action',`/desa-admin/category/${id}`)

        kategoriEditInput.value = data.name;
        deskripsiEditInput.value = data.description;
        for (let i = 0; i < parentCategoryEditSelectOptions.length; i++) {
            if (parentCategoryEditSelectOptions[i].value == data.parent) {
                parentCategoryEditSelectOptions[i].setAttribute('selected',true);
            }

            if (parentCategoryEditSelectOptions[i].value == data.id) {
                parentCategoryEditSelectOptions[i].classList.add('d-none');
            }else{
                parentCategoryEditSelectOptions[i].classList.remove('d-none');
            }
            
        }
        

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
    $('#hapusKategoriModal').modal('show')
    $('#formHapus').attr('action',`/desa-admin/category/${id}`)
}