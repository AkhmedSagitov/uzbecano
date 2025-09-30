export class MainMenu {
  menu: HTMLElement;
  openBtns: NodeListOf<HTMLElement>;
  closeBtns: NodeListOf<HTMLElement>;
  layers: NodeListOf<HTMLElement>;

  constructor(menu: HTMLElement) {
    this.menu = menu;
    this.openBtns = menu.querySelectorAll('[data-main-menu-open]');
    this.closeBtns = menu.querySelectorAll('[data-main-menu-close]');
    this.layers = menu.querySelectorAll('[data-main-menu-layer]');
    this.init();
  }

  init() {
    this.addEventListener();
  }

  addEventListener() {
    this.openBtns.forEach((btn) => {
      const key = btn.dataset.mainMenuOpen;
      if (key) {
        const layer: HTMLElement|null = this.menu.querySelector('[data-main-menu-layer="' + key + '"]');
        if (layer) {
          btn.addEventListener('click', () => {
            layer.classList.add('is-active');
            if (key === 'wrapper') {
              document.body.classList.add('overflow-hidden');
            }
          });
        }
      }
    });

    this.closeBtns.forEach((btn) => {
      const key = btn.dataset.mainMenuClose;
      if (key) {
        const layer: HTMLElement|null = this.menu.querySelector('[data-main-menu-layer="' + key + '"]');
        if (layer) {
          btn.addEventListener('click', () => {
            layer.classList.remove('is-active');
            if (key === 'wrapper') {
              document.body.classList.remove('overflow-hidden');
              this.layers.forEach((l) => {
                l.classList.remove('is-active');
              });
            }
          });
        }
      }
    });
  }
}
