{
  let loginForm = document.getElementById('loginForm');
  let errorLayout = document.getElementById('error');

  loginForm.addEventListener('submit', function (e) {
    e.preventDefault();

    let isFirstTimeSetPassword = window.location.href.match(/firstSet=(.+?)(;|$)/);

    let getParams = (new URL(document.location)).searchParams;
    let login = getCookieUserData().login;
    let oldPassword = isFirstTimeSetPassword ? '' : loginForm.old_password.value;
    let password = loginForm.password.value;
    let passwordApprove = loginForm.password_approve.value;

    if (!oldPassword && !isFirstTimeSetPassword) {
      errorLayout.innerText = 'Введите старый пароль!'
      return;
    }

    if (!password) {
      errorLayout.innerText = 'Введите пароль!'
      return;
    }

    if (password !== passwordApprove) {
      errorLayout.innerText = 'Пароли не совпадают!'
      return;
    }
    errorLayout.innerText = '';

    let data = new FormData();
    data.append('old_password', oldPassword);
    data.append('login', login);
    data.append('password', password);

    fetch('/back/scripts/resetPassword.php', {
      mode: "no-cors",
      headers: {
        'Accept': 'application/json; charset=UTF-8',
      },
      method: 'POST',
      body: data
    }).then(response => response.json())
      .then(result => {
        switch (result.code) {
          case 200:
            window.location = '/account.php';
            break;
          case 402:
            errorLayout.innerText = 'Пароль неудовлетворителен!'
            break;
          default:
            errorLayout.innerText = 'Произошла ошибка!'
        }
      })
  });
}
