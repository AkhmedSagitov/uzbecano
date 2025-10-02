import { jarallax } from 'jarallax';

export class Parallax {
  target: Element;

  constructor(target: Element) {
    this.target = target;
    this.init();
  }

  init() {
    jarallax(this.target, {
      speed: 0.2,
    });
  }

}
document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('[data-parallax]').forEach((item: Element) => {
    new Parallax(item);
  });
});
