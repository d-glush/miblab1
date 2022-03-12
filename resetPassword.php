<?php
    include_once 'src/php/header.php';
?>
<link rel="stylesheet" type="text/css" href="src/css/resetPassword.css">

<div class="reset_password_wrapper">
    <div class="title">Смена пароля</div>
    <form id="loginForm">
        <div>
            <label>Пароль</label>
            <input type="password" name="password">
        </div>
        <div>
            <label>Подтвердите пароль</label>
            <input type="password" name="password_approve">
        </div>
        <div>
            <button type="submit">Сменить пароль</button>
        </div>
        <div class="error" id="error">

        </div>
    </form>
</div>

<script src="/src/js/resetPassword.js"></script>
<?php
    include_once 'src/php/footer.php';
?>