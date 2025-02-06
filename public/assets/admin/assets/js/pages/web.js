// Simple Datatable
let table1 = document.querySelector('#table1');
let dataTable = new simpleDatatables.DataTable(table1);

// FORM EDIT
let namaWebEditInput = document.querySelector('#formEdit #namaWebInput');
let subdomainEditInput = document.querySelector('#formEdit #subDomainInput');


// FUNCTION
function openEditModal(id){
    fetch(`${site_url}/cms-admin/web/${id}`,{
        method: 'GET',
        credentials: 'same-origin'
    })
    .then((res)=>res.json())
    .then((data)=>{
        $('#editWebModal').modal('show')
        $('#formEdit').attr('action',`${site_url}/cms-admin/web/${id}`)

        document.querySelector('#webEdit').value = data.encrypted_id
        namaWebEditInput.value = data.name;
        subdomainEditInput.value = data.subdomain;

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
    $('#hapusWebModal').modal('show')
    $('#formHapus').attr('action',`${site_url}/cms-admin/web/${id}`)
}