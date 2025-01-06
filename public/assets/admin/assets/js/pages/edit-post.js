let postId = document.getElementById('postId').value
let judulInput = document.getElementById('judulInput');
let authorSelect = document.getElementById('authorSelect');
let bannerInput = document.getElementById('bannerPost');
let btnSave = document.getElementById('btnSave');
let btnPublish = document.getElementById('btnPublish');
let formBannerPost = document.getElementById('formBannerPost');

let kategoriChecks = document.querySelectorAll('.kategori-check');
let checkedCategory
kategoriChecks.forEach(item =>{
    item.addEventListener('change',()=>{
        if (item.getAttribute('data-parent') != 0) {
            let parentId = item.getAttribute('data-parent')
            let parentElement = document.querySelector('#kategori'+parentId)
            if (item.checked && !parentElement.checked ) {
                parentElement.checked = true;
            }
        }
        
        checkSubKategoriCondition(item)

        checkedCategory = checkAndPushKategoriId()
    })
})

let editor;
ClassicEditor
    .create( document.querySelector( '#editor' ), {
        extraPlugins: [ UploadAdapterPlugin ],
    } )
    .then(newEditor => {
        editor=newEditor;
        editor.model.document.on( 'change:data', ( evt, data ) => {
            btnSave.removeAttribute('disabled')
        } );
    })
    .catch( error => {
        console.log( error );
    } );

btnSave.addEventListener('click',saveContentChanges);
if (btnPublish) {
    btnPublish.addEventListener('click',publishPost);
}

addChangeListenerToActivateSave(judulInput)
addChangeListenerToActivateSave(authorSelect)
addChangeListenerToActivateSave(bannerInput)
if (kategoriChecks) {
    addChangeListenerToActivateSave(kategoriChecks)
}

// ----- FUNCTION
class MyUploadAdapter {
    constructor( loader ) {
        // The file loader instance to use during the upload.
        this.loader = loader;
    }

    // Starts the upload process.
    upload() {
        return this.loader.file
            .then( file => new Promise( ( resolve, reject ) => {
                this._initRequest();
                this._initListeners( resolve, reject, file );
                this._sendRequest( file );
            } ) );
    }

    // Aborts the upload process.
    abort() {
        if ( this.xhr ) {
            this.xhr.abort();
        }
    }

    // Initializes the XMLHttpRequest object using the URL passed to the constructor.
    _initRequest() {
        const xhr = this.xhr = new XMLHttpRequest();

        // Note that your request may look different. It is up to you and your editor
        // integration to choose the right communication channel. This example uses
        // a POST request with JSON as a data structure but your configuration
        // could be different.
        xhr.open( 'POST', '/desa-admin/post/upload-image', true );
        xhr.setRequestHeader('x-csrf-token',document.querySelector("meta[name='csrf-token']").getAttribute('content'))
        xhr.responseType = 'json';
    }

    // Initializes XMLHttpRequest listeners.
    _initListeners( resolve, reject, file ) {
        const xhr = this.xhr;
        const loader = this.loader;
        const genericErrorText = `Couldn't upload file: ${ file.name }.`;

        xhr.addEventListener( 'error', () => reject( genericErrorText ) );
        xhr.addEventListener( 'abort', () => reject() );
        xhr.addEventListener( 'load', () => {
            const response = xhr.response;

            // This example assumes the XHR server's "response" object will come with
            // an "error" which has its own "message" that can be passed to reject()
            // in the upload promise.
            //
            // Your integration may handle upload errors in a different way so make sure
            // it is done properly. The reject() function must be called when the upload fails.
            if ( !response || response.error ) {
                return reject( response && response.error ? response.error.message : genericErrorText );
            }

            // If the upload is successful, resolve the upload promise with an object containing
            // at least the "default" URL, pointing to the image on the server.
            // This URL will be used to display the image in the content. Learn more in the
            // UploadAdapter#upload documentation.
            resolve( {
                default: response.url
            } );
        } );

        // Upload progress when it is supported. The file loader has the #uploadTotal and #uploaded
        // properties which are used e.g. to display the upload progress bar in the editor
        // user interface.
        if ( xhr.upload ) {
            xhr.upload.addEventListener( 'progress', evt => {
                if ( evt.lengthComputable ) {
                    loader.uploadTotal = evt.total;
                    loader.uploaded = evt.loaded;
                }
            } );
        }
    }

    // Prepares the data and sends the request.
    _sendRequest( file ) {
        // Prepare the form data.
        const data = new FormData();

        data.append('id', post_id);
        data.append( 'upload', file );

        // Important note: This is the right place to implement security mechanisms
        // like authentication and CSRF protection. For instance, you can use
        // XMLHttpRequest.setRequestHeader() to set the request headers containing
        // the CSRF token generated earlier by your application.

        // Send the request.
        this.xhr.send( data );
    }
}
function UploadAdapterPlugin( editor ) {
    editor.plugins.get( 'FileRepository' ).createUploadAdapter = ( loader ) => {
        // Configure the URL to the upload script in your back-end here!
        return new MyUploadAdapter( loader );
    };
}

function saveContentChanges(){
    fetch(`/desa-admin/post/content/${postId}`,{
        method: 'PUT',
        credentials: 'same-origin',
        body:
        JSON.stringify({
            title: judulInput.value,
            author: authorSelect.value,
            content: editor.getData(),
            categories : checkedCategory,
        })
        ,
        headers: {
            'Accept':'application/json',
            "Content-type": "application/json",
            'x-csrf-token': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        }
    })
    .then((res)=>res.json())
    .then((data)=>{
        if (data.alert == 'danger') {
            data.msg.forEach(item => {
                let alert = `
                <div class="alert alert-danger alert-dismissible show fade">
                    ${item.msg[0]} 
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                `
                $('.main-content').prepend(alert)
            });

            return 
        }
        let alert = `
            <div class="alert alert-${data.alert} alert-dismissible show fade">
                ${data.msg}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        `
        $('.main-content').prepend(alert)
        btnSave.setAttribute('disabled',true)
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

function publishPost(){
    fetch(`/desa-admin/post/${postId}/publish`,{
        method: 'POST',
        credentials: 'same-origin',
        body: JSON.stringify({
            postStatus: 'publish' 
        }),
        headers: {
            "Content-type": "application/json",
            'x-csrf-token': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then((res)=>res.json())
    .then((data)=>{
        let alert = `
            <div class="alert alert-${data.alert} alert-dismissible show fade">
                ${data.msg}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        `
        $('.main-content').prepend(alert)
        btnPublish.style.display="none"
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

function checkAndPushKategoriId() {
    let checkedCategories = []
    kategoriChecks.forEach(item => {
        if (item.checked == true) {
            checkedCategories.push(item.value)
        }
    })

    return checkedCategories
}

function checkSubKategoriCondition(parent) {
    let parentId = parent.value
    let subKategori = document.querySelectorAll(`.kategori-check[data-parent='${parentId}']`)
    
    if (subKategori.length > 0) {
        if (parent.checked == false) {
            subKategori.forEach(item => {
                item.checked = false;
            })
        }
    }
}

function addChangeListenerToActivateSave(element){   
    console.log(element);
     
    if (element.length > 1) {
        element.forEach(item => {
            item.addEventListener('change', ()=>{
                btnSave.removeAttribute('disabled')
            })
        })
    }else{
        element.addEventListener('change', () => {
            btnSave.removeAttribute('disabled')
        })
    }
}
