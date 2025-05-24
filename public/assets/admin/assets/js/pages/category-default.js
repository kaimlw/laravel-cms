// Simple Datatable
let table1 = document.querySelector('#table1');
let dataTable = new simpleDatatables.DataTable(table1);

// FORM TAMBAH
const btnTambah = document.querySelector('button[data-target="#tambahCategoryModal"]')
const formTambah = document.querySelector('#formTambah')
btnTambah.addEventListener('click', ()=>{
    $('#formTambah input, #formTambah textarea').val('')
    $('.invalid-feedback').remove();
    $('.is-invalid').removeClass('is-invalid')
})

// FORM EDIT
let nameEditInput = document.querySelector('#formEdit #nameInput');
let deskripsiEditInput = document.querySelector('#formEdit #deskripsiInput');
let parentCategoryEditSelect = document.querySelector('#formEdit #parentCategorySelect');
let parentCategoryEditSelectOptions = parentCategoryEditSelect.children

// FUNCTION
function openEditModal(id){
    fetch(`${site_url}/cms-admin/default/category/${id}`,{
        method: 'GET',
        credentials: 'same-origin'
    })
    .then((res)=>res.json())
    .then((data)=>{
        $('#editCategoryModal').modal('show')
        $('#formEdit').attr('action',`${site_url}/cms-admin/default/category/${id}`)

        document.querySelector('#formEdit #categoryEdit').value = id
        nameEditInput.value = data.name;
        deskripsiEditInput.value = data.description;
        for (let i = 0; i < parentCategoryEditSelectOptions.length; i++) {
            // Jika induk kategori = value options, tambahkan attribute selected
            if (parentCategoryEditSelectOptions[i].value == data.parent) {
                parentCategoryEditSelectOptions[i].setAttribute('selected',true);
            }else{
                parentCategoryEditSelectOptions[i].removeAttribute('selected');
            }

            // Jika options = kategori, maka tidak perlu ditampilkan
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
    $('#hapusCategoryModal').modal('show')
    $('#formHapus').attr('action',`${site_url}/cms-admin/default/category/${id}`)
}

function resetForm(form) {
    form.reset();
}