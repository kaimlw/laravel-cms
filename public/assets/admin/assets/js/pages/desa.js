// Simple Datatable
let table1 = document.querySelector('#table1');
let dataTable = new simpleDatatables.DataTable(table1);

// FORM EDIT
let namaDesaEditInput = document.querySelector('#formEdit #namaDesaInput');
let subdomainEditInput = document.querySelector('#formEdit #subDomainInput');
let kodeDesaEditInput = document.querySelector('#formEdit #kodeDesaInput');


// FUNCTION
function openEditModal(id){
    fetch(`/desa-admin/desa/get-desa/${id}`,{
        method: 'GET',
        credentials: 'same-origin'
    })
    .then((res)=>res.json())
    .then((data)=>{
        $('#editDesaModal').modal('show')
        $('#formEdit').attr('action',`/desa-admin/desa/${id}`)

        namaDesaEditInput.value = data.nama;
        subdomainEditInput.value = data.subdomain;
        kodeDesaEditInput.value = data.kode_desa;

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
    $('#formHapus').attr('action',`/desa-admin/desa/${id}`)
}