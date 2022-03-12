{
  let loginForm = document.getElementById('loginForm');
  let errorLayout = document.getElementById('error');

  loginForm.addEventListener('submit', function (e) {
    e.preventDefault();

    let getParams = (new URL(document.location)).searchParams;
    let login = getCookieUserData().login;
    let password = loginForm.password.value;
    let passwordApprove = loginForm.password_approve.value;

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
    data.append('login', login);
    data.append('password', password);

    console.log(login)

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
