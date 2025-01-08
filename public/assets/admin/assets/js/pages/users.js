// Simple Datatable
let table1 = document.querySelector('#table1');
let dataTable = new simpleDatatables.DataTable(table1);

// FORM EDIT
let usernameEditInput = document.querySelector('#formEdit #usernameInput');
let displayNameEditInput = document.querySelector('#formEdit #displayNameInput');
let emailEditInput = document.querySelector('#formEdit #emailInput');
let roleEditSelect = document.querySelector('#formEdit #roleSelect');


// FUNCTION
function openEditModal(id){
    fetch(`/cms-admin/user/${id}`,{
        method: 'GET',
        credentials: 'same-origin'
    })
    .then((res)=>res.json())
    .then((data)=>{
        $('#editUserModal').modal('show')
        $('#formEdit').attr('action',`/cms-admin/user/${id}`)

        document.querySelector('#formEdit #userEdit').value = data.encrypted_id
        usernameEditInput.value = data.username;
        displayNameEditInput.value = data.display_name;
        emailEditInput.value = data.email;
        roleEditSelect.value = data.roles;

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
    $('#hapusUserModal').modal('show')
    $('#formHapus').attr('action',`/cms-admin/user/${id}`)
}