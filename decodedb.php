<?php
include_once 'src/php/header.php';
?>
    <link rel="stylesheet" type="text/css" href="src/css/decodedb.css">

    <div class="login_wrapper">
        <div class="title">Вход в аккаунт</div>
        <form id="decodeForm">
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

    <script src="/src/js/decodedb.js"></script>
<?php
include_once 'src/php/footer.php';
?>