<?php
    include_once 'src/php/header.php';
?>
<link rel="stylesheet" type="text/css" href="src/css/login.css">

<div class="login_wrapper">
    <div class="title">Вход в аккаунт</div>
    <form id="loginForm">
        <div>
            <label>Логин:</label>
            <input type="text" name="login">
        </div>
        <div>
            <label>Пароль:</label>
            <input type="password" name="password">
        </div>
        <div>
            <label>Секретный код БД:</label>
            <input type="password" name="dbSecret">
        </div>
        <div>
            <button type="submit">Войти</button>
        </div>
        <div class="error" id="error">

        </div>
    </form>
</div>

<script src="/src/js/login.js"></script>
<?php
    include_once 'src/php/footer.php';
?>