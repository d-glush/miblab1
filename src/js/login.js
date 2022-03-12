{
  let loginForm = document.getElementById('loginForm');
  let errorLayout = document.getElementById('error');

  let loginTryCount = 3;

  loginForm.addEventListener('submit', function (e) {
    e.preventDefault();

    let login = loginForm.login.value;
    let password = loginForm.password.value;
    let dbSecret = loginForm.dbSecret.value;

    if (!login) {
      errorLayout.innerText = 'Введите логин!'
      return;
    }
    if (!dbSecret) {
      errorLayout.innerText = 'Введите ключ!'
      return;
    }

    let data = new FormData();
    data.append('login', login);
    data.append('password', password);
    data.append('dbSecret', dbSecret);

    fetch('/back/scripts/login.php', {
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

          case 426:
            document.cookie = `login=${login};max-age=6000;path=/`;
            document.cookie = `secret=none;max-age=6000;path=/`;
            window.location = '/resetPassword.php?login=' + login;
            errorLayout.innerText = 'Необходимо установить пароль!'
            break;

          case 4011:
            errorLayout.innerText = 'Неверный логин!';
            break;

          case 4012:
            loginTryCount--;
            errorLayout.innerText = 'Неверный Пароль! Осталось попыток: ' + loginTryCount;
            break;

          case 4013:
            errorLayout.innerText = 'Этот аккаунт был заблокирован!';
            break;

          default:
            errorLayout.innerText = 'Произошла ошибка сервера!'
        }
        return loginTryCount;
      })
      .then(tryCount => {
        if (tryCount < 1) {
          let body = document.getElementsByTagName('body')[0];
          body.style.display = 'none';
        }
      })
  });
}