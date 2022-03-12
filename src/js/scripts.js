function logout() {
  document.cookie = `login=o;max-age=1;path=/`;
  document.cookie = `secret=o;max-age=1;path=/`;

  fetch('/back/scripts/logout.php', {
    mode: "no-cors",
    method: 'GET',
  }).then(() => {
    if (window.location.pathname !== '/') {
      window.location = '/';
    }
  });
}

function getCookieUserData() {
  let loginMatch = document.cookie.match(/login=(.+?)(;|$)/);
  let secretMatch = document.cookie.match(/secret=(.+?)(;|$)/);
  if (!loginMatch || !secretMatch) {
    logout();
  }
  return {login: loginMatch[1], secret: secretMatch[1]};
}

let loginMatch = document.cookie.match(/login=(.+?)(;|$)/);
let secretMatch = document.cookie.match(/secret=(.+?)(;|$)/);

if ((!loginMatch || !secretMatch) && window.location.pathname !== '/') {
  window.location = '/';
}