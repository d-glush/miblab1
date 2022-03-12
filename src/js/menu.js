let body = document.getElementsByTagName('body')[0];
let exitButton = document.getElementById('exit_button');
let menuButtons = document.getElementsByClassName('menu_button');

exitButton.onclick = (e)=>{
  logout();
  body.style.display = 'none';
};

for (const menuButton of menuButtons) {
  let submenu = menuButton.getElementsByClassName('submenu')
  if (!submenu) {
    continue;
  }
  submenu = submenu[0];

  menuButton.onmouseover = (e) => {
    submenu.classList.add('active');
  }
  submenu.onmouseout = (e) => {
    submenu.classList.remove('active');
  }
}
