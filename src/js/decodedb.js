{
  let decodeForm = document.getElementById('decodeForm');
  let errorLayout = document.getElementById('error');

  decodeForm.addEventListener('submit', function (e) {
    e.preventDefault();

    let dbSecret = decodeForm.dbSecret.value;

    if (!dbSecret) {
      errorLayout.innerText = 'Введите ключ!'
      return;
    }

    let data = new FormData();
    data.append('dbSecret', dbSecret);

    fetch('/back/scripts/decodedb.php', {
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
            window.location = '/login.php';
            break;

          case 402:
            errorLayout.innerText = 'Неверный код!'
            break;

          default:
            errorLayout.innerText = 'Произошла ошибка сервера!'
        }
      })
  });
}