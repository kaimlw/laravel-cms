// Simple Datatable
let table1 = document.querySelector('#table1');
let dataTable = new simpleDatatables.DataTable(table1);

// FORM TAMBAH
const btnTambah = document.querySelector('button[data-target="#tambahPageModal"]')
const formTambah = document.querySelector('#formTambah')
btnTambah.addEventListener('click', ()=>{
    resetForm(formTambah)
})

// FORM EDIT
let titleEditInput = document.querySelector('#formEdit #titleInput');
let slugEditInput = document.querySelector('#formEdit #slugInput');


// FUNCTION
function openEditModal(id){
    fetch(`${site_url}/cms-admin/default/page/${id}`,{
        method: 'GET',
        credentials: 'same-origin'
    })
    .then((res)=>res.json())
    .then((data)=>{
        $('#editPageModal').modal('show')
        $('#formEdit').attr('action',`${site_url}/cms-admin/default/page/${id}`)

        document.querySelector('#formEdit #pageEdit').value = id
        titleEditInput.value = data.title;
        slugEditInput.value = data.slug;

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
    $('#hapusPageModal').modal('show')
    $('#formHapus').attr('action',`${site_url}/cms-admin/default/page/${id}`)
}

function resetForm(form) {
    form.reset();
}