{
  let pwdChangeBtn = document.getElementById('password_change_btn');
  pwdChangeBtn.onclick = (e)=>{
    window.location = '/resetPassword.php';
  };

  let addUserForm = document.getElementById('addUserForm');
  let errorLayout = document.getElementById('error');
  addUserForm.addEventListener('submit', function (e) {
    e.preventDefault();

    let login = addUserForm.login.value;
    if (!login) {
      errorLayout.innerText = 'Введите логин!'
      errorLayout.style.color = 'red';
      return;
    }

    let data = new FormData();
    data.append('login', login);

    fetch('/back/scripts/account.php?method=addUser', {
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
            errorLayout.innerText = 'Добавлен!';
            errorLayout.style.color = 'green';
            reloadUsers();
            break;
          case 402:
            errorLayout.innerText = 'Логин существует!';
            errorLayout.style.color = 'red';
            break;
          default:
            errorLayout.innerText = 'Ошибка!';
            errorLayout.style.color = 'red';
            break;
        }
      });
  });

  async function getUsers() {
    let response = await fetch('/back/scripts/account.php?method=getUsers', {
      mode: "no-cors",
      headers: {
        'Accept': 'application/json; charset=UTF-8',
      },
      method: 'GET',
    })
    return await response.json();
  }

  async function reloadUsers() {
    let usersData = (await getUsers()).data;
    console.log(usersData)
    let userListLayout = document.getElementsByClassName('user_list')[0];
    userListLayout.innerHTML = '';
    usersData.forEach((user) => {
      if (user.login === 'admin') return;
      userListLayout.innerHTML +=
        `<div class="user">
            <div class="user__ava">
                <img src="src/img/ava.jpg" width="50" height="50" alt="Аватарка пользователя">
            </div>
            <div class="user__data">
                <div class="user__login">Логин: <p>${user.login}</p></div>
                <div class="user__is_banned">Блокировка: <input type="checkbox" login="${user.login}" class="is_banned" ${user['is_banned'] ? 'checked="true"' : ''}></div>
                <div class="user__is__limited">Ограничение на пароль: <input type="checkbox" login="${user.login}" class="is_limited" ${user['is_password_limit'] ? 'checked="true"' : ''}></div>
            </div>
        </div>`;
    })

    async function swapBan(login) {
      let data = new FormData();
      data.append('login', login);
      let response = await fetch('/back/scripts/account.php?method=swapBan', {
        mode: "no-cors",
        headers: {
          'Accept': 'application/json; charset=UTF-8',
        },
        method: 'POST',
        body: data,
      })
      return await response.json();
    }

    async function swapLimit(login) {
      let data = new FormData();
      data.append('login', login);
      let response = await fetch('/back/scripts/account.php?method=swapLimit', {
        mode: "no-cors",
        headers: {
          'Accept': 'application/json; charset=UTF-8',
        },
        method: 'POST',
        body: data,
      })
      return await response.json();
    }

    let banButtons = document.getElementsByClassName('is_banned');
    for (const banButton of banButtons) {
      banButton.addEventListener('click', (e) => {
        let prevStatus = !banButton.checked;
        banButton.setAttribute('disabled', 'true');
        setTimeout(()=>{banButton.removeAttribute('disabled')}, 1000);
        let login = banButton.getAttribute('login');
        swapBan(login).then((response)=>{if (response.code !== 200) banButton.checked = prevStatus});
      })
    }
    let limitButtons = document.getElementsByClassName('is_limited');
    for (const limitButton of limitButtons) {
      limitButton.addEventListener('click', (e) => {
        let prevStatus = !limitButton.checked;
        limitButton.setAttribute('disabled', 'true');
        setTimeout(()=>{limitButton.removeAttribute('disabled')}, 1000);
        let login = limitButton.getAttribute('login');
        swapLimit(login).then((response)=>{if (response.code !== 200) limitButton.checked = prevStatus});
      })
    }
  }

  reloadUsers();
}
