import GLightbox from 'glightbox';

export class Lightbox {
  constructor() {
    this.init();
  }

  init() {
    GLightbox({
      selector: '.glightbox',
      skin: 'clean',
      openEffect: 'zoom',
      closeEffect: 'zoom',
      zoomable: true,
      draggable: true,
      touchNavigation: true,
      loop: false,
      autoplayVideos: true,
      closeButton: true,
    });
  }
}

document.addEventListener('DOMContentLoaded', function () {
  new Lightbox();
});
