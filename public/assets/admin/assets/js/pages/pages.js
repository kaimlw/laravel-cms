// Simple Datatable
let table1 = document.querySelector('#table1');
let dataTable = new simpleDatatables.DataTable(table1);

let urlParam = new URLSearchParams(window.location.search)
let postType = 'post'
if (urlParam.get('type') == 'page') {
    postType = 'page'
}

// Button New Page
let btnNewPage = document.getElementById('btnNewPage');

btnNewPage.addEventListener('click', createNewPage)

// -----------FUNCTION------------
function createNewPage(){
    fetch('/desa-admin/post',{
        method: 'POST',
        credentials: 'same-origin',
        body: JSON.stringify({
            type: postType
        }),
        headers: {
            "Content-type": "application/json",
            'x-csrf-token': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then((res)=>res.json())
    .then((data)=>{
        window.location.href = `/desa-admin/post/edit/${data.id}`
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
    $('#hapusPageModal').modal('show')
    $('#formHapus').attr('action',`/desa-admin/post/${id}`)
}