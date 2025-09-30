import {MainMenu} from './components/MainMenuClass.ts';

document.addEventListener('DOMContentLoaded', () => {
  const mainMenu = document.querySelector<HTMLElement>('[data-main-menu]');
  if (mainMenu) {
    new MainMenu(mainMenu);
  }
});
