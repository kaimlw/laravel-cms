class MediaLibraryPlugin {
  constructor(editor) {
      this.editor = editor;
  }

  static get pluginName() {
      return 'MediaLibrary';
  }

  static get requires() {
    return ['Image'];
}

  init() {
      const editor = this.editor;

      // Register the button
      editor.ui.componentFactory.add('mediaLibrary', (locale) => {
        const buttonView = new editor.ui.view.ButtonView(locale);
        buttonView.set({
            label: 'Media Library',
            icon: `<svg viewBox="0 0 20 20">
                <path d="M18 3H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1zM2 15V4h16v11H2z"/>
                <path d="M4 12l3-3 2 2 5-5 3 3v4H4z"/>
                <circle cx="7" cy="7" r="1"/>
            </svg>`,
            tooltip: true
        })

        buttonView.on('execute', () => {
            this.openMediaLibrary();
        });

        return button;
    });
  }

  openMediaLibrary() {
      // Create modal container if it doesn't exist
      let modal = document.getElementById('media-library-modal');
      if (!modal) {
          modal = document.createElement('div');
          modal.id = 'media-library-modal';
          modal.className = 'modal fade';
          modal.innerHTML = `
              <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title">Media Library</h5>
                          <button type="button" class="close" data-dismiss="modal">×</button>
                      </div>
                      <div class="modal-body">
                          <div id="media-grid" class="row"></div>
                      </div>
                  </div>
              </div>
          `;
          document.body.appendChild(modal);
      }

      // Load images from the server
      fetch('/admin/media-library/images')
          .then(response => response.json())
          .then(images => {
              const mediaGrid = modal.querySelector('#media-grid');
              mediaGrid.innerHTML = '';

              images.forEach(image => {
                  const imageElement = document.createElement('div');
                  imageElement.className = 'col-md-3 mb-3';
                  imageElement.innerHTML = `
                      <img src="${image.url}" 
                           class="img-thumbnail cursor-pointer" 
                           alt="${image.name}"
                           style="cursor: pointer;">
                  `;

                  imageElement.querySelector('img').addEventListener('click', () => {
                      this.insertImage(image.url);
                      $(modal).modal('hide');
                  });

                  mediaGrid.appendChild(imageElement);
              });

              $(modal).modal('show');
          });
  }

  insertImage(url) {
      const imageElement = this.editor.model.schema.createFromUrl(url);
      this.editor.model.insertContent(imageElement);
  }
}

// export default MediaLibraryPlugin;